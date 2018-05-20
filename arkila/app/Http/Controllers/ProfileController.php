<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;
use App\Destination;
use App\Fee;
use App\Rules\checkContactNum;
use App\Rules\checkAddress;



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
    public function edit(Profile $profile)
    {
        return view('profile.edit', compact('profile'));        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Profile $profile)
    {
        $this->validate(request(), [
            'contactNumber' => ['bail',new checkContactNum],
            'address' => ['bail','required','max:100',new checkAddress],
            'email' => "email|max:50",
        ]);
        
        $profile->update([
            'contact_number' => request('contactNumber'),
            'address' => request('address'),
            'email' => request('email'),
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
