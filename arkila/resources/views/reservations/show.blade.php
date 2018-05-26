@extends('layouts.master')
@section('title', 'Reservation Dates')
@section('content')
<div class="">
	 <div>
        <h2 class="text-white">{{ $reservation->reservation_date->formatLocalized('%A') }} <strong class="text-yellow">{{ $reservation->reservation_date->formatLocalized('%d %B %Y') }}</strong></h2>
    </div>
	<div class="box box-solid" style="height: 500px;">
		<div class="box-body">
			<div class="row">
				<div class="col-md-3">
					<h3 class="text-center">RESERVATION DETAILS</h3>
					<table class="table table-striped table-bordered">
						<tbody>
							<tr>
								<th>Departure Time</th>
								<td>{{ date('g:i A', strtotime($reservation->departure_time)) }}</td>
							</tr>

							<tr>
								<th>Destination Terminal</th>
								<td>{{$reservation->destination->destination_name}}</td>
							</tr>
							<tr>
								<th>Number of Slots left</th>
								<td>{{$reservation->number_of_slots}}</td>
							</tr>
						</tbody>
					</table>
					<div>
						<a href="{{route('reservations.index')}}" class="btn btn-default btn-block btn-sm">BACK</a>
					</div>
				</div>
				<div class="col-md-9">
					<h3 class="text-center">RESERVED CUSTOMERS</h3>
					@if($reservation->status == 'OPEN')
					<div class="col-md-6">
                        <a href="{{route('reservation.walk-in', $reservation->destination_terminal)}}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-plus"></i> ADD RESERVATION</a>
                    </div>
					@endif
					<table class="table table-striped table-bordered listReserved">
						<thead>
							<tr>
								<th class="text-center">Reservation Code</th>
								<th class="text-center">Destination</th>
								<th class="text-center">Status</th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($requests->sortByDesc('created_at') as $request)
							@if($request->status == 'UNPAID' && Carbon\Carbon::now()->gt($request->expiry_date))
							@else

							<tr>

								<td>{{$request->rsrv_code}}</td>							
								<td>{{$request->destination_name}}</td>
								<td>{{$request->status}}</td>
								<td>
									<div class="text-center">
										<a href="{{route('reservation.showReservation', $request->id)}}" class="btn btn-primary">View</a>
									@if($request->status == 'UNPAID')
										<button class="btn btn-info" data-toggle="modal" data-target="#{{'reserved-pay' . $request->id}}">Payment</button>
									@elseif($request->status == 'PAID')
										<a href="#" class="btn btn-info">Refund</a>
									@endif
									</div>
								</td>
							</tr>
							@endif
							@endforeach
						</tbody>
					</table>
					@foreach($requests as $request)
					<div class="modal" id="{{'reserved-info' . $request->id}}">
			          <div class="modal-dialog">
			            <div class="modal-content">
			              <div class="modal-header">
			                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                  <span aria-hidden="true">×</span></button>
			                <h4 class="modal-title">Reservation Details</h4>
			              </div>
			              <div class="modal-body">
			                
			              </div>
			              <div class="modal-footer">
			                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
			                
			              </div>
			            </div>
			            <!-- /.modal-content -->
			          </div>
			          <!-- /.modal-dialog -->
			        </div>
					<div class="modal" id="{{'reserved-pay' . $request->id}}">
			          <div class="modal-dialog">
			            <div class="modal-content">
			              <div class="modal-header">
			                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                  <span aria-hidden="true">×</span></button>
			                <h4 class="modal-title">Payment Details</h4>
			              </div>
			              <div class="modal-body">
			              	<div class="padding-side-5">	
				                <table class="table table-striped table-bordered">
				                	<tbody>
				                		<tr>
				                			<th>Reservation Code</th>
				                			<td>{{$request->rsrv_code}}</td>
				                		</tr>
				                		<tr>
				                			<th>Destination</th>
				                			<td>{{$request->destination_name}}</td>
				                		</tr>
				                			<th>Ticket Qty</th>
				                			<td>{{$request->ticket_quantity}}</td>
				                		</tr>
				                	</tbody>
				                </table>
				                <h3 class="text-center">FEE: <strong class="text-green">{{$request->fare}}</strong></h3>
				            </div>
				           </div>
			              <div class="modal-footer">
			                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
							<form action="{{route('reservation.payment', $request->id)}}" method="POST">
			                {{ csrf_field() }} {{ method_field('PATCH') }}
							<button type="submit" name="payment" class="btn btn-success"><i class="fa fa-money"></i> Receive Payment</button>
							</form>
						  </div>
			            </div>
			            <!-- /.modal-content -->
			          </div>
			          <!-- /.modal-dialog -->
			        </div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function() {
        $('.listReserved').DataTable({
			'pageLength': 5,
            'paging': true,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': true,
            'aoColumnDefs': [{
                'bSortable': true,
                'aTargets': [-1] /* 1st one, start by the right */
            }]
        })

    })
</script>
@endsection