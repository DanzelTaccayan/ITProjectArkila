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
                    <form class="contact100-form" action="" method="POST" data-parsley-validate="">
                        {{csrf_field()}}
                        <div class="form-group">
                        	<table class="table table-striped table-bordered">
                        		<tbody>
                        			<tr>
                        				<th>Route</th>
                        				<td>Baguio - Cabantauan</td>
                        			</tr>
                        			<tr>
                        				<th>Date</th>
                        				<td>20 MAY 2017</td>
                        			</tr>
                        			<tr>
                        				<th>Day</th>
                        				<td>Sunday</td>
                        			</tr>
                        			<tr>
                        				<th>Estimated Departure</th>
                        				<td>2:00 PM</td>
                        			</tr>
                        			<tr>
                        				<th>Drop-off point</th>
                        				<td>ASINGAN</td>
                        			</tr>
                        			<tr>
                        				<th>Ticket Price</th>
                        				<td>200.00</td>
                        			</tr>
                        		</tbody>
                        	</table>
                        </div>
                        <div class="form-group">
                        	<table class="table table-striped table-bordered">
                        		<tbody>
                        			<tr>
                        				<th>Name</th>
                        				<td>LAST NAME, FIRST NAME</td>
                        			</tr>
                        			<tr>
                        				<th>Contact Number *</th>
                        				<td><input type="text" class="form-control"></td>
                        			</tr>
                        			<tr>
                        				<th>Ticket Qty *</th>
                        				<td><input type="number" class="form-control"></td>
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