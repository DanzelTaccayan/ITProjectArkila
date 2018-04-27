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
                                    <tbody>
                                        <tr>

                                            <th>Route</th>
                                            <th>#Passenger</th>
                                            <th>#Discounted</th>
                                        </tr>
                                        <tr>
                                        @php $totalPassengers = 0; @endphp
                                        @foreach($destinations as $key => $values)
                                            @if($trip->trip_id == $values->tripid)
                                            @php $innerRoutesArr[$key] = $values; @endphp
                                            <td >{{$values->destdesc}}</td>
                                            <td class="text-right">{{$values->counts}}</td>
                                            <td class="text-right">1</th>
                                        </tr>
                                        @php $totalPassengers = $totalPassengers + $values->counts; @endphp
                                            @endif
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-right">Total</th>
                                            <th class="text-right">{{$totalPassengers}}</th>
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
                        
                        <div class="box" style="margin: 3% 0%">
                            <div class="box-header text-center">
                                <h4>Shares</h4>
                            </div>
                            <div class="box-body" id="inner-dest">
                                <div class="form-group inner-routes">
                                    @php $bantrans = 0; @endphp
                                    @if($trip->SOP == null)
                                        @php $bantrans = $trip->total_booking_fee + $trip->community_fund  @endphp
                                    @else
                                        @php $bantrans = $trip->total_booking_fee + $trip->SOP + $trip->community_fund  @endphp
                                    @endif
                                    
                                    @php $totalfare = 0; @endphp
                                    @foreach($destinations as $key => $values)
                                        @php $totalfare = $totalfare + ($values->amount * $values->counts); @endphp
                                    @endforeach
                                   
                                </div>
                                
                                <label for="">Driver:</label>
                                <input id="" class="form-control pull-right" type="number" id="total" style="width:30%;" value="{{$totalfare - $bantrans}}" disabled>
                                
                            </div>
                        </div>
                        
                        <button onclick="window.open('{{route('pdf.perTrip', $trip->trip_id)}}')" class="btn btn-default btn-sm btn-flat pull-right"> <i class="fa fa-print"></i> PRINT</button>

                    </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection