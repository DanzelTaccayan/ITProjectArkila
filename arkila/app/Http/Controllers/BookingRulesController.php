<?php

namespace App\Http\Controllers;

use App\BookingRules;
use Illuminate\Http\Request;

class BookingRulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('bookingrules.index');
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
     * @param  \App\BookingRules  $bookingRules
     * @return \Illuminate\Http\Response
     */
    public function show(BookingRules $bookingRules)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BookingRules  $bookingRules
     * @return \Illuminate\Http\Response
     */
    public function edit(BookingRules $bookingRules)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BookingRules  $bookingRules
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BookingRules $bookingRules)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BookingRules  $bookingRules
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookingRules $bookingRules)
    {
        //
    }
}
