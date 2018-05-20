@extends('layouts.driver')
@section('title', 'View Trip Details')
@section('content-title', 'View Report')
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
.smaroon {
    background: #800000;
}
</style>
@endsection
@section('content')
<div class="padding-side-5">
    <div class="text-center"><h3>VIEW REPORT</h3></div>
    <div class="box" style="box-shadow: 0px 5px 10px gray;">
        <div class="row">

            <div class="col-md-6" style="padding: 2% 7%">
                <div class="text-center">
                    <h4 class="report-header msgreen">DEPARTURE DETAILS</h4>
                </div>
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

                <div class="text-center">
                    <h4 class="report-header smaroon">SHARES</h4>
                </div>
                <table class="table table-bordered table-striped table-responsive">
                    <tbody>
                        <tr>
                            <td>Total Fare collected</td>
                            <td class="text-right">{{number_format((float)$totalFare, 2, '.', '')}}</td>
                        </tr>
                        <tr>
                            <td>Office</td>
                            <td class="text-right">{{number_format((float)$officeShare, 2, '.', '')}}</td>
                        </tr>
                        <tr>
                            <th>Driver</th>
                            <th class="text-right">{{number_format((float)$driverShare, 2, '.', '')}}</th>
                        </tr>
                    </tbody>
                </table>

            </div>

            <div class="col-md-6" style="padding: 2% 7%">

                <div class="text-center">
                    <h4 class="report-header sblue">PASSENGER COUNT</h4>
                </div>

                <div class="box-body" id="inner-dest">

                    <table class="table table-bordered table-striped table-responsive">
                        <tbody>
                            <tr>
                                <th class="text-center">Route</th>
                                <th class="text-center">Regular</th>
                                <th class="text-center">Discounted</th>
                            </tr>
                            @php $totalArr = null; @endphp @foreach($tempArr as $key => $values)
                            <tr>
                                <td class="text-center">{{$key}}</td>
                                @foreach($values as $innerKeys => $innerValues)
                                <td class="text-right">{{$innerValues}}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>

                        @php $totalcount = array(); @endphp @foreach($tempArr as $key => $values) @foreach($values as $innerKeys => $innerValues) @if(!array_key_exists($innerKeys, $totalcount)) @php $totalcount[$innerKeys] = 0; @endphp @endif @php $totalcount[$innerKeys] += $innerValues; @endphp @endforeach @endforeach

                        <tfoot>
                            <tr>
                                <th class="text-right">Total Passenger</th>
                                <th class="text-right">{{$totalPassenger}}</th>
                                <th class="text-right">{{$totalDiscountedPassenger}}</th>
                            </tr>

                        </tfoot>
                    </table>
                </div>

                <button onclick="window.open('')" class="btn btn-primary btn-sm btn-flat pull-right"> <i class="fa fa-print" style="margin-bottom: 2%"></i> SAVE TRIP INFORMATION</button>

            </div>

            
        </div>
    </div>
</div> 
@endsection
