<?php

namespace App\Http\Controllers;

use App\Rules\checkDriver;
use App\Rules\checkOperator;
use App\Van;
use App\Member;

class VansController extends Controller {


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vans = Van::all();

        return view('vans.index', compact('vans'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $operators = Member::allOperators()->get();
        return view('vans.create',compact('operators'));
    }

    public function createFromOperator(Member $operator)
    {
        $drivers = $operator->drivers()->doesntHave('van')->get();

        return view('vans.create',compact('drivers','operator'));
    }



    public function store(){
        $this->validate(request(), [
            "operator" => ['numeric','exists:member,member_id',new checkOperator],
            "driver" => ['nullable','numeric','exists:member,member_id',new checkDriver],
            "plateNumber" => ['unique:van,plate_number','required','between:6,8'],
            "vanModel" =>  'required',
            "seatingCapacity" => 'required|between:2,15|numeric'
        ]);

        $van = Van::create([
            'plate_number' => request('plateNumber'),
            'model' => request('vanModel'),
            'seating_capacity' => request('seatingCapacity')
        ]);
        $van->members()->attach(request('operator'));

        if(request('addDriver') === 'on'){
            return redirect(route('drivers.createFromVan',[$van->plate_number]));
        }
        else{

            $van->members()->attach(request('driver'));
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
            "plateNumber" => 'unique:van,plate_number|required|between:6,8',
            "vanModel" =>  'required',
            "seatingCapacity" => 'required|between:2,15|numeric'
        ]);


        $van = Van::create([
            'plate_number' => request('plateNumber'),
            'model' => request('vanModel'),
            'seating_capacity' => request('seatingCapacity')
        ]);

        $van->members()->attach($operator->member_id);
        session()->flash('message','Van successfully created');

        if(request('addDriver') === 'on'){
            return redirect(route('drivers.createFromVan',[$van->plate_number]));
        }else{
            $van->members()->attach(request('driver'));
            return redirect(route('operators.showProfile',[$operator->member_id]));
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Van $van)
    {
        return view('vans.show', compact('van'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Van $van)
    {
        $operators = Member::allOperators()->get();
        return view('vans.edit', compact('van','operators'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Van $van)
    {

        $this->validate(request(), [
            "driver" => ['nullable','numeric','exists:member,member_id',new checkDriver],
        ]);
        $driver = $van->driver()->first();

        if($driver){
            $van->members()->detach($driver->member_id);
        }

        $van->members()->attach(request('driver'));

    	session()->flash('message','Van '.request('plateNumber').'Successfully Edited');
    	return back();
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
            $drivers = $operator->drivers()->doesntHave('van')->get();
            foreach($drivers as $driver){
                array_push($driversArr, [
                    "id" => $driver->member_id,
                    "name" => $driver->full_name
                ]);
            }
            return response()->json($driversArr);
        }
        else{
            return "Operator Not Found";
        }


    }

    public function vanInfo(){
        $van = Van::find(request('van'));

        if($van != null){
            $vanInfo = [
                'plateNumber' => $van->plate_number,
                'vanModel' => $van->model,
                'seatingCapacity' => $van->seating_capacity,
                'operatorOfVan' => $van->operator()->first()->full_name,
                'driverOfVan' => $van->driver()->first()->full_name ?? $van->driver()->first()
            ];

            return response()->json($vanInfo);
        }
        else{
            return "Van not found";
        }
    }
}

