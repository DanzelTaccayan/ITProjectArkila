<?php

namespace App\Http\Controllers\CustomerModuleControllers;

use App\VanRental;
use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use DB;

class ViewTransactionsController extends Controller
{
    public function viewTransactions()
    {
    	$rentals = VanRental::where('user_id', Auth::id())->orderBy('van_rental.created_at', 'desc')->get();
    	$reservations = Reservation::orderBy('reservation.created_at', 'desc')->where('user_id', Auth::id())->get();

    	return view('customermodule.user.transactions.customerTransactions', compact('rentals', 'reservations'));
    }

    public function cancelRental(Rental $rental)
    {
        // Start transaction!
        DB::beginTransaction();
        try  {
            $rental->update([
                'status' => 'Cancelled',
            ]);
            DB::commit();
            return back()->with('success','Your rental has been cancelled successfully');
        } catch(\Exception $e) {
            DB::rollback();
            \Log::info($e);

            return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
        }

    }

    public function destroyRental(Rental $rental)
    {
        // Start transaction!
        DB::beginTransaction();
        try  {
            $rental->update([
                'status' => 'Cancelled',
            ]);
            DB::commit();
            return back()->with('success','Rental has been deleted successfully');
        } catch(\Exception $e) {
            DB::rollback();
            \Log::info($e);
            return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
        }
    }

    public function destroyReservation(Reservation $reservation)
    {
        // Start transaction!
        DB::beginTransaction();
        try  {
            $reservation->delete();

            DB::commit();
            return back()->with('success', 'Reservation has been deleted successfully');
        } catch(\Exception $e) {
            DB::rollback();
            \Log::info($e);

            return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
        }

    }
}
