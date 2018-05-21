@extends('layouts.customer_user')
@section('links')
@parent
<style>
	.reservation-rules p{
		margin-bottom: 20px;
		text-align: justify;
	}
</style>
@endsection
@section('content')
<section class="mainSection">
        <div class="container">
            <div class="heading text-center">
                <h2>Reserve a Trip</h2>
            </div>
            <div class="row">
                <div class="col-md-6 mx-auto" id="boxContainer">
                    <div class="contact100-form">
                    	<h1 class="text-center text-red">IMPORTANT!</h1>
                    	<div class="reservation-rules">
	                    	<p>Reservations made online only guarantee the customer a line in purchasing tickets.</p>
	                    	<p>Customer will not be able to choose a seat in the van.</p>
	                    	<p>The booking must be paid before the reservation expiry indicated on the itinerary. Unpaid reservations within the given period are automatically cancelled by the system.</p>
	                    	<p>Tickets will not be given immediately upon payment and will only be given on the exact date of reservation</p>
	                    	<p>Customer can pay the fee in the office, address can be seen in about us page</p>
                    	</div>
                    </div>
                    <!-- contact100-form-->
                </div>
                <div class="col-md-6 mx-auto" id="boxContainer">
                    <form class="contact100-form" action="{{route('customermodule.storeReservation', $reservation->id)}}" method="POST" data-parsley-validate="">
                        {{csrf_field()}}
                        <div class="form-group">
                        	<table class="table table-striped table-bordered">
                        		<tbody>
                        			<tr>
                        				<th>Route</th>
                        				<td>{{$main->destination_name}} - {{$reservation->destination->destination_name}}</td>
                        			</tr>
                        			<tr>
                        				<th>Date</th>
                        				<td>{{$reservation->reservation_date->formatLocalized('%d %B %Y')}}</td>
                        			</tr>
                        			<tr>
                        				<th>Day</th>
                        				<td>{{$reservation->reservation_date->formatLocalized('%A')}}</td>
                        			</tr>
                        			<tr>
                        				<th>Estimated Departure</th>
                        				<td>{{ date('g:i A', strtotime($reservation->departure_time)) }}</td>
                        			</tr>
                        			<tr>
                        				<th>Drop-off point</th>
                        				<td>{{$dropOff->destination_name}}</td>
                        			</tr>
                        			<tr>
                        				<th>Ticket Price</th>
                        				<td>P{{$reservation->destination->tickets->first()->fare}}</td>
                        			</tr>
                        		</tbody>
                        	</table>
                        </div>
                        <div class="form-group">
                        	<table class="table table-striped table-bordered">
                        		<tbody>
                        			<tr>
                        				<th>Name</th>
                        				<td>{{auth()->user()->full_name}}</td>
                        			</tr>
                        			<tr>
                        				<th>Contact Number *</th>
                        				<td><input type="text" name="contactNumber" value="{{old('contactNumber')}}" class="form-control"></td>
                        			</tr>
                        			<tr>
                        				<th>Ticket Qty *</th>
                        				<td><input type="number" name="quantity" value="{{old('quantity')}}" class="form-control"></td>
                        			</tr>
                        		</tbody>
                        	</table>
                        </div>
                        <div class="container-contact100-form-btn">
                        	<button class="contact100-form-btn"><strong>BACK</strong></button>
                            <button type="submit" class="contact100-form-btn"><strong>RESERVE</strong></button>
                        </div><!-- container-contact100-form-btn-->
                    </form>
                    <!-- contact100-form-->
                </div>	
                <!-- col-->
            </div>
            <!-- row-->
        </div>
        <!-- container-->
</section>

@endsection