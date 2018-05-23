<?php

namespace App\Http\Controllers;

use App\Destination;
use App\Rules\checkDriver;
use App\Rules\checkPlateNumber;
use App\Rules\checkOperator;
use App\Rules\checkSpecialCharacters;
use App\Rules\checkVanModel;
use App\Trip;
use App\Van;
use App\Member;
use App\VanModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use PDF;



class VansController extends Controller
{
    protected $mainTerminal;

    public function __construct()
    {
        $this->mainTerminal = Destination::where('is_main_terminal',1)->first();
    }

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
    public function create()
    {
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

    public function store()
    {
        $this->validate(request(), [
            "operator" => ['required','numeric','exists:member,member_id',new checkOperator],
            "driver" => ['nullable','numeric','exists:member,member_id',new checkDriver],
            "plateNumber" => [new checkSpecialCharacters,new checkPlateNumber,'required','max:15'],
            "vanModel" =>  ['required','max:30',new checkSpecialCharacters],
            "seatingCapacity" => 'required|numeric'
        ]);

        // Start transaction!
        DB::beginTransaction();
        try
        {
            if($model= VanModel::where('description',request('vanModel'))->first())
            {
                $vanModel = $model;
            }
            else
            {
                $vanModel = VanModel::create([
                    'description' => request('vanModel')
                ]);
            }

            $van = Van::create([
                'plate_number' => request('plateNumber'),
                'model_id' => $vanModel->model_id,
                'seating_capacity' => request('seatingCapacity'),
                'location' => $this->mainTerminal->destination_name
            ]);

            $van->members()->attach(request('operator'));

            if(request('addDriver') === 'on')
            {
                session(['type' => 'createFromIndex']);
                DB::commit();
                return redirect(route('drivers.createFromVan',[$van->van_id]));
            }
            else
            {
                if($newDriver = Member::find(request('driver')))
                {

                    if ($newDriver->operator_id == null)
                    {
                        $newDriver->update([
                            'operator_id' => request('operator')
                        ]);
                    }

                    if ($newDriver->van()->first() != null)
                    {
                        $newDriver->van()->detach();
                    }

                    $van->members()->attach($newDriver);
                }

            }
            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollback();
            \Log::info($e);
            return back()->withErrors('There seems to be a problem. Please try again, If the problem persist contact an admin to fix the issue');
        }
        return redirect(route('vans.index'));
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
            "driver" => ['nullable','numeric','exists:member,member_id',new checkDriver],
            "plateNumber" => [new checkSpecialCharacters,new checkPlateNumber,'required','max:15'],
            "vanModel" =>  ['required','max:30',new checkSpecialCharacters],
            "seatingCapacity" => 'required|numeric'
        ]);

        // Start transaction!
        DB::beginTransaction();
        try
        {
            if($model= VanModel::where('description',request('vanModel'))->first())
            {
                $vanModel = $model;
            }
            else
            {
                $vanModel = VanModel::create([
                    'description' => request('vanModel')
                ]);
            }

            $van = Van::create([
                'plate_number' => request('plateNumber'),
                'model_id' => $vanModel->model_id,
                'seating_capacity' => request('seatingCapacity'),
                'location' => $this->mainTerminal->destination_name
            ]);

            $van->members()->attach($operator->member_id);
            session()->flash('message','Van successfully created');

            if(request('addDriver') != 'on')
            {
                if($newDriver = Member::find(request('driver')))
                {
                    if ($newDriver->operator_id == null)
                    {
                        $newDriver->update([
                            'operator_id' => request('operator')
                        ]);
                    }

                    if ($newDriver->van()->first() != null)
                    {
                        $newDriver->van()->detach();
                    }
                    $van->members()->attach($newDriver);
                }
            }
            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return back()->withErrors('There seems to be a problem. Please try again There seems to be a problem. Please try again, If the problem persist contact an admin to fix the issue');
        }

        if(request('addDriver') === 'on')
        {
            session(['type' => $operator->member_id]);
            return redirect(route('drivers.createFromVan',[$van->van_id]));
        }
        else
        {
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
    public function update(Van $van)
    {

        if(request('addDriver') != 'on')
        {
            $this->validate(request(), [
                "driver" => ['nullable','numeric','exists:member,member_id',new checkDriver],
                "operator" => ['required','exists:member,member_id', new checkOperator]
            ]);

            // Start transaction!
            DB::beginTransaction();
            try
            {
                //Archiving
                if($van->operator()->first())
                {
                    if(request('operator') == $van->operator()->first()->member_id)
                    {
                        //check if the van has a past driver
                        if($van->driver()->first())
                        {
                            if(request('driver') != $van->driver()->first()->member_id)
                            {
                                //archive the relationship of the van and the driver
                                $van->archivedMember()->attach($van->driver()->first()->member_id);
                            }
                        }

                    }
                    else
                    {
                        //Archive the old operator and van
                        $van->archivedMember()->attach($van->operator()->first()->member_id);

                        //Archive the relationship of the old operator and driver
                        if($van->driver()->first())
                        {
                            $van->driver()->first()->archivedOperator()->attach($van->operator()->first()->member_id);

                            if(request('driver') != $van->driver()->first()->member_id)
                            {
                                //archive the relationship of the van and the driver
                                $van->archivedMember()->attach($van->driver()->first()->member_id);
                            }
                        }
                    }
                }

                //Find the past Operator and Driver
                $driver = $van->driver()->first();
                $operator = $van->operator()->first();

                //Detach the driver and Operator
                if($driver)
                {
                    $van->members()->detach($driver->member_id);
                }
                $van->members()->detach($operator->member_id);

                //Find the New Operator then attach it to the van
                $newOperator = Member::find(request('operator'));
                $van->members()->attach($newOperator->member_id);

                if(!is_null(request('driver')))
                {
                    //Find the New Driver then check if it has any operator, then update its operator and attach the new driver to the van
                    $newDriver = Member::find(request('driver'));
                    $newDriver->update([
                        'operator_id' => $van->operator()->first()->member_id
                    ]);
                    if($newDriver->van()->first() != null)
                    {
                        $newDriver->van()->detach();
                    }
                    $van->members()->attach($newDriver);
                }
                DB::commit();
                session()->flash('message','Van '.request('plateNumber').'Successfully Edited');
            }
            catch(\Exception $e)
            {
                DB::rollback();
                return back()->withErrors('There seems to be a problem. Please try again There seems to be a problem. Please try again, If the problem persist contact an admin to fix the issue');
            }

            if(session()->get('opLink'))
            {
                return redirect(session()->get('opLink'));
            }
            else
            {
                return redirect(route('vans.index'));
            }
        }
        else
        {
            if(session()->get('opLink'))
            {
                session(['type' => $van->operator->first()->member_id]);
            }
            else
            {
                session(['type' => 'createFromIndex']);
            }
            return redirect(route('drivers.createFromVan',[$van->van_id]));
        }
    }

    public function listDrivers()
    {
        $operator = Member::find(request('operator'));

        if($operator != null)
        {
            $driversArr = [];
            $driverOP = $operator->drivers()->where('status','Active')->get();
            $driverNoOP = Member::allDrivers()->where('status','Active')->whereNull('operator_id')->get();

            $drivers = $driverOP->merge($driverNoOP);

            foreach($drivers as $driver)
            {
                if(request('vanDriver'))
                {
                    if($driver->member_id != request('vanDriver'))
                    {
                        array_push($driversArr, [
                            "id" => $driver->member_id,
                            "name" => $driver->full_name
                        ]);
                    }
                }
                else
                {
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

    public function vanInfo()
    {
        $van = Van::find(request('van'));

        $vanModel = $van->vanModel->description;

        if($van != null){
            $vanInfo = [
                'plateNumber' => $van->van_id,
                'vanModel' => $vanModel,
                'seatingCapacity' => $van->seating_capacity,
                'operatorOfVan' => $van->operator()->first()->full_name,
                'driverOfVan' => $van->driver()->first()->full_name ?? null
            ];

            return response()->json($vanInfo);
        }
        else
        {
            return "Van not found";
        }
    }

    public function checkDriverVan()
    {
        if(request('driver') != null){
            $driver = Member::find(request('driver'))->van;
            if(count($driver) >= 1){
                return 'modal';
            }else{
                return 'submit';
            }
        }
        
    }

    public function generatePDF()
    {
        $date = Carbon::now();
        $vans = Van::all();
        $pdf = PDF::loadView('pdf.van', compact('vans', 'date'));
        return $pdf->stream('listOfVans.pdf');
    }
 }


