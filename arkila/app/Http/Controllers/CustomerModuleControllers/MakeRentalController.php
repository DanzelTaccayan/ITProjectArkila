<?php

namespace App\Http\Controllers\CustomerModuleControllers;

use App\User;
use App\Ledger;
use App\VanRental;
use App\Destination;
use App\VanModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Notifications\CustomerRent;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CustomerRentalRequest;
use App\Notifications\OnlineRentalAdminNotification;

use App\Http\Controllers\Controller;

class MakeRentalController extends Controller
{
    public function __construct()
    {
      $this->middleware('online-rental');
    }

    public function createRental()
    {
      $destinations = Destination::allRoute()->get();
    	return view('customermodule.user.rental.customerRental', compact('destinations'));
    }

    public function storeRental(CustomerRentalRequest $request)
    {
      $userRequests = VanRental::where('user_id', auth()->user()->id)
      ->where(function($status){
        $status->where([
            ['status','!=', 'Departed'],
            ['status','!=', 'Expired'],
            ['status','!=', 'Refunded'],
            ['status','!=', 'No Van Available'],
            ['status','!=', 'Cancelled']
            ]);
          })->count();

      if($userRequests < 1)
      {
          $carbonDate = new Carbon($request->date);
          $departedDate = $carbonDate->format('Y-m-d');
          $destination = $request->destination;
    
          $codes = VanRental::all();
          $rentalCode = bin2hex(openssl_random_pseudo_bytes(5));
    
          foreach ($codes as $code)
          {
              $allCodes = $code->rental_code;
    
              do
              {
                  $rentalCode = bin2hex(openssl_random_pseudo_bytes(5));
    
              } while ($rentalCode == $allCodes);
          }
    
          if($request->destination == 'other')
          {
            $destination = $request->otherDestination;
          }
              $rent = VanRental::create([
                "user_id" => Auth::id(),
                "customer_name" => Auth::user()->first_name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->last_name,
                "departure_date" => $departedDate,
                "rental_code" => 'RN'.$rentalCode,
                "departure_time" => $request->time,
                "number_of_days" => $request->numberOfDays,
                "destination" => $destination,
                "contact_number" => $request->contactNumber,
                "status" => 'Pending',
                "rent_type" => 'Online',
                "comment" => $request->message !== null ? $request->message : null,
              ]);
         
          return redirect(route('customermodule.rentalTransaction'))->with('success', 'Successfully created a rental');
      }
      else
      {
        return redirect(route('customermodule.rentalTransaction'))->withErrors('Sorry, you can only request one rent at a time.');
        
      }
    }

    public function rentalTransaction()
    {
      $rentals = VanRental::all();
      $requests = VanRental::where('user_id', auth()->user()->id)->get();
  
      return view('customermodule.user.transactions.customerRental', compact('rentals', 'requests'));
    }

    public function cancelRental(VanRental $rental)
    {
      $rule = $this->rentalRules();
      $time = explode(':', $rental->departure_time);
      $dateOfRental = Carbon::parse($rental->departure_date)->setTime($time[0], $time[1], $time[2]);
      $now = Carbon::now();
      $conditionDate = $dateOfRental->subDays(1);

      if($rental->status == 'Unpaid' || $rental->status == 'Pending') {
        $rental->update([
          'status' => 'Cancelled',
          'driver_id' => null,
          'van_id' => null,
        ]);
      } elseif($rental->status == 'Paid') {
        
        Ledger::create([
          'description' => 'Cancellation Fee',
          'amount' => $rule->cancellation_fee, 
          'type' => 'Revenue',
        ]);

        if($now->gt($conditionDate)) {
          $rental->update([
            'status' => 'Cancelled',
            'refund_code' => null,
            'is_refundable' => false,
            'driver_id' => null,
            'van_id' => null,
          ]);
        } else {
          $rental->update([
            'status' => 'Cancelled',
            'is_refundable' => true,
            'driver_id' => null,
            'van_id' => null,
          ]);
        }
      }
      return back()->with('success', 'Rental marked as cancelled');
    }
    
    public function refundExpiry()
    {  
      // if the cancellation is refundable, he/she is given 7 days to refund
      // else the transaction will expired
      $rentals = VanRental::where([
        ['is_refundable', true],
        ['status', 'Cancelled']
        ])->get();

      $now = Carbon::now();

      foreach($rentals as $rental) {
        $updatedAt = Carbon::parse($rental->updated_at);
        $refundExpiry = $updatedAt->addDays(7);

        if($now->gt($refundExpiry)) {
          $rental->update([
            'is_refundable' => false,
            'refund_code' => null,
            'status' => 'Expired',
            'driver_id' => null,
            'van_id' => null,
          ]);
        }
      }
    }

    public function expiredStatus()
    {
      $rentals = VanRental::where([
        ['status', '!=', 'Cancelled'],
        ['status', '!=', 'Departed']
        ])->get();

      $now = Carbon::now();

      foreach($rentals as $rental) {

        $rule = $this->rentalRules();
        $updatedAt = Carbon::parse($rental->updated_at);
        $expired = $updatedAt->addDays($rule->valid_days);
        $createdAt = Carbon::parse($rental->created_at);
        $expiry = $createdAt->addDays($rule->valid_days);
        $time = explode(':', $rental->departure_time);
        $paidExpiry = $rental->departure_date->subDays(1)->setTime($time[0], $time[1], $time[2]);

        if($rental->status == 'Pending' && $now->gt($expiry)){
          $rental->update([
            'status' => 'No Van Available',
          ]);
        } elseif($rental->status == 'Unpaid' && $now->gt($expired)) {
          $rental->update([
            'status' => 'Expired',
            'driver_id' => null,
            'van_id' => null,
          ]);
        } elseif($rental->status == 'Paid' && $now->gt($paidExpiry)) {
          $rental->update([
            'status' => 'Cancelled',
            'is_refundable' => false,
            'refund_code' => null,
            'driver_id' => null,
            'van_id' => null,
          ]);
        }
      }
    }

    public function rentalRules()
	  {   
		  return BookingRules::where('description', 'Rental')->get()->first();;
	  } 
}
