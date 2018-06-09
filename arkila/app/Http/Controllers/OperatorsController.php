<?php

namespace App\Http\Controllers;

use App\Http\Requests\OperatorRequest;
use App\Member;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use PDF;
use Carbon\Carbon;
use Image;
use DB;

class OperatorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $operators = Member::allOperators()->where('status','Active')->get();
        return view('operators.index', compact('operators'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('operators.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  OperatorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OperatorRequest $request)
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

            $createdOperator = Member::create([
                'profile_picture' => $profilePictureName,
                'last_name'=> $lastName,
                'first_name' => $firstName,
                'middle_name' => $middleName,
                'contact_number' => $request->contactNumber,
                'role' => 'Operator',
                'address' => $request->address,
                'provincial_address' => $request->provincialAddress,
                'gender' => $request->gender,
                'person_in_case_of_emergency' => $request->contactPerson,
                'emergency_address' => $request->contactPersonAddress,
                'emergency_contactno' => $request->contactPersonContactNumber,
                'SSS' => $request->sss,
            ]);

            if($request->operatorDriver) {
                //Add Account for the operator
                $createdUserOperator = User::create([
                    'first_name' => $createdOperator->first_name,
                    'middle_name' => $createdOperator->middle_name,
                    'last_name' => $createdOperator->last_name,
                    'username' => strtolower($createdOperator->first_name[0].$createdOperator->last_name).$createdOperator->member_id,
                    'password' => Hash::make('driver!@bantrans'),
                    'user_type' => 'Driver',
                    'status' => 'enable'
                ]);

                $createdOperator->update([
                    'user_id' => $createdUserOperator->id,
                    'license_number' => $request->licenseNo,
                    'expiry_date' => $request->licenseExpiryDate,
                ]);
            }

            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            Log::info($e);
            return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
        }

        return redirect(route('operators.index'))->with('success', 'Operator '. $firstName .' '. $middleName .' '.$lastName .' has been successfully registered');
    }

    /**
     * Display the specified resource.
     *
     * @param  Member  $operator
     * @return \Illuminate\Http\Response
     */
    public function show(Member $operator)
    {
        return view('operators.show',compact('operator'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Member $operator
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $operator)
    {
        return view('operators.edit', compact('operator'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  OperatorRequest  $request
     * @param  Member  $operator
     * @return \Illuminate\Http\Response
     */
    public function update(Member $operator, OperatorRequest $request)
    {

        // Start transaction!
        DB::beginTransaction();
        try {
            $profilePictureName = 'avatar.png';
            if($request->file('profilePicture')) {
                if(File::exists(public_path('uploads/profilePictures/'.$operator->profile_picture)) && $operator->profile_picture != 'avatar.png') {

                    File::delete(public_path('uploads/profilePictures/'.$operator->profile_picture));
                }

                $dateNow = Carbon::now();
                $profilePictureName = $request->lastName[0].$request->firstName[0].$dateNow->month.'_'.$dateNow->day.'_'.$dateNow->year.rand(1,1000).'.'.
                    $request->file('profilePicture')->getClientOriginalExtension();

                Image::make($request->file('profilePicture'))
                    ->resize(300, 300)
                    ->save( public_path('uploads/profilePictures/'.$profilePictureName));
            }

            $operator -> update([
                'last_name' =>$request->lastName,
                'first_name' =>$request->firstName,
                'middle_name' =>$request->middleName,
                'profile_picture' => $profilePictureName,
                'contact_number' => $request->contactNumber,
                'address' => $request->address,
                'provincial_address' => $request->provincialAddress,
                'person_in_case_of_emergency' => $request->contactPerson,
                'emergency_address' => $request->contactPersonAddress,
                'emergency_contactno' => $request->contactPersonContactNumber,
                'SSS' => $request->sss,
                'license_number' => $request->licenseNo,
                'expiry_date' => $request->licenseExpiryDate,
            ]);

            //check if the operator is an operator/driver
            if($operator->user) {
                //If it is, then check if the operatorDriver checkbox in unchecked
                if(is_null($request->operatorDriver)) {
                    //Delete the operator's account
                    $operator->user->delete();

                    //Update the operators license
                    $operator->update([
                        'user_id' => null,
                        'license_number' => null,
                        'expiry_date' => null
                    ]);
                }
            } else {
                if($request->operatorDriver) {
                    //Add Account for the operator
                    User::create([
                        'first_name' => $operator->first_name,
                        'middle_name' => $operator->middle_name,
                        'last_name' => $operator->last_name,
                        'username' => strtolower($operator->first_name[0].$operator->last_name).$operator->member_id,
                        'password' => Hash::make('driver!@bantrans'),
                        'user_type' => 'Driver',
                        'status' => 'enable'
                    ]);

                    $operator->update([
                        'user_id' => $operator->id,
                        'license_number' => $request->licenseNo,
                        'expiry_date' => $request->licenseExpiryDate,
                    ]);
                }
            }

            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            Log::info($e);
            return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
        }

        return redirect()->route('operators.show', compact('operator'))->with('success', 'Operator '. $operator->full_name . ' successfully updated');
    }

    public function generatePDF()
    {
        $date = Carbon::now();
        $operators = Member::allOperators()->get();
        $pdf = PDF::loadView('pdf.operators', compact('operators', 'date'));
        return $pdf->stream('operators.pdf');
    }

    public function generatePerOperator(Member $operator)
    {
        $date = Carbon::now();
        $pdf = PDF::loadView('pdf.perOperator', compact('operator', 'date'));
        return $pdf->stream("$operator->last_name"."$operator->first_name-Bio-Data.pdf");
    }

}