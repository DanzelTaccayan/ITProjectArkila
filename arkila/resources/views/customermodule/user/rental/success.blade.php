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
                    				<th>Rental Code</th>
                    				<td><strong>{{$rental->rental_code}}</strong></td>
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
                                    <th>Number of Rental Days</th>
                                    <td>{{$rental->number_of_days}}</td>
                                </tr>
                    			<tr>
                    				<th>Expiry Date</th>
                    				<td>{{$rental->created_at->addDays($rule->request_expiry)->formatLocalized('%d %B %Y')}}</td>
                    			</tr>
                    			<tr>
                    				<th>Status</th>
                    				<td>{{$rental->status}}</td>
                    			</tr>
                    		</tbody>
                    	</table>
                    	<p><strong>NOTE:</strong> Pay the total amount at the company office before the expiry date.</p>
                    	<div class="mx-auto">
                    		<a href="{{route('customermodule.rentalTransaction')}}" class="btn btn-primary btn-lg">OK</a>
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