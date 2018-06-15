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
		                <a href="{{route('reservations.show', $reservation->date_id)}}" class="btn btn-primary btn-block btn-sm">DEPART</a>
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

								<td>{{strtoupper($request->rsrv_code)}}</td>							
								<td>{{$request->destination_name}}</td>
								<td>{{$request->status}}</td>
								<td>
									<div class="text-center">
										<a href="{{route('reservation.showReservation', $request->id)}}" class="btn btn-primary">View</a>
									</div>
								</td>
							</tr>
							@endif
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