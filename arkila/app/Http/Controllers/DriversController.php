<?php

namespace App\Http\Controllers;

use App\Member;
use App\Van;
use App\User;
use App\Http\Requests\DriverRequest;
use PDF;
use Carbon\Carbon;
use Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;


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
        $profilePictureName = 'avatar.jpg';
        if($request->file('profilePicture')){
            $dateNow = Carbon::now();
            $profilePictureName = $request->lastName[0].$request->firstName[0].$dateNow->month.'_'.$dateNow->day.'_'.$dateNow->year.rand(1,1000).'.'.
                $request->file('profilePicture')->getClientOriginalExtension();

            Image::make($request->file('profilePicture'))
                ->resize(300, 300)
                ->save( public_path('uploads/profilePictures/'.$profilePictureName));
        }
        $lastName = trim(strtoupper($request->lastName));
        $firstName = trim(strtoupper($request->firstName));
        $middleName = trim(strtoupper($request->middleName));

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
            'birth_date' => $request->birthDate,
            'birth_place' => $request->birthPlace,
            'age' => $request->birthDate,
            'gender' => $request->gender,
            'citizenship' => $request->citizenship,
            'civil_status' => $request->civilStatus,
            'spouse' => $request->nameOfSpouse,
            'spouse_birthdate' => $request->spouseBirthDate,
            'father_name' => $request->fathersName,
            'father_occupation' => $request->fatherOccupation,
            'mother_name' => $request->mothersName,
            'mother_occupation' => $request->motherOccupation,
            'person_in_case_of_emergency' => $request->contactPerson,
            'emergency_address' => $request->contactPersonAddress,
            'emergency_contactno' => $request->contactPersonContactNumber,
            'SSS' => $request->sss,
            'license_number' => $request->licenseNo,
            'expiry_date' => $request->licenseExpiryDate,
        ]);

        if(count($cleansedChildrenArray = $this->arrayChecker($request->children)) > 0 &&
            count($cleansedChildrenBDayArray = $this->arrayChecker($request->childrenBDay)) > 0)
        {
            $children = array_combine($cleansedChildrenArray,$cleansedChildrenBDayArray);
            $createdDriver->addChildren($children);
            $createdDriver->update([
                'number_of_children' => sizeof($children)
            ]);
        }

        //Add Account for the driver
        $createdUserDriver = User::create([
            'first_name' => $createdDriver->first_name,
            'middle_name' => $createdDriver->middle_name,
            'last_name' => $createdDriver->last_name,
            'username' => $createdDriver->first_name[0].$createdDriver->last_name,
            'password' => Hash::make('driver!@bantrans'),
            'user_type' => 'Driver',
            'status' => 'enable'
        ]);

        $createdDriver->update([
            'user_id' => $createdUserDriver->id,
        ]);

        return redirect(route('drivers.index'))->with('success', 'Information created successfully');
        //
    }


    public function createFromOperator(Member $operator){
        return view('drivers.create',compact('operator'));
    }

    public function storeFromOperator(Member $operator, DriverRequest $request){
        $lastName = trim(strtoupper($request->lastName));
        $firstName = trim(strtoupper($request->firstName));
        $middleName = trim(strtoupper($request->middleName));

        $profilePictureName = 'avatar.jpg';
        if($request->file('profilePicture')){
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
            'birth_date' => $request->birthDate,
            'birth_place' => $request->birthPlace,
            'age' => $request->birthDate,
            'gender' => $request->gender,
            'citizenship' => $request->citizenship,
            'civil_status' => $request->civilStatus,
            'spouse' => $request->nameOfSpouse,
            'spouse_birthdate' => $request->spouseBirthDate,
            'father_name' => $request->fathersName,
            'father_occupation' => $request->fatherOccupation,
            'mother_name' => $request->mothersName,
            'mother_occupation' => $request->motherOccupation,
            'person_in_case_of_emergency' => $request->contactPerson,
            'emergency_address' => $request->contactPersonAddress,
            'emergency_contactno' => $request->contactPersonContactNumber,
            'SSS' => $request->sss,
            'license_number' => $request->licenseNo,
            'expiry_date' => $request->licenseExpiryDate,
        ]);

        if(count($cleansedChildrenArray = $this->arrayChecker($request->children)) > 0 &&
            count($cleansedChildrenBDayArray = $this->arrayChecker($request->childrenBDay)) > 0)
        {
            $children = array_combine($cleansedChildrenArray,$cleansedChildrenBDayArray);
            $driver->addChildren($children);
            $driver->update([
                'number_of_children' => sizeof($children)
            ]);
        }


        //Add Account for the driver
        $createdDriverUser = User::create([
            'last_name'=> $request->lastName,
            'first_name' => $request->firstName,
            'middle_name' => $request->middleName,
            'username' => $driver->first_name[0].$driver->last_name,
            'password' => Hash::make('driver!@bantrans'),
            'user_type' => 'Driver',
            'status' => 'enable'
        ]);

        $driver->update([
            'user_id' => $createdDriverUser->id,
        ]);

        return redirect(route('operators.showProfile',[$operator->member_id]));
    }

    public function createFromVan(Van $vanNd){
        if(session()->get('type') == 'createFromIndex'){
            session(['vanBack'=> route('vans.index')]);
        }else{
            session(['vanBack'=> route('operators.showProfile',[session()->get('type')])]);
        }
        session()->forget('type');

        return view('drivers.create',compact('vanNd'));
    }

    public function storeFromVan(Van $vanNd,DriverRequest $request){
        if(count($vanNd->driver)){
            $vanNd->members()->detach($vanNd->driver->first()->member_id);
        }
        $lastName = trim(strtoupper($request->lastName));
        $firstName = trim(strtoupper($request->firstName));
        $middleName = trim(strtoupper($request->middleName));
        $profilePictureName = 'avatar.jpg';
        if($request->file('profilePicture')){
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
            'birth_date' => $request->birthDate,
            'birth_place' => $request->birthPlace,
            'age' => $request->birthDate,
            'gender' => $request->gender,
            'citizenship' => $request->citizenship,
            'civil_status' => $request->civilStatus,
            'spouse' => $request->nameOfSpouse,
            'spouse_birthdate' => $request->spouseBirthDate,
            'father_name' => $request->fathersName,
            'father_occupation' => $request->fatherOccupation,
            'mother_name' => $request->mothersName,
            'mother_occupation' => $request->motherOccupation,
            'person_in_case_of_emergency' => $request->contactPerson,
            'emergency_address' => $request->contactPersonAddress,
            'emergency_contactno' => $request->contactPersonContactNumber,
            'SSS' => $request->sss,
            'license_number' => $request->licenseNo,
            'expiry_date' => $request->licenseExpiryDate,
        ]);

        if(count($cleansedChildrenArray = $this->arrayChecker($request->children)) > 0 &&
            count($cleansedChildrenBDayArray = $this->arrayChecker($request->childrenBDay)) > 0)
        {
            $children = array_combine($cleansedChildrenArray,$cleansedChildrenBDayArray);
            $driver->addChildren($children);
            $driver->update([
                'number_of_children' => sizeof($children)
            ]);
        }



        $vanNd->members()->attach($driver);

        //Add Account for the driver
        $createdDriver = User::create([
            'last_name'=> $request->lastName,
            'first_name' => $request->firstName,
            'middle_name' => $request->middleName,
            'username' => $driver->first_name[0].$driver->last_name,
            'password' => Hash::make('driver!@bantrans'),
            'user_type' => 'Driver',
            'status' => 'enable',
            'model_id' => $vanNd->vanModel->model_id,
        ]);
        
         $driver->update([
            'user_id' => $createdDriver->id,
        ]);
        if(session()->get('vanBack') && session()->get('vanBack') == route('operators.showProfile',[$vanNd->operator->first()->member_id])){
            return redirect(route('operators.showProfile',[$vanNd->operator->first()->member_id]));
        }else{
            return redirect(route('vans.index'));
        }

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function show(Member $driver)
    {
        return view('drivers.show',compact('driver'));
        //
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

        //
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

            if (request('operator') !== null && $request->operator != $driver->operator_id) {
                if($driver->van()->first()){
                    $driver->archivedVan()->attach($driver->van()->first()->plate_number);
                    $driver->van()->detach($driver->van()->first()->plate_number);
                }
                $driver->archivedOperator()->attach($driver->operator_id);
            }
            $dateNow = Carbon::now()->setTimezone('Asia/Manila')->format('Y-m-d H:i:s');

        $profilePictureName = 'avatar.jpg';
        if($request->file('profilePicture'))
        {
            if(File::exists(public_path('uploads/profilePictures/'.$driver->profile_picture)))
            {

                File::delete(public_path('uploads/profilePictures/'.$driver->profile_picture));
            }

            $dateNow = Carbon::now();
            $profilePictureName = $request->lastName[0].$request->firstName[0].$dateNow->month.'_'.$dateNow->day.'_'.$dateNow->year.rand(1,1000).'.'.
                $request->file('profilePicture')->getClientOriginalExtension();

            Image::make($request->file('profilePicture'))
                ->resize(300, 300)
                ->save( public_path('uploads/profilePictures/'.$profilePictureName));
        }
        $lastName = trim(strtoupper($request->lastName));
        $firstName = trim(strtoupper($request->firstName));
        $middleName = trim(strtoupper($request->middleName));

            $driver->update([
                'profile_picture' => $profilePictureName,
                'last_name'=> $lastName,
                'first_name' => $firstName,
                'operator_id' => $request->operator,
                'middle_name' => $middleName,
                'contact_number' => $request->contactNumber,
                'role' => 'Driver',
                'address' => $request->address,
                'provincial_address' => $request->provincialAddress,
                'birth_date' => $request->birthDate,
                'birth_place' => $request->birthPlace,
                'age' => $request->birthDate,
                'gender' => $request->gender,
                'citizenship' => $request->citizenship,
                'civil_status' => $request->civilStatus,
                'spouse' => $request->nameOfSpouse,
                'spouse_birthdate' => $request->spouseBirthDate,
                'father_name' => $request->fathersName,
                'father_occupation' => $request->fatherOccupation,
                'mother_name' => $request->mothersName,
                'mother_occupation' => $request->motherOccupation,
                'person_in_case_of_emergency' => $request->contactPerson,
                'emergency_address' => $request->contactPersonAddress,
                'emergency_contactno' => $request->contactPersonContactNumber,
                'SSS' => $request->sss,
                'license_number' => $request->licenseNo,
                'expiry_date' => $request->licenseExpiryDate,
                'updated_at' => $dateNow,

            ]);

        if(count($cleansedChildrenArray = $this->arrayChecker($request->children)) > 0 &&
            count($cleansedChildrenBDayArray = $this->arrayChecker($request->childrenBDay)) > 0)
        {
            $children = array_combine($cleansedChildrenArray,$cleansedChildrenBDayArray);
            $driver->children()->delete();
            $driver->addChildren($children);
            $driver->update([
                'number_of_children' => sizeof($children)
            ]);
        }


        if(session()->get('opLink')){
            $routeOP = session()->get('opLink');
            session()->forget('opLink');
            return redirect($routeOP);

        }
        else{
            return redirect(route('drivers.index'));
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $driver)
    {
        $driver->delete();
    	return back();

    }

    private function arrayChecker($array)
    {
        $result = [];

        if (is_array($array) || is_object($array))
        {
            foreach($array as $arrayContent)
            {
                if(!is_null($arrayContent))
                {
                    array_push($result,$arrayContent);
                }
            }
        }

        return $result;
    }

    public function archiveDriver(Member $driver)
    {
        if($driver->operator_id)
        {
            $driver->archivedOperator()->attach($driver->operator_id);
            $driver->update([
               'operator_id' => null
            ]);
        }

        if($driver->van()->first())
        {
            $driver->archivedVan()->attach($driver->van()->first()->plate_number);
            $driver->van()->detach($driver->van()->first()->plate_number);
        }

        $driver->update([
            'status' => 'Inactive',
        ]);

        return back();
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

    public function restoreArchivedDriver(Member $archivedDriver)
    {
        $archivedDriver->update([
            'status' => 'Active',
            'date_archived' => null
        ]);

        return back();
    }

}
