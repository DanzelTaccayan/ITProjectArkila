<?php

namespace App\Http\Controllers;

use App\Rules\checkDriver;
use App\Rules\checkPlateNumber;
use App\Rules\checkOperator;
use App\Rules\checkVanModel;
use App\Van;
use App\Member;
use App\VanModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;



class VansController extends Controller {


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vans = Van::where('status','Active')->get();
        return view('vans.index', compact('vans'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $operators = Member::allOperators()->where('status','Active')->get();
        $models = VanModel::all();
        return view('vans.create',compact('operators','models'));
    }

    public function createFromOperator(Member $operator)
    {
        $drivers = $operator->drivers()->doesntHave('van')->where('status','Active')->get();
        $models = VanModel::all();
        return view('vans.create',compact('drivers','operator','models'));
    }



    public function store(){
        $this->validate(request(), [
            "operator" => ['required','numeric','exists:member,member_id',new checkOperator],
            "driver" => ['nullable','numeric','exists:member,member_id',new checkDriver],
            "plateNumber" => [new checkPlateNumber,'unique:van,plate_number','required','between:6,9'],
            "vanModel" =>  ['required','max:30',new checkVanModel],
            "seatingCapacity" => 'required|between:10,15|numeric'
        ]);

        if($model= VanModel::where('description',request('vanModel'))->first()){
            $vanModel = $model;
        }
        else{
            $vanModel = VanModel::create([
                'description' => request('vanModel')
            ]);
        }

        $van = Van::create([
            'plate_number' => request('plateNumber'),
            'model_id' => $vanModel->model_id,
            'seating_capacity' => request('seatingCapacity')
        ]);

        $van->members()->attach(request('operator'));

        if(request('addDriver') === 'on'){
            session(['type' => 'createFromIndex']);
            return redirect(route('drivers.createFromVan',[$van->plate_number]));
        }
        else{
            if($newDriver = Member::find(request('driver'))){

                if ($newDriver->operator_id == null) {
                    $newDriver->update([
                        'operator_id' => request('operator')
                    ]);
                }

                if ($newDriver->van()->first() != null) {
                    $newDriver->van()->detach();
                }

                $van->members()->attach($newDriver);
            }
            return redirect(route('vans.index'));
        }
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeFromOperator(Member $operator)
    {
        $this->validate(request(), [
            "driver" => ['nullable','numeric','exists:member,member_id','unique:member_van,member_id',new checkDriver],
            "plateNumber" => [new checkPlateNumber,'unique:van,plate_number','required','between:6,9'],
            "vanModel" =>  ['required','max:30',new checkVanModel],
            "seatingCapacity" => 'required|between:10,15|numeric'
        ]);

        if($model= VanModel::where('description',request('vanModel'))->first()){
            $vanModel = $model;
        }
        else{
            $vanModel = VanModel::create([
                'description' => request('vanModel')
            ]);
        }

        $van = Van::create([
            'plate_number' => request('plateNumber'),
            'model_id' => $vanModel->model_id,
            'seating_capacity' => request('seatingCapacity')
        ]);

        $van->members()->attach($operator->member_id);
        session()->flash('message','Van successfully created');

        if(request('addDriver') === 'on'){
            session(['type' => $operator->member_id]);
            return redirect(route('drivers.createFromVan',[$van->plate_number]));
        }else{
            if($newDriver = Member::find(request('driver'))) {
                if ($newDriver->operator_id == null) {
                    $newDriver->update([
                        'operator_id' => request('operator')
                    ]);
                }

                if ($newDriver->van()->first() != null) {
                    $newDriver->van()->detach();
                }
                $van->members()->attach($newDriver);
            }

            return redirect(route('operators.showProfile',[$operator->member_id]));
        }


    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Van $van)
    {
        $operators = Member::allOperators()->where('status','Active')->get();
        $drivers = Member::allDrivers()->where('status','Active')->get();
        return view('vans.edit', compact('van','operators','drivers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Van $van) {
        //$current_time = \Carbon\Carbon::now();
       // $dateNow = $current_time->setTimezone('Asia/Manila')->format('Y-m-d H:i:s');

        // $oldVan = $van->driver()->first()->member_id ?? $van->driver()->first();
        // $newVan = $request->driver;

        // // $plate = $request->pla

        // if ($oldVan != $newVan)
        // {
        //     $mem = $van->plate_number;
        //     $rep = Van::find($mem);
        //     $newRep = $rep->replicate();
        //     $newRep->plate_number = 
        //     $newRep->status = 'Inactive';
        //     $newRep->created_at = $dateNow;
        //     $newRep->save();

        // }

        if(request('addDriver') != 'on'){
            $this->validate(request(), [
                "driver" => ['nullable','numeric','exists:member,member_id',new checkDriver],
                "operator" => ['required','exists:member,member_id', new checkOperator]
            ]);

            //Find the past Operator and Driver
            $driver = $van->driver()->first();
            $operator = $van->operator()->first();

            //Detach the driver and Operator
            if($driver){
                $van->members()->detach($driver->member_id);
            }
            $van->members()->detach($operator->member_id);

            //Find the New Operator then attach it to the van
            $newOperator = Member::find(request('operator'));
            $van->members()->attach($newOperator->member_id);

            if(!is_null(request('driver'))) {
                //Find the New Driver then check if it has any operator, then update its operator and attach the new driver to the van
                $newDriver = Member::find(request('driver'));
                $newDriver->update([
                    'operator_id' => $van->operator()->first()->member_id
                ]);
                if($newDriver->van()->first() != null){
                    $newDriver->van()->detach();
                }
                $van->members()->attach($newDriver);
            }

            session()->flash('message','Van '.request('plateNumber').'Successfully Edited');

            if(session()->get('opLink')){
                return redirect(session()->get('opLink'));
            }
            else{
                return redirect(route('vans.index'));
            }

        }
        else{
            if(session()->get('opLink')){
                session(['type' => $van->operator->first()->member_id]);
            }else{
                session(['type' => 'createFromIndex']);
            }
            return redirect(route('drivers.createFromVan',[$van->plate_number]));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Van $van)
    {
        $van->members()->detach();
        $van->delete();
    	return back();

    }

    public function listDrivers(){
        $operator = Member::find(request('operator'));

        if($operator != null) {
            $driversArr = [];
            $driverOP = $operator->drivers()->where('status','Active')->get();
            $driverNoOP = Member::allDrivers()->where('status','Active')->whereNull('operator_id')->get();

            $drivers = $driverOP->merge($driverNoOP);

            foreach($drivers as $driver){
                if(request('vanDriver')){
                    if($driver->member_id != request('vanDriver')){
                        array_push($driversArr, [
                            "id" => $driver->member_id,
                            "name" => $driver->full_name
                        ]);
                    }
                }else{
                    array_push($driversArr, [
                        "id" => $driver->member_id,
                        "name" => $driver->full_name
                    ]);
                }
            }
            return response()->json($driversArr);
        }
        else{
            return "Operator Not Found";
        }


    }

    public function vanInfo(){
        $van = Van::find(request('van'));

        $vanModel = $van->vanModel->description;

        if($van != null){
            $vanInfo = [
                'plateNumber' => $van->plate_number,
                'vanModel' => $vanModel,
                'seatingCapacity' => $van->seating_capacity,
                'operatorOfVan' => $van->operator()->first()->full_name,
                'driverOfVan' => $van->driver()->first()->full_name ?? null
            ];

            return response()->json($vanInfo);
        }
        else{
            return "Van not found";
        }
    }

    public function archiveDelete(Request $request, Van $van)
    {
        $van->update([
           'status' => 'Inactive',
        ]);
        return back();

        }

    public function generatePDF()
    {
        $date = Carbon::now();
        $vans = Van::all();
        $pdf = PDF::loadView('pdf.van', compact('vans', 'date'));
        return $pdf->stream('listOfVans.pdf');
    }
 }


