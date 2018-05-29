@extends('layouts.master')
@section('title', 'Rental')
@section('content')
	<div class="padding-side-10">
		<div>
		    <h2 class="text-white"><strong>RENTAL CODE:</strong> {{strtoupper($rental->rental_code)}}</h2>
		</div>
		<div class="box box-solid">
			<div class="box-body">	
				<div class="row">
					<div class="col-md-6">
						<h3>RENTAL DETAILS</h3>
						<table class="table table-striped table-bordered form-table">
		                    <tbody>
		                        <tr>
		                            <th>Customer Name</th>
		                            <td>{{ $rental->customer_name }}</td>
		                        </tr>
		                        <tr>
		                            <th>Contact Number</th>
		                            <td>{{ $rental->contact_number }}</td>
		                        </tr>
		                        <tr>
		                            <th>Destination</th>
		                            <td>{{ $rental->destination }}</td>
		                        </tr>
		                        <tr>
		                            <th>Departure Date</th>
		                            <td>{{ $rental->departure_date->formatLocalized('%d %B %Y') }}</td>
		                        </tr>
		                        <tr>
		                            <th>Departure Time</th>
		                            <td>{{ date('g:i A', strtotime($rental->departure_time)) }}</td>
		                        </tr>
		                        <tr>
		                            <th>Departure Day</th>
		                            <td>{{ $rental->departure_date->formatLocalized('%A') }}</td>
		                        </tr>
	                            <tr>
		                            <th>Number of Rental Days</th>
		                            <td>{{ $rental->number_of_days }}</td>
		                        </tr>
		                        <tr>
		                            <th>Status</th>
		                            <td>{{ $rental->status }}</td>
		                        </tr>
		                        <tr>
		                            <th>Van</th>
		                            <td>{{ $rental->van->plate_number ?? 'None'}}</td>
		                        </tr>
		                        <tr>
		                            <th>Driver</th>
		                            <td>{{ $rental->driver->full_name ?? 'None' }}</td>
		                        </tr>
		                        <tr>
		                            <th>Comment</th>
		                            <td>{{ $rental->comments}}</td>
		                        </tr>
		                    </tbody>
		                </table>
		                <div>
		                	<a href="{{route('rental.index')}}" class="btn btn-default">Back</a>
							@if($rental->status == 'Paid')
			                <button id="changeDateBtn" class="btn btn-primary pull-right">Change Departure Date</button>
							@endif
			                <button id="cancelChangeDateBtn" class="btn btn-primary pull-right hidden">Cancel</button>
		                </div>
					</div>
					<div class="col-md-6">
						<div id="statusSection">
		                @if($rental->status == 'Pending')
							@include('rental.rentalAccept')
		                @elseif($rental->status == 'Unpaid')
							@include('rental.rentalPayment')
		                @elseif($rental->status == 'Paid' || $rental->status == 'Cancelled')
							@include('rental.rentalDepart')
		                @endif
		                </div>
		                <div id="changeDateSection" class="hidden">
		                	@include('rental.rentalChangeDate')
		                </div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('scripts')
@parent
<script>
	$('#changeDateBtn').click(function(){
       	$('#statusSection').hide();
       	$('#changeDateBtn').hide();
        $('#changeDateSection').show();
        $('#changeDateSection').removeClass("hidden");
        $('#cancelChangeDateBtn').show();
        $('#cancelChangeDateBtn').removeClass("hidden");	
    });
	$('#cancelChangeDateBtn').click(function(){
       	$('#statusSection').show();
       	$('#changeDateBtn').show();
        $('#changeDateSection').hide();
        $('#cancelChangeDateBtn').hide();	
    });
</script>
@endsection