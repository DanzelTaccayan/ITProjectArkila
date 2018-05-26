@extends('layouts.master')
@section('title', 'Reservation Dates')
@section('content')
<div class="row">
	<div class="padding-side-10">
		<div>
		    <h2 class="text-white"><strong>RENTAL CODE:</strong> uiahwduiohwiodh</h2>
		</div>
		<div class="box box-solid">
			<div class="box-body">	
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
	                            <th>Departure Day</th>
	                            <td>{{ $rental->number_of_days }}</td>
	                        </tr>
	                        <tr>
	                            <th>Status</th>
	                            <td>{{ $rental->status }}</td>
	                        </tr>
	                        <tr>
	                            <th>Driver</th>
	                            <td>{{ $rental->driver->full_name ?? 'None' }}</td>
	                        </tr>
	                        <tr>
	                            <th>Van</th>
	                            <td>{{ $rental->van->plate_number ?? 'None'}}</td>
	                        </tr>
	                        <tr>
	                            <th>Comment</th>
	                            <td>{{ $rental->comments}}</td>
	                        </tr>
	                    </tbody>
	                </table>
				</div>
				<div class="col-md-6">
                @if($rental->status == 'Pending')
					@include('rental.rentalAccept')
                @elseif($rental->status == 'Unpaid')
					@include('rental.rentalPayment')
                @elseif($rental->status == 'Paid')
					@include('rental.rentalDepart')
                @endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection