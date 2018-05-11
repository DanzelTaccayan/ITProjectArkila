@extends('layouts.master')
@section('title', 'Report Details')
@section('links')
@section('content')

<div class="box" style="box-shadow: 0px 5px 10px gray;">
    <div class="box-header with-border text-center">
        <a href="{{route('trips.driverReport')}}" class="pull-left btn btn-default"><i class="fa  fa-chevron-left"></i></a>
        <h3 class="box-title">
            Driver Report Details
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
                                      <td></td>
                                      <td></td>
                                    </tr>
                                    <tr>
                                      <th>Short Trip</th>
                                      <td></td>
                                      <td></td>
                                    </tr>
                                  </tbody>
                                  <tfoot>
                                    <tr>
                                      <th class="text-right">Total</th>
                                      <th class="text-right"></th>
                                      <th class="text-right">3</th>
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

                        <div class="text-center" style="margin: 5%;">
                            <div class="row">
                                <div class="col col-md-6">
                                    <form action="{{route('trips.acceptReport', $trip->trip_id)}}" method="POST">
                                        {{csrf_field()}}
                                        {{method_field('PATCH')}}
                                        <button class="btn btn-success btn-sm" data-dismiss="modal"><i class="fa fa-check"></i>Accept</button>
                                    </form>
                                </div>

                                <div class="col col-md-6">
                                    <form action="{{route('trips.declineReport', $trip->trip_id)}}" method="POST">
                                        {{csrf_field()}}
                                        {{method_field('PATCH')}}
                                        <button class="btn btn-danger btn-sm"><i class="fa fa-close"></i>Decline</button>
                                    </form>
                                </div>
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
