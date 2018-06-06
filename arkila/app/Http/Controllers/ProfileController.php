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
use DB;



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
    public function update(Profile $company_profile)
    {
        $this->validate(request(), [
            'contactNumber' => ['bail',new checkContactNumber],
            'address' => ['bail','max:100'],
            'email' => "nullable|email|max:50",
            'openTime' => 'required|date_format:H:i',
            'closeTime' => 'required|date_format:H:i',
        ]);

        // Start transaction!
        DB::beginTransaction();
        try  {
            $company_profile->update([
                'contact_number' => request('contactNumber'),
                'address' => request('address'),
                'email' => request('email'),
                'open_time' => request('openTime'),
                'close_time' => request('closeTime'),
            ]);
            DB::commit();
            return redirect('/home/company-profile')->with('success', 'Profile has been successfully updated');
        } catch(\Exception $e) {
            DB::rollback();
            \Log::info($e);

            return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
        }
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
