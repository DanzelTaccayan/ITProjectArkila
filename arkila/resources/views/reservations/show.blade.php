@extends('layouts.master')
@section('title', 'Reservation Dates')
@section('content')
<div class="">
	 <div>
        <h2 class="text-white">SUNDAY <strong class="text-yellow">2018 MAY 10</strong></h2>
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
					<div class="col-md-6">
                        <a href="{{route('reservation.walk-in', $reservation->id)}}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-plus"></i> ADD RESERVATION</a>
                    </div>	
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
							@foreach($requests as $request)
							<tr>
								@if($request->where('type', 'Online'))
								<td>{{$request->user->full_name}}</td>
								@else
								<td>{{$request->user->name}}</td>	
								@endif							
								<td>{{$request->destination_name}}</td>
								<td>{{$request->status}}</td>
								<td>
									<div class="text-center">
										<button class="btn btn-primary" data-toggle="modal" data-target="#reserved-info">View</button>
										<button class="btn btn-info" data-toggle="modal" data-target="#reserved-refund">Refund</button>
									</div>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					<div class="modal" id="reserved-info">
			          <div class="modal-dialog">
			            <div class="modal-content">
			              <div class="modal-header">
			                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                  <span aria-hidden="true">×</span></button>
			                <h4 class="modal-title">Reservation Details</h4>
			              </div>
			              <div class="modal-body">
			                <table class="table table-striped table-bordered">
			                	<tbody>
			                		<tr>
			                			<th>Reservation Code</th>
			                			<td>1234567890qwerty</td>
			                		</tr>
			                		<tr>
			                			<th>Customer Name</th>
			                			<td>Teo</td>
			                		</tr>
			                		<tr>
			                			<th>Destination</th>
			                			<td>Asingan</td>
			                		</tr>
			                		<tr>
			                			<th>Reservation Type</th>
			                			<td>Online</td>
			                		</tr>
			                		<tr>
			                			<th>Ticket Qty</th>
			                			<td>2</td>
			                		</tr>
			                		<tr>
			                			<th>Total Fee</th>
			                			<td>100</td>
			                		</tr>
			                		<tr>
			                			<th>Status</th>
			                			<td>UNPAID</td>
			                		</tr>
			                		<tr>
			                			<th>Date Paid</th>
			                			<td>1 May 2018</td>
			                		</tr>
			                		<tr>
			                			<th>Date Reserved</th>
			                			<td>10 May 2018</td>
			                		</tr>
			                	</tbody>
			                </table>
			              </div>
			              <div class="modal-footer">
			                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
			                <button type="button" class="btn btn-primary">Save changes</button>
			              </div>
			            </div>
			            <!-- /.modal-content -->
			          </div>
			          <!-- /.modal-dialog -->
			        </div>
			        <div class="modal" id="reserved-refund">
			          <div class="modal-dialog">
			            <div class="modal-content">
			              <div class="modal-header">
			                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                  <span aria-hidden="true">×</span></button>
			                <h4 class="modal-title">REFUND</h4>
			              </div>
			              <form action="post" class="form-horizontal">
				              <div class="modal-body">
				               	<div class="form-group">
			               			<label class="col-md-4 control-label" for="">Reservation Code</label>
			               			<div class="col-md-6">
			               				<p class="info-container">1234567890qwerty</p>
			               			</div>
				               	</div>
				               	<div class="form-group">
			               			<label class="col-md-4 control-label" for="">Paid Amount</label>
			               			<div class="col-md-6">
			               				<p class="info-container"><strong>200</strong></p>
			               			</div>
				               	</div>
				               	<div class="form-group">
			               			<label class="col-md-4 control-label" for="">Enter Refund Code</label>
			               			<div class="col-md-6">
			               				<input type="text" class="form-control">
			               			</div>
				               	</div>

				              </div>
				              <div class="modal-footer">
				                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
				                <button type="button" class="btn btn-primary">REFUND</button>
				              </div>
			              </form>
			            </div>
			            <!-- /.modal-content -->
			          </div>
			          <!-- /.modal-dialog -->
			        </div>
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
            'paging': true,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': true,
            'order': [[ 0, "desc" ]],
            'aoColumnDefs': [{
                'bSortable': false,
                'aTargets': [-1] /* 1st one, start by the right */
            }]
        })

    })
</script>
@endsection