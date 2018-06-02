<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;
use App\Destination;
use App\Fee;
use App\Rules\checkContactNumber;
use App\Rules\checkTime;
use \Carbon\Carbon;
use Validator;



class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profile = Profile::all()->first();
        $main = Destination::mainTerminal()->get()->first();
        $fees = Fee::all();
        return view('profile.index', compact('profile', 'main', 'fees'));
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
        //
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
    public function edit(Profile $company_profile)
    {
        return view('profile.edit', compact('company_profile'));       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Profile $profile, Request $request)
    {
        $request->openTime = Carbon::parse($request->openTime)->format('g:i A');
        $request->closeTime = Carbon::parse($request->closeTime)->format('g:i A');

        dd($request->openTime);

        Validator::make($request->all(), [
            'contactNumber' => ['bail',new checkContactNumber],
            'address' => ['bail','max:100'],
            'email' => "nullable|email|max:50",
            'openTime' => ['required', new checkTime],
            'closeTime' => ['required', new checkTime],
        ])->validate();
        
        $profile->update([
            'contact_number' => request('contactNumber'),
            'address' => request('address'),
            'email' => request('email'),
            'open_time' => request('openTime'),
            'close_time' => request('close_time'),
        ]);

        return redirect('/home/admin/profile')->with('success', 'Profile has been successfully edited');

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
