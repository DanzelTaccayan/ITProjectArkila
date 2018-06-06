<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Profile;
use App\Destination;
use App\Ticket;
use App\Fee;
use App\Feature;
use App\Rules\checkTime;
use App\Rules\checkCurrency;
use DB;

class SetupController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('getting-started');
    // } 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setup =  Feature::where('description','SetUp Page')->first();
        $mainterminal = (Destination::where('is_main_terminal', true)->select('destination_name')->first() == null ? true : false);
        if($setup->status == 'enable' && $mainterminal == true){
            return view('setup.index');
        }else{
            return redirect()->back();
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            "contactNumber" => 'required|max:15',
            "email" => 'required|email|max:100',
            "address" => 'required|max:200',
            "openTime" => 'required|date_format:H:i',
            "closeTime" => 'required|date_format:H:i',
            "addMainTerminal" => 'required|unique:destination,destination_name|max:70',
            "mainBookingFee" => 'required|numeric',
            "addTerminal" => 'required|unique:destination,destination_name|max:70',
            "bookingFee" => 'required|numeric',
            "sTripFare" => ['required', new checkCurrency, 'numeric','min:1','max:5000'],
            "sdTripFare" => ['required', new checkCurrency, 'numeric','min:1','max:5000'],
            "discountedFare" => ['required', new checkCurrency, 'numeric','min:1','max:5000'],
            "regularFare" => ['required', new checkCurrency, 'numeric','min:1','max:5000'],
            "numticket" => 'required|numeric|digits_between:1,1000',
            "numticketDis" => 'required|numeric|digits_between:1,1000',
            "addFeesDescSop" => 'required|max:100',
            "addFeesDescCom" => 'required|max:100',
            "addSop" => ['required', new checkCurrency, 'numeric','min:1','max:10000'],
            "addComFund" => ['required', new checkCurrency, 'numeric','min:1','max:10000'],
        ]);

        // Start transaction!
        DB::beginTransaction();
        try  {
            $mainName = ucwords(strtolower($request->addMainTerminal));
            $destName = ucwords(strtolower($request->addTerminal));
            $address = ucwords(strtolower($request->address));
            $feeDescriptionFund = ucwords(strtolower($request->addFeesDescCom));



            $discountedTickets = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
            $disTicketCount = 0;
            $counter = 0;

            Profile::create([
                'contact_number' => $request->contactNumber,
                'email' => $request->email,
                'address' => $address,
                'open_time' => $request->openTime,
                'close_time' => $request->closeTime,
            ]);

            $mainTerminal = Destination::create([
                'destination_name' => $mainName,
                'booking_fee' => $request->mainBookingFee,
                'is_terminal' => true,
                'is_main_terminal' => true,
            ]);

            $destTerminal = Destination::create([
                'destination_name' => $destName,
                'booking_fee' => $request->bookingFee,
                'number_of_tickets' => $request->numticket,
                'is_terminal' => true,
                'is_main_terminal' => false,
                'short_trip_fare' => $request->sTripFare,
                'short_trip_fare_discount' => $request->sdTripFare,
            ]);

            $destTerminal->routeOrigin()
                ->attach($mainTerminal->destination_id, ['terminal_destination' => $destTerminal->destination_id]);

            for($c=1; $c <= $request->numticketDis; $c++)
            {
                if($disTicketCount >= 26)
                {
                    $disTicketCount = 0;
                    $counter++;
                }

                if($c <= 26)
                {
                    $ticketNumber = $destName.'-'.$discountedTickets[$disTicketCount];
                }
                else
                {
                    $ticketNumber = $destName.'-'.$discountedTickets[$disTicketCount].$counter;
                }

                $disTicketCount++;
                Ticket::create([
                    'ticket_number' => $ticketNumber,
                    'destination_id' => $destTerminal->destination_id,
                    'fare' => $request->discountedFare,
                    'type' => 'Discount'
                ]);
            }

            for($i=1; $i <= $request->numticket; $i++ )
            {
                $ticketName = $destName.'-'.$i;
                Ticket::create([
                    'ticket_number' => $ticketName,
                    'destination_id' => $destTerminal->destination_id,
                    'fare' => $request->regularFare,
                    'type' => 'Regular'
                ]);
            }

            Fee::create([
                'description' => $request->addFeesDescSop,
                'amount' => $request->addSop,
            ]);

            Fee::create([
                'description' => $feeDescriptionFund,
                'amount' => $request->addComFund,
            ]);

            $setup =  Feature::where('description','SetUp Page')->first();
            $setup->update(['status' => 'disable']);

            DB::commit();
            return redirect('/home/route')->with('success', 'Setup successfully completed!');
        } catch(\Exception $e) {
            DB::rollback();
            \Log::info($e);

            return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
