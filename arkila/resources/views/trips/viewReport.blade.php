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

                                @php $totalPassengers = 0; @endphp
                                @foreach($destinations as $key => $values)
                                    @if($trip->trip_id == $values->tripid)
                                    @php $innerRoutesArr[$key] = $values; @endphp
                                <div class="form-group inner-routes">
                                    <label for="">{{$values->destdesc}}</label>
                                    <input class="form-control pull-right" type="number" id="qty{{$trip->trip_id}}" style="width:30%;" value="{{$values->counts}}" disabled>
                                </div>
                                    @php $totalPassengers = $totalPassengers + $values->counts; @endphp
                                    @endif
                                @endforeach


                                <label for="">Total</label>
                                <input id="" class="form-control pull-right" type="text" id="total" style="width:30%;" value="{{$totalPassengers}}" disabled>
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
                            <name>{{$trip->driver->first_name . " " . $trip->driver->middle_name . " " . $trip->driver->last_name}}</name>
                        </div>
                        <div>
                            <label>Van:</label>
                            <name>{{$trip->plate_number}}</name>
                        </div>
                        <div>
                            <label>Origin:</label>
                            <name>{{$superAdmin->description}}</name>
                        </div>
                        <div>
                            <label>Destination:</label>
                            <name>{{$trip->terminal->description}}</name>
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
