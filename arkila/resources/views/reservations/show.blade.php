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
                        <a href="{{route('reservation.walk-in', $reservation->destination_terminal)}}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-plus"></i> ADD RESERVATION</a>
                    </div>	
					<table class="table table-striped table-bordered listReserved">
						<thead>
							<tr>
								<th class="text-center">Name</th>
								<th class="text-center">Destination</th>
								<th class="text-center">Type</th>
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
								<td>{{$request->destination->destination_name}}</td>
								<td>{{$request->type}}</td>
								<td>{{$request->status}}</td>
								<td>
									<div class="text-center">
										<button class="btn btn-primary">View</button>
										<button class="btn btn-default">Cancel</button>
									</div>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
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