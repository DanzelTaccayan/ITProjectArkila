<?php

namespace App\Http\Controllers;

use App\Http\Requests\DriverRequest;
use App\Member;
use App\Van;
use App\User;
use PDF;
use Carbon\Carbon;
use Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use DB;

class DriversController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drivers = Member::allDrivers()->where('status','Active')->get();

        return view('drivers.index', compact('drivers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $drivers = Member::allDrivers()->where('status','Active')->get();
        $operators = Member::allOperators()->where('status','Active')->get();
        return view('drivers.create', compact('drivers','operators'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DriverRequest $request)
    {
        // Start transaction!
        $firstName = ucwords(strtolower($request->firstName));            
        $lastName = ucwords(strtolower($request->lastName));            
        $middleName = ucwords(strtolower($request->middleName));            

        DB::beginTransaction();
        try {
            $profilePictureName = 'avatar.png';
            if($request->file('profilePicture')) {
                $dateNow = Carbon::now();
                $profilePictureName = $request->lastName[0].$request->firstName[0].$dateNow->month.'_'.$dateNow->day.'_'.$dateNow->year.rand(1,1000).'.'.
                    $request->file('profilePicture')->getClientOriginalExtension();

                Image::make($request->file('profilePicture'))
                    ->resize(300, 300)
                    ->save( public_path('uploads/profilePictures/'.$profilePictureName));
            }

            $createdDriver = Member::create([
                'profile_picture' => $profilePictureName,
                'last_name'=> $lastName,
                'first_name' => $firstName,
                'operator_id' => $request->operator,
                'middle_name' => $middleName,
                'contact_number' => $request->contactNumber,
                'role' => 'Driver',
                'address' => $request->address,
                'provincial_address' => $request->provincialAddress,
                'gender' => $request->gender,
                'person_in_case_of_emergency' => $request->contactPerson,
                'emergency_address' => $request->contactPersonAddress,
                'emergency_contactno' => $request->contactPersonContactNumber,
                'SSS' => $request->sss,
                'license_number' => $request->licenseNo,
                'expiry_date' => $request->licenseExpiryDate,
            ]);

            //Add Account for the driver
            $createdUserDriver = User::create([
                'first_name' => $createdDriver->first_name,
                'middle_name' => $createdDriver->middle_name,
                'last_name' => $createdDriver->last_name,
                'username' => strtolower($createdDriver->first_name[0].$createdDriver->last_name).$createdDriver->member_id,
                'password' => Hash::make('driver!@bantrans'),
                'user_type' => 'Driver',
                'status' => 'enable'
            ]);

            $createdDriver->update([
                'user_id' => $createdUserDriver->id,
            ]);

            DB::commit();
        } catch(\Exception $e) {
            \Log::info($e);
            DB::rollback();
            return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
        }

        return redirect(route('drivers.index'))->with('success', 'Driver '. $createdDriver->first_name .' '. $createdDriver->middle_name .' '. $createdDriver->last_name .' has been registered successfully');
    }

    public function createFromOperator(Member $operator)
    {
        return view('drivers.create',compact('operator'));
    }

    public function storeFromOperator(Member $operator, DriverRequest $request)
    {
        $firstName = ucwords(strtolower($request->firstName));            
        $lastName = ucwords(strtolower($request->lastName));            
        $middleName = ucwords(strtolower($request->middleName));            

        // Start transaction!
        DB::beginTransaction();
        try {
            $profilePictureName = 'avatar.png';
            if($request->file('profilePicture')) {
                $dateNow = Carbon::now();
                $profilePictureName = $request->lastName[0].$request->firstName[0].$dateNow->month.'_'.$dateNow->day.'_'.$dateNow->year.rand(1,1000).'.'.
                    $request->file('profilePicture')->getClientOriginalExtension();

                Image::make($request->file('profilePicture'))
                    ->resize(300, 300)
                    ->save( public_path('uploads/profilePictures/'.$profilePictureName));
            }

            $driver = $operator->drivers()->create([
                'profile_picture' => $profilePictureName,
                'last_name'=> $lastName,
                'first_name' => $firstName,
                'middle_name' => $middleName,
                'contact_number' => $request->contactNumber,
                'role' => 'Driver',
                'address' => $request->address,
                'provincial_address' => $request->provincialAddress,
                'gender' => $request->gender,
                'person_in_case_of_emergency' => $request->contactPerson,
                'emergency_address' => $request->contactPersonAddress,
                'emergency_contactno' => $request->contactPersonContactNumber,
                'SSS' => $request->sss,
                'license_number' => $request->licenseNo,
                'expiry_date' => $request->licenseExpiryDate,
            ]);

            //Add Account for the driver
            $createdDriverUser = User::create([
                'last_name'=> $lastName,
                'first_name' => $firstName,
                'middle_name' => $middleName,
                'username' => strtolower($driver->first_name[0].$driver->last_name).$driver->member_id,
                'password' => Hash::make('driver!@bantrans'),
                'user_type' => 'Driver',
                'status' => 'enable'
            ]);

            $driver->update([
                'user_id' => $createdDriverUser->id,
            ]);
            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
        }

        return redirect('/home/operators/'.$operator->member_id.'#drivers')->with('success', 'Driver '. $driver->first_name .' '. $driver->middle_name .' '. $driver->last_name .' has been registered successfully');
    }

    public function createFromVan(Van $vanNd)
    {
        if(session()->get('type') == 'createFromIndex') {
            session(['vanBack'=> route('vans.index')]);
        } else {
            session(['vanBack'=> route('operators.show',[session()->get('type')])]);
        }
        session()->forget('type');

        return view('drivers.create',compact('vanNd'));
    }

    public function storeFromVan(Van $vanNd,DriverRequest $request)
    {
        $firstName = ucwords(strtolower($request->firstName));            
        $lastName = ucwords(strtolower($request->lastName));            
        $middleName = ucwords(strtolower($request->middleName));            

        // Start transaction!
        DB::beginTransaction();
        try {
            if(count($vanNd->driver)) {
                $vanNd->members()->detach($vanNd->driver->first()->member_id);
            }

            $profilePictureName = 'avatar.png';
            if($request->file('profilePicture')) {
                $dateNow = Carbon::now();
                $profilePictureName = $request->lastName[0].$request->firstName[0].$dateNow->month.'_'.$dateNow->day.'_'.$dateNow->year.rand(1,1000).'.'.
                    $request->file('profilePicture')->getClientOriginalExtension();

                Image::make($request->file('profilePicture'))
                    ->resize(300, 300)
                    ->save( public_path('uploads/profilePictures/'.$profilePictureName));
            }

            $driver = Member::create([
                'profile_picture' => $profilePictureName,
                'last_name'=> $lastName,
                'first_name' => $firstName,
                'middle_name' => $middleName,
                'contact_number' => $request->contactNumber,
                'role' => 'Driver',
                'operator_id' => $vanNd->operator()->first()->member_id,
                'address' => $request->address,
                'provincial_address' => $request->provincialAddress,
                'gender' => $request->gender,
                'person_in_case_of_emergency' => $request->contactPerson,
                'emergency_address' => $request->contactPersonAddress,
                'emergency_contactno' => $request->contactPersonContactNumber,
                'SSS' => $request->sss,
                'license_number' => $request->licenseNo,
                'expiry_date' => $request->licenseExpiryDate,
            ]);

            $vanNd->members()->attach($driver);

            //Add Account for the driver
            $createdDriver = User::create([
                'last_name'=> $lastName,
                'first_name' => $firstName,
                'middle_name' => $middleName,
                'username' => strtolower($driver->first_name[0].$driver->last_name).$driver->member_id,
                'password' => Hash::make('driver!@bantrans'),
                'user_type' => 'Driver',
                'status' => 'enable'
            ]);

            $driver->update([
                'user_id' => $createdDriver->id,
            ]);

            DB::commit();
        } catch(\Exception $e) {
            \Log::info($e);
            DB::rollback();
            return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
        }

        if(session()->get('vanBack') && session()->get('vanBack') == route('operators.show',[$vanNd->operator->first()->member_id])) {
            return redirect(route('operators.show',[$vanNd->operator->first()->member_id]));
        } else {
            return redirect(route('vans.index'))->with('success', 'Driver '. $createdDriver->first_name .' '. $createdDriver->middle_name .' '. $createdDriver->last_name .' and a Van has been registered successfully');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Driver  $generalDriver
     * @return \Illuminate\Http\Response
     */
    public function show(Member $generalDriver)
    {
        return view('drivers.show',compact('generalDriver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $driver)
    {
        $operators = Member::allOperators()->where('status','Active')->get();
        return view('drivers.edit', compact('driver', 'operators'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function update(DriverRequest $request, Member $driver)
    {
        // Start transaction!
        DB::beginTransaction();
        try {

            if (request('operator') !== null && $request->operator != $driver->operator_id) {
                if($driver->van()->first()) {
                    $driver->archivedVan()->attach($driver->van()->first()->plate_number);
                    $driver->van()->detach($driver->van()->first()->plate_number);
                }
                $driver->archivedOperator()->attach($driver->operator_id);
            }

            $profilePictureName = 'avatar.png';
            if($request->file('profilePicture')) {
                if(File::exists(public_path('uploads/profilePictures/'.$driver->profile_picture)) && $driver->profile_picture != "avatar.png") {
                    File::delete(public_path('uploads/profilePictures/'.$driver->profile_picture));
                }

                $dateNow = Carbon::now();
                $profilePictureName = $request->lastName[0].$request->firstName[0].$dateNow->month.'_'.$dateNow->day.'_'.$dateNow->year.rand(1,1000).'.'.
                    $request->file('profilePicture')->getClientOriginalExtension();

                Image::make($request->file('profilePicture'))
                    ->resize(300, 300)
                    ->save( public_path('uploads/profilePictures/'.$profilePictureName));
            }

            $driver->update([
                'last_name' =>$request->lastName,
                'first_name' =>$request->firstName,
                'middle_name' =>$request->middleName,
                'profile_picture' => $profilePictureName,
                'operator_id' => $request->operator,
                'contact_number' => $request->contactNumber,
                'address' => $request->address,
                'provincial_address' => $request->provincialAddress,
                'person_in_case_of_emergency' => $request->contactPerson,
                'emergency_address' => $request->contactPersonAddress,
                'emergency_contactno' => $request->contactPersonContactNumber,
                'SSS' => $request->sss,
                'license_number' => $request->licenseNo,
                'expiry_date' => $request->licenseExpiryDate
            ]);

            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
        }

        if(session()->get('opLink')) {
            $routeOP = session()->get('opLink');
            session()->forget('opLink');
            return redirect($routeOP);

        } else {
            return redirect(route('drivers.index'))->with('success', 'Driver '. $driver->full_name .' has been updated successfully');
        }
    }
    public function generatePDF()
    {
        $date = Carbon::now();
        $drivers = Member::allDrivers()->get();
        $pdf = PDF::loadView('pdf.drivers', compact('drivers', 'date'));
        return $pdf->stream('drivers.pdf');
    }

    public function generatePerDriver(Member $driver)
    {
        $date = Carbon::now();
        $pdf = PDF::loadView('pdf.perDriver', compact('driver', 'date'));
        return $pdf->stream("$driver->last_name"."$driver->first_name-Bio-Data.pdf");
    }
}
