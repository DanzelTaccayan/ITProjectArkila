@extends('layouts.master')
@section('title', 'Trip Details')
@section('links')
@section('content')

<div class="box" style="box-shadow: 0px 5px 10px gray;">
    <div class="box-header with-border text-center">
        <a href="{{route('trips.tripLog')}}" class="pull-left btn btn-default"><i class="fa  fa-chevron-left"></i></a>
        <h3 class="box-title">
            Trip Details
        </h3>
    </div>
    <div class="box-body">
        <div class="box" >
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div style="width:70%">
                            <div class="header text-center">
                                <h4>Destination</h4>
                            </div>
                            <div class="box-body" id="inner-dest">
                              <table class="table table-bordered table-striped table-responsive">
                                <thead>
                                  <th></th>
                                  <th>#Passenger</th>
                                  <th>#Discounted</th>
                                </thead>
                                <tbody>
                                  <tr>
                                    <th>Main Terminal</th>
                                    <td>{{$numPassCountArr['mainTerminalRegular']}}</td>
                                    <td>{{$numPassCountArr['mainTerminalDiscount']}}</td>
                                  </tr>
                                  <tr>
                                    <th>Short Trip</th>
                                    <td>{{$numPassCountArr['shortTripRegular']}}</td>
                                    <td>{{$numPassCountArr['shortTripDiscount']}}</td>
                                  </tr>
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <th class="text-right">Total</th>
                                    <th class="text-right">{{$numPassCountArr['mainTerminalRegular'] + $numPassCountArr['shortTripRegular']}}</th>
                                    <th class="text-right">{{$numPassCountArr['mainTerminalDiscount'] + $numPassCountArr['shortTripDiscount']}}</th>
                                  </tr>
                                </tfoot>
                              </table>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-6">
                      <div style="width:80%">
                      <div class="header text-center">
                          <h4>Summary</h4>
                      </div>
                       <div>
                          <label>Driver:</label>
                          <name>{{$trip->driver->first_name . ' ' . $trip->driver->last_name}}</name>
                      </div>
                      <div>
                          <label>Van:</label>
                          <name>{{$trip->van->plate_number}}</name>
                      </div>
                      <div>
                          <label>Origin:</label>
                          <name>{{$trip->origin}}</name>
                      </div>
                      <div>
                          <label>Destination:</label>
                          <name>{{$trip->destination}}</name>
                      </div>
                      <div>
                          <label>Date:</label>
                          <name>{{$trip->date_departed}}</name>
                      </div>
                      <div>
                          <label>Time:</label>
                          <name>{{$trip->time_departed}}</name>
                      </div>

                        <div class="box" style="margin: 3% 0%">
                            <div class="box-header text-center">
                                <h4>Shares</h4>
                            </div>
                            <div class="box-body" id="inner-dest">
                                <div class="form-group inner-routes">

                                </div>

                                <label for="">Driver:</label>
                                <input id="" class="form-control pull-right" type="number" id="total" style="width:30%;" value="{{number_format((float)$driverShare, 2, '.', '')}}" disabled>

                            </div>
                        </div>



                    </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
