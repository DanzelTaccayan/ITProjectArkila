@extends('layouts.customer_user')
@section('content')
<section class="mainSection">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mx-auto" id="boxContainer">
                    <div class="contact100-form" style="background: lightgreen; margin-bottom: 0px;">
                        <h1 class="text-center" style="font-size: 60px; color: white;"><i class="fa fa-check-circle"></i> SUCCESS!</h1>
                    </div>
                    <div class="contact100-form">
                    	<table class="table table-striped table-bordered">
                    		<tbody>
								<tr>
                    				<th>Reservation Code</th>
                    				<td><strong>{{$transaction->rsrv_code}}</strong></td>
                    			</tr>
                    			<tr>
                    				<th>Destination</th>
                    				<td>{{$transaction->destination_name}}</td>
                    			</tr>
                                <tr>
                                    <th>Departure Date</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Departure Time</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Departure Day</th>
                                    <td></td>
                                </tr>
                    			<tr>
                    				<th>Expiry Date</th>
                    				<td>{{$transaction->expiry_date->formatLocalized('%d %B %Y')}}</td>
                    			</tr>
                    			<tr>
                    				<th>Status</th>
                    				<td>{{$transaction->status}}</td>
                    			</tr>
                    			<tr>
                    				<th>Ticket Qty</th>
                    				<td>{{$transaction->ticket_quantity}}</td>
                    			</tr>
                    			<tr>
                    				<th>Total Amount to Pay</th>
                    				<td>{{$transaction->fare}}</td>
                    			</tr>
                    		</tbody>
                    	</table>
                    	<p><strong>NOTE:</strong> Pay the total amount at the company office before the expiry date.</p>
                    	<div class="mx-auto">
                    		<a href="{{route('customermodule.reservationTransaction')}}" class="btn btn-primary btn-lg">OK</a>
                    	</div>
                    </div>
                </div>
                <!-- col-->
            </div>
            <!-- row-->
        </div>
        <!-- container-->
</section>
@endsection