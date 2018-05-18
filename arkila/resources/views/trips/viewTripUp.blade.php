@extends('layouts.master')
@section('title', 'Trip Details')
@section('links')
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
<div class="padding-side-5">
    <div>
        <h2 class="text-white">VIEW TRIP</h2>
    </div>

<div class="box" style="box-shadow: 0px 5px 10px gray;">
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
                <table class="table table-bordered table-striped">
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
                                <th class="text-right">{{number_format((float)$driverShare, 2, '.', '')}}</th>  
                            </tr>
                        </tbody>
                    </table>

                    <button onclick="window.open('')"  class="btn btn-primary btn-sm btn-flat pull-right"> <i class="fa fa-print"></i> PRINT TRIP INFORMATION</button>
            
        </div>
    </div>
</div>
</div>
@endsection
