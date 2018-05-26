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
	                            <td>{{ $rental->departure_date }}</td>
	                        </tr>
	                        <tr>
	                            <th>Departure Time</th>
	                            <td>{{ $rental->departure_time }}</td>
	                        </tr>
	                        <tr>
	                            <th>Departure Day</th>
	                            <td>{{ $rental->departure_time }}</td>
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
	                            <td>{{ $rental->plate_number ?? 'None'}}</td>
	                        </tr>
	                        <tr>
	                            <th>Comment</th>
	                            <td>{{ $rental->comments}}</td>
	                        </tr>
	                    </tbody>
	                </table>
				</div>
				<div class="col-md-6">
					@include('rental.rentalAccept')
					@include('rental.rentalPayment')
					@include('rental.rentalDepart')
					<h2><strong>STATUS:
						<span class="text-orange">PENDING</span> 
						<span class="text-green">UNPAID</span>
						<span class="text-aqua">PAID</span>
					</strong></h2>
					<div class="">
						<form action="" class="form-horizontal">
                            <div class="padding-side-15" style="margin-top: 10%">
                            	<h4>CHOOSE SERVICE PROVIDER:</h4>
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>Van Unit</th>
                                            <td>
                                                <select name="" id="" class="form-control">
                                                    <option value=""></option>
                                                    <option value=""></option>
                                                    <option value=""></option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Driver</th>
                                            <td>
                                                <select name="" id="" class="form-control">
                                                    <option value="">HALULUO DELA CRUZ</option>
                                                    <option value=""></option>
                                                    <option value=""></option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="text-center">	
	                                <button type="button" class="btn btn-default">Back</button> 
	                                <button type="submit" class="btn btn-success">Accept</button> 
	                            </div>
                            </div>
                        </form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection