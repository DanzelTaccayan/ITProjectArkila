@extends('layouts.driver')
@section('title', 'Driver Profile')
@section('content-title', 'Driver Home')
@section('content')
@if($acceptedRental == null)
<div class="row">
<div class="col-md-3">  
    <div class="box box-solid">
        <div class="box-body">
            <h2 class="text-center text-gray">NO ACCEPTED RENTAL</h2>
        </div>
        <div class="box-footer">
            <div class="text-center">
                <button id="rentalHistoryBtn" class="btn bg-maroon btn-flat">History</button>
                <button id="backBtn" class="btn btn-default btn-flat hidden">Back</button>
            </div>
        </div>
    </div>
</div>
<div id="rentalRequest" class="col-md-7"> 
    <div class="box box-solid">
        <div class="box-body">
            <div class="box-header">
                <h3 class="text-center box-title"><i class="fa fa-circle-o text-orange"></i> RENTAL REQUESTS</h3>    
            </div>
            @if($rentals->count() == 0)
            <h3 class="text-center">NO RENTALS AT THE MOMENT</h3>
            @else
            <ul class="list-group"> 
            @foreach($rentals as $rental)
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="title-limit" style="margin-bottom: 1px;">{{$rental->destination}}</h4>
                            <p style="color: gray;"></p>
                            <small>
                                <strong>Number of Days:</strong> {{$rental->number_of_days}}
                            </small>
                        </div>
                        <div class="col-md-6">
                            <div class="pull-right" style="margin-top: 7%">
                                    <button id="viewRentalModal" type="button" class="btn btn-primary" data-toggle="modal" data-target="#rentalView{{$rental->rent_id}}">View</button>
                            </div>
                        </div>
                    </div>
                </li>
                <div class="modal fade" id="rentalView{{$rental->rent_id}}">
                    <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">RENTAL DETAILS</h4>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-striped table-bordered">
                                        <tbody>
                                            <tr>
                                                <th>Rental Code</th>
                                                <td>{{strtoupper($rental->rental_code)}}</td>
                                            </tr>
                                            <tr>
                                                <th>Destination</th>
                                                <td>{{$rental->destination}}</td>
                                            </tr>
                                            <tr>
                                                <th>Departure Date</th>
                                                <td>{{$rental->departure_date->formatLocalized('%d %B %Y')}}</td>
                                            </tr>
                                            <tr>
                                                <th>Departure Time</th>
                                                <td>{{date('g:i A', strtotime($rental->departure_time))}}</td>
                                            </tr>
                                            <tr>
                                                <th>Departure Day</th>
                                                <td>{{$rental->departure_date->formatLocalized('%A')}}</td>
                                            </tr>
                                            <tr>
                                                <th>Number of Days</th>
                                                <td>{{$rental->number_of_days}}</td>
                                            </tr>
                                            <tr>
                                                <th>Comment</th>
                                                <td>{{$rental->comment ?? 'None'}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <p><strong>NOTE:</strong> Approach the clerk and give the rental code if you wish to accept this rental.</p>
                                </div>
                                <div class="modal-footer">
                                    <div class="text-center">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>   
                                    </div>
                                </div>
                            </div>
                    </div>
    <!-- /.modal-dialog -->
</div>
            @endforeach
            </ul>
            @endif
        </div>
    </div>
</div>

<div id="rentalHistory" class="col-md-7 hidden">
    <div class="box box-solid">
        <div class="box-body">
            <div class="box-header">
                <h3 class="text-center box-title"><i class="fa fa-circle-o text-maroon"></i> RENTAL HISTORY</h3>    
            </div>
            
            <ul class="list-group"> 
            @if($rentalHistory->count() == 0)
            <h3 class="text-center">NO RENTAL HISTORY ENTRIES FOUND.</h3>
            @else
            @foreach($rentalHistory as $history)
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="title-limit" style="margin-bottom: 1px;">{{$history->destination}}</h4>
                            <p style="color: gray;"></p>
                            <small>
                                <strong>Number of Days:</strong> {{$history->number_of_days}}
                            </small>
                        </div>
                        <div class="col-md-6">
                            <div class="pull-right" style="margin-top: 7%">
                                    <button id="viewRentalModal" type="button" class="btn btn-primary" data-toggle="modal" data-target="#rentalView1">View</button>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
            @endif
            </ul>
        </div>
    </div>
</div>
@else
<div class="col-md-5" id="rentalOnGoing">
    <div class="box box-solid">
        <div class="box-header text-center">
            <h3 class="box-title">ON GOING RENTAL</h3>
        </div>
        <div class="box-body">
           <table class="table table-striped table-bordered">
                <tbody>
                    <tr>
                        <th>Rental Code</th>
                        <td>{{$acceptedRental->rental_code}}</td>
                    </tr>
                    <tr>
                        <th>Destination</th>
                        <td>{{$acceptedRental->destination}}</td>
                    </tr>
                    <tr>
                        <th>Departure Date</th>
                        <td>{{$acceptedRental->departure_date->formatLocalized('%d %B %Y')}}</td>
                    </tr>
                    <tr>
                        <th>Departure Time</th>
                        <td>{{date('g:i A', strtotime($acceptedRental->departure_time))}}</td>
                    </tr>
                    <tr>
                        <th>Departure Day</th>
                        <td>{{$acceptedRental->departure_date->formatLocalized('%A')}}</td>
                    </tr>
                    <tr>
                        <th>Number of Days</th>
                        <td>{{$acceptedRental->number_of_days}}</td>
                    </tr>
                    <tr>
                        <th>Comment</th>
                        <td>{{$acceptedRental->comment ?? 'None'}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="box-footer">
            <div class="text-center"><button id="rentalHistoryBtn" class="btn bg-maroon btn-flat">History</button>
            </div>
        </div>
    </div>
</div>

<div id="rentalHistory" class="col-md-7 hidden">
    <div style="margin-bottom:10px;">
        <button id="backBtn" class="btn btn-default">BACK</button>
    </div>
    <div class="box box-solid">
        <div class="box-body">
            <div class="box-header">
                <h3 class="text-center box-title"><i class="fa fa-circle-o text-maroon"></i> RENTAL HISTORY</h3>    
            </div>
            
            <ul class="list-group"> 
            @if($rentalHistory->count() == 0)
            <h3 class="text-center">NO RENTAL HISTORY ENTRIES FOUND.</h3>
            @else
            @foreach($rentalHistory as $history)
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="title-limit" style="margin-bottom: 1px;">{{$history->destination}}</h4>
                            <p style="color: gray;"></p>
                            <small>
                                <strong>Number of Days:</strong> {{$history->number_of_days}}
                            </small>
                        </div>
                        <div class="col-md-6">
                            <div class="pull-right" style="margin-top: 7%">
                                    <button id="viewHistoryModal" type="button" class="btn btn-primary" data-toggle="modal" data-target="#rentalHistory1">View</button>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
            @endif
            </ul>
        </div>
    </div>
</div>
@endif
<!-- /.modal -->
</div>


@endsection
@section('scripts')
@parent
<script>
@if($acceptedRental == null)
    $('#rentalHistoryBtn').click(function(){
        $('#rentalHistoryBtn').hide();
        $('#rentalRequest').hide();
        $('#rentalHistory').show();
        $('#backBtn').removeClass("hidden");
        $('#backBtn').show();
        $('#rentalHistory').removeClass("hidden");    
    });
    $('#backBtn').click(function(){
        $('#rentalHistoryBtn').show();
        $('#rentalRequest').show();
        $('#backBtn').hide();
        $('#rentalHistory').hide();   
    });
@else
    $('#rentalHistoryBtn').click(function(){
        $('#rentalHistoryBtn').hide();
        $('#rentalOnGoing').hide();
        $('#rentalHistory').show();
        $('#backBtn').removeClass("hidden");
        $('#backBtn').show();
        $('#rentalHistory').removeClass("hidden");    
    });
    $('#backBtn').click(function(){
        $('#rentalHistoryBtn').show();
        $('#rentalOnGoing').show();
        $('#backBtn').hide();
        $('#rentalHistory').hide();   
    });
@endif
</script>
@endsection
