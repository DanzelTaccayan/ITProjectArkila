@extends('layouts.master')
@section('title', 'Reservation Dates')
@section('content')
<div class="">
	 <div>
        <h2 class="text-white">SUNDAY <strong class="text-yellow">2018 MAY 10</strong></h2>
    </div>
	<div class="box box-solid">
		<div class="box-body">
			<div class="row">
				<div class="col-md-3">
					<h3 class="text-center">RESERVATION DETAILS</h3>	
					<table class="table table-striped table-bordered">
						<tbody>
							<tr>
								<th>Destination Terminal</th>
								<td></td>
							</tr>
							<tr>
								<th>Number of Slots left</th>
								<td></td>
							</tr>
						</tbody>
					</table>
					<div>
						<button class="btn btn-default btn-block btn-sm">BACK</button>
					</div>
				</div>
				<div class="col-md-9">
					<h3 class="text-center">RESERVED CUSTOMERS</h3>
					<table class="table table-striped table-bordered">
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
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection