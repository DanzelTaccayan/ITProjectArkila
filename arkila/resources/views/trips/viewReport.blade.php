@extends('layouts.master')
@section('title', 'Report Details')
@section('links')
@parent
<style>
.report-header {
    padding: 10px;
    color: white;
}
.sblue {
    background: slateblue;
}

.msgreen {
    background: mediumseagreen;
}
</style>
@endsection
@section('content')

<div class="box" style="box-shadow: 0px 5px 10px gray;">
    <div class="box-header with-border text-center">
        <a href="{{route('trips.driverReport')}}" class="pull-left btn btn-default"><i class="fa  fa-chevron-left"></i></a>
        <h3 class="box-title">
            Driver Report Details
        </h3>
    </div>
    <div class="box-body">
        
            
                <div class="row">
                    <div class="col-md-6" style="padding: 2% 4%">
                       <div class="text-center"><h4 class="report-header sblue">PASSENGER COUNT</h4></div>
                        
                            <div class="box-body" id="inner-dest">
                                <table class="table table-bordered table-striped table-responsive">
                                  <thead>
                                    <th></th>
                                    <th class="text-center">Regular</th>
                                    <th class="text-center">Discounted</th>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <th class="text-center">Main Terminal</th>
                                      <td class="text-right">{{$numPassCountArr['mainTerminalRegular']}}</td>
                                      <td class="text-right">{{$numPassCountArr['mainTerminalDiscount']}}</td>
                                    </tr>
                                    <tr>
                                      <th class="text-center">Short Trip</th>
                                      <td class="text-right">{{$numPassCountArr['shortTripRegular']}}</td>
                                      <td class="text-right">{{$numPassCountArr['shortTripDiscount']}}</td>
                                    </tr>
                                  </tbody>
                                  <tfoot>
                                    <tr>
                                      <th class="text-right">Total Passenger</th>
                                      <th class="text-right">{{$numPassCountArr['mainTerminalRegular'] + $numPassCountArr['shortTripRegular']}}</th>
                                      <th class="text-right">{{$numPassCountArr['mainTerminalDiscount'] + $numPassCountArr['shortTripDiscount']}}</th>
                                    </tr>
                                  </tfoot>
                                </table>
                            </div>
                    </div>

                    <div class="col-md-6" style="padding: 2% 5%">
                        <div class="text-center"><h4 class="report-header msgreen">DEPARTURE DETAILS</h4></div>
                
                        <table class="table">
                        <tbody>
                            <tr>
                                <th>Driver:</th>
                                <td>{{$trip->driver->first_name . ' ' . $trip->driver->last_name}}</td> 
                            </tr>
                            <tr>
                                <th>Van:</th>
                                <td>{{$trip->van->plate_number}}</td>       
                            </tr>
                            <tr>
                                <th>Origin</th>
                                <td>{{$trip->origin}}</td>  
                            </tr>
                            <tr>
                                <th>Destination</th>
                                <td>{{$trip->destination}}</td>  
                            </tr>
                            <tr>
                                <th>Date:</th>
                                <td>{{$trip->date_departed}}</td>  
                            </tr>
                            <tr>
                                <th>Time:</th>
                                <td>{{$trip->time_departed}}</td>  
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center"><h4 class="report-header msgreen">SHARES</h4></div>
                <table class="table table-bordered table-striped table-responsive">
                        <tbody>
                            <tr>
                                <td>Total Fare collected</td>
                                <td class="text-right"></td>   
                            </tr>
                            <tr>
                                <td>Office</td>
                                <td class="text-right"></td>       
                            </tr>
                            <tr>
                                <th>Driver</th>
                                <th class="text-right"></th>  
                            </tr>
                        </tbody>
                    </table>

                        <div class="text-center" style="margin: 5%;">
                            <div class="row">
                                <div class="col col-md-6">
                                    <form action="{{route('trips.acceptReport', $trip->trip_id)}}" method="POST">
                                        {{csrf_field()}}
                                        {{method_field('PATCH')}}
                                        <button class="btn btn-success btn-sm btn-block" data-dismiss="modal"><i class="fa fa-check"></i>Accept</button>
                                    </form>
                                </div>

                                <div class="col col-md-6">
                                    <form action="{{route('trips.declineReport', $trip->trip_id)}}" method="POST">
                                        {{csrf_field()}}
                                        {{method_field('PATCH')}}
                                        <button class="btn btn-danger btn-sm btn-block"><i class="fa fa-close"></i>Decline</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>

            
       
    </div>
</div>
@endsection
