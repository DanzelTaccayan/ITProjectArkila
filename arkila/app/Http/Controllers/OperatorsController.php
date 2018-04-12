<?php

namespace App\Http\Controllers;

use App\Member;
use PDF;
use DB;
use Carbon\Carbon;

use App\Http\Requests\OperatorRequest;

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
        DB::beginTransaction();
        try
        {
            $createdOperator = Member::create([
                'last_name'=> $request->lastName,
                'first_name' => $request->firstName,
                'middle_name' => $request->middleName,
                'contact_number' => $request->contactNumber,
                'role' => 'Operator',
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

            if($this->arrayChecker($request->children) && $this->arrayChecker($request->childrenBDay))
            {
                $children = array_combine($request->children,$request->childrenBDay);
                $createdOperator->addChildren($children);
                $createdOperator->update([
                    'number_of_children' => sizeof($children)
                ]);
            }
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return back()->withErrors('There seems to be a problem. Please try again');
        }
        DB::commit();

        return redirect(route('operators.index'))->with('success', 'Information created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  Member  $operator
     * @return \Illuminate\Http\Response
     */
    public function show(Member $operator){
        return view('operators.show',compact('operator'));
    }

    public function showProfile(Member $operator)
    {
        return view('operators.showProfile',compact('operator'));
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
        try
        {

            $operator -> update([
                'last_name'=> $request->lastName,
                'first_name' => $request->firstName,
                'middle_name' => $request->middleName,
                'contact_number' => $request->contactNumber,
                'role' => 'Operator',
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

            if($this->arrayChecker($request->children) && $this->arrayChecker($request->childrenBDay))
            {
                $children = array_combine($request->children,$request->childrenBDay);
                $operator->children()->delete();
                $operator->addChildren($children);
                $operator->update([
                    'number_of_children' => sizeof($children)
                ]);
            }
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return back()->withErrors('There seems to be a problem. Please try again');
        }
        DB::commit();

        return redirect()->route('operators.show', compact('operator'))->with('success', 'Information updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ArchiveMember $archivedOperator
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        // Start transaction!
        DB::beginTransaction();
        try
        {
            //Member Table Operator
            $operator = Member::find($archivedOperator->operator_id);

            if(count($operator->drivers)){
                $operator->drivers()->update(['operator_id'=>null]);
            }
            $operator->van()->detach();
            $operator->delete();

            //Archived Table Operator
            $archivedOperator->archiveVan()->detach();
            $archivedOperator->delete();
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return back()->withErrors($e->getMessage());
        }
        DB::commit();

        return back();
    }

    private function arrayChecker($array)
    {
        $result = true;

        if (is_array($array) || is_object($array))
        {
            foreach($array as $arrayContent)
            {
                if(is_null($arrayContent))
                {
                    $result = false;
                    break;
                }
            }
        }
        else
        {
            $result= false;
        }

        return $result;
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

    public function archiveOperator(Member $archive)
    {

        // Start transaction!
        DB::beginTransaction();
        try
        {
            //Count the drivers of the operator and archive them
            if($archive->drivers()->count())
            {
                foreach($archive->drivers as $driver){
                    $driver->archivedOperator()->attach($archive->member_id);
                    $driver->update([
                        'operator_id' => null
                    ]);
                }
            }

            //Count the vans of the operator and archive them
            if($archive->van()->count())
            {
                foreach($archive->van as $van){

                    //archive operator and van
                    $van->archivedMember()->attach($archive->member_id);
                    $van->members()->detach($archive->member_id);
                    //archive the driver and van
                    if($van->driver()->first()){
                        $van->archivedMember()->attach($van->driver()->first()->member_id);
                        $van->members()->detach($van->driver()->first()->member_id);
                    }

                    $van->update([
                        'status' => 'Inactive'
                    ]);
                }
            }
            $date_archived = Carbon::now('Asia/Manila')->toDateTimeString();
            $archive->update([
                'status' => 'Inactive',
                'notification' => 'Disable',
                'date_archived' => $date_archived
            ]);
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return back()->withErrors('There seems to be a problem. Please try again');
        }

        DB::commit();

        return redirect(route('operators.index'));
    }

    public function restoreArchivedOperator(Member $archivedOperator)
    {
        // Start transaction!
        DB::beginTransaction();
        try{
            $archivedOperator->update([
                'status' => 'Active',
                'date_archived' => null
            ]);
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return back()->withErrors('There seems to be a problem. Please try again');
        }
        DB::commit();
        return back();
    }

}