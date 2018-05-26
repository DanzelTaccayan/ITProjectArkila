@extends('layouts.master')
@section('title', 'Reservation Details')
@section('content')
	<div class="padding-side-10">
		<div>
		    <h2 class="text-white"><strong>RESERVATION CODE:</strong> {{$request->rsrv_code}}</h2>
		</div>
		<div class="box box-solid">
			<div class="box-body">	
				<div class="row">
					<div class="col-md-6">
						<table class="table table-striped table-bordered">
		                	<tbody>
		                		<tr>
		                			<th>Customer Name</th>
									<td>{{$request->name}}</td>
		                		</tr>
		                		<tr>
		                			<th>Destination</th>
		                			<td>{{$request->destination_name}}</td>
		                		</tr>
		                		<tr>
		                			<th>Reservation Type</th>
		                			<td>{{$request->type}}</td>
		                		</tr>
		                		<tr>
		                			<th>Ticket Qty</th>
		                			<td>{{$request->ticket_quantity}}</td>
		                		</tr>
		                		<tr>
		                			<th>Total Fee</th>
		                			<td>{{$request->fare}}</td>
		                		</tr>
		                		<tr>
		                			<th>Status</th>
		                			<td>{{$request->status}}</td>
		                		</tr>
		                		<tr>
		                			<th>Date Paid</th>
		                			<td>{{$request->date_paid}}</td>
		                		</tr>
		                		<tr>
		                			<th>Date Reserved</th>
		                			<td>{{$request->created_at}}</td>
		                		</tr>
		                	</tbody>
		                </table>
					</div>
					<div class="col-md-6">
						
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection