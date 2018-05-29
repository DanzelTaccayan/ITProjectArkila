@extends('layouts.master')
@section('title', 'Reservation Details')
@section('content')
	<div class="padding-side-10">
		<div>
		    <h2 class="text-white"><strong>RESERVATION CODE:</strong> {{strtoupper($reservation->rsrv_code)}}</h2>
		</div>
		<div class="box box-solid">
			<div class="box-body">	
				<div class="row">
					<div class="col-md-6">
						<h3>RESERVATION DETAILS</h3>
						<table class="table table-striped table-bordered form-table">
		                	<tbody>
		                		<tr>
		                			<th>Customer Name</th>
									<td>{{$reservation->name}}</td>
		                		</tr>
		                		<tr>
		                			<th>Destination</th>
		                			<td>{{$reservation->destination_name}}</td>
		                		</tr>
		                		<tr>
		                			<th>Reservation Type</th>
		                			<td>{{$reservation->type}}</td>
		                		</tr>
		                		<tr>
		                			<th>Ticket Qty</th>
		                			<td>{{$reservation->ticket_quantity}}</td>
		                		</tr>
		                		<tr>
		                			<th>Total Fare</th>
		                			<td>₱{{$reservation->fare}}</td>
		                		</tr>
		                		<tr>
		                			<th>Status</th>
		                			<td>{{$reservation->status}}</td>
		                		</tr>
		                		<tr>
		                			<th>Date Paid</th>
									@if($reservation->date_paid != null)
		                			<td>{{$reservation->date_paid->formatLocalized('%d %B %Y')}}</td>
		                			@else
									<td>Not yet paid.</td>
									@endif
								</tr>
		                		<tr>
		                			<th>Date Reserved</th>
		                			<td>{{$reservation->created_at->formatLocalized('%d %B %Y')}}</td>
		                		</tr>
		                	</tbody>
		                </table>
		                <div class="text-center">
							<a href="{{route('reservations.show', $reservation->date_id)}}" class="btn btn-default">Back</a>
						</div>
					</div>
					<div class="col-md-6">
					
					@if($reservation->status == 'UNPAID')
						@include('reservations.reservationPay')
					@elseif($reservation->status == 'PAID')
						@include('reservations.reservationRefund')
					@elseif($reservation->status == 'TICKET ON HAND')
						@include('reservations.reservationOnHand')
					@endif
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection