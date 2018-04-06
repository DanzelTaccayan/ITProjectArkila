<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rental;
use Carbon\Carbon;
use App\Van;
use App\VanModel;
use App\Http\Requests\RentalRequest;
use Illuminate\Validation\Rule;

class RentalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $rentals = Rental::all();
        $vans = Van::all();
        return view('rental.index', compact('vans', 'rentals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $models = VanModel::all();
        return view('rental.create', compact('models'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RentalRequest $request)
    {
        if($request->model == null) {

            $lastName = ucwords(strtolower($request->lastName));
            $firstName = ucwords(strtolower($request->firstName));
            $middleName = ucwords(strtolower($request->middleName));

            Rental::create([
                'last_name' => $lastName,
                'first_name' => $firstName,
                'middle_name' => $middleName,
                'departure_date' => $request->date,
                'departure_time' => $request->time,
                'destination' => $request->destination,
                'number_of_days' => $request->days,
                'contact_number' => $request->contactNumber,
                'rent_type' => 'Walk-in',
                'status' => 'Pending',

            ]);
        } else {

            $findModel = VanModel::all();
            $modelReq = $request->model;
            foreach ($findModel->where('description', $modelReq) as $find) {
                $findModelID = $find->model_id;
            }

            $lastName = ucwords(strtolower($request->lastName));
            $firstName = ucwords(strtolower($request->firstName));
            $middleName = ucwords(strtolower($request->middleName));

            Rental::create([
                'last_name' => $lastName,
                'first_name' => $firstName,
                'middle_name' => $middleName,
                'model_id' => $findModelID,
                'departure_date' => $request->date,
                'departure_time' => $request->time,
                'destination' => $request->destination,
                'number_of_days' => $request->days,
                'contact_number' => $request->contactNumber,
                'rent_type' => 'Walk-in',
                'status' => 'Pending',

            ]);
        }

        return redirect('/home/rental/')->with('success', 'Rental request from ' . $request->lastName . ', ' . $request->firstName . ' was created successfully');

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Rental $rental)
    {
      $this->validate(request(),[
        "click" => [
          'required',
          Rule::in(['Accepted', 'Declined', 'Departed', 'Pending', 'Cancelled', 'Expired'])
        ],
      ]);
        $rental->update([
            'status' => request('click'),
        ]);
        return redirect()->back()->with('success', 'Rental requested by ' . $rental->full_name . ' was marked as '. request('click'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rental $rental)
    {
        $rental->delete();
        return back()->with('message', 'Successfully Deleted');

    }
}
