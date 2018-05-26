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
						<h3>RESERVATION DETAILS</h3>
						<table class="table table-striped table-bordered form-table">
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
		                <div class="text-center">
							<a href="" class="btn btn-default">Back</a>
						</div>
					</div>
					<div class="col-md-6">
						<h2><strong>STATUS: 
							<span class="text-green">UNPAID</span>
						</strong></h2>
						<div class="padding-side-10" style="margin-top: 10%;">
							<h4>RESERVATION FARE</h4>
							<div style="border: 1px solid lightgray; margin-bottom: 5%;">
								<h3 class="text-center" style="padding: 3%; font-size: 40px;"><strong class="text-green">{{$request->fare}}</strong></h3>
							</div>
							<div class="text-center">
								<button type="submit" name="payment" class="btn btn-success"><i class="fa fa-money"></i> Receive Payment</button>
							</div>
						</div>
						<h2><strong>STATUS: 
							<span class="text-aqua">PAID</span>
						</strong></h2>
						<div>
							<div class="padding-side-10" style="margin-top: 10%;">
							<table class="table table-striped table-bordered">
								<tbody>
									<tr>
										<th>Enter Refund Code</th>
										<td>
				   				<input type="text" name="refundCode" class="form-control" required></td>
									</tr>
								</tbody>
							</table>
							</div>
							<div class="text-center">
								<button type="submit" name="payment" class="btn btn-info">Refund</button>
							</div>
					    </div>
						<h2><strong>STATUS: 
							<span class="text-red">TICKET ON HAND</span>
						</strong></h2>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection