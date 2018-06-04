@extends('layouts.master')
@section('title', 'Booking Rules')
@section('links')
@section('content')
<div class="padding-side-10">
<h2 class="text-white text-center">BOOKING RULES</h2>
<div class="row">
	<div class="col-md-6">
		<div class="box box-success">
			<div class="box-header text-center">
				<h3 class="box-title">Reservation Rules</h3>
			</div>
			<div class="box-body" style="min-height: 380px;">
				<div id="viewReservationRules">
					<div class="padding-side-10" style="margin-top: 7%;">
						<table class="table table-striped table-bordered">
							<tbody>
								<tr>
									<th>Reservation Fee</th>
									<td></td>
								</tr>
								<tr>
									<th>Cancellation Fee</th>
									<td></td>
								</tr>
								<tr>
									<th>Payment Due</th>
									<td></td>
								</tr>
								<tr>
									<th>Refund Expiry</th>
									<td></td>
								</tr>
							</tbody>
						</table>	
					</div>
					<div class="padding-side-15">
						<p class="well"><strong>NOTE:</strong> The Refund Expiry only applies when the customer cancelled more than 24 hours after the Departure Date.</p>
					</div>
				</div>
				<div id="editReservationRules" class="padding-side-15 hidden">
					<div class="form-group">
						<label for="">Reservation Fee</label>
						<input type="number" class="form-control">
					</div>
					<div class="form-group">
						<label for="">Cancellation Fee</label>
						<input type="number" class="form-control">
					</div>
					<div class="form-group">
						<label for="">Payment Due</label>
						<select name="" class="form-control" id="">
							<option value="">1 day after reservation</option>
							<option value="">2 days after reservation</option>
							<option value="">3 days after reservation</option>
							<option value="">4 days after reservation</option>
						</select>
					</div>
					<div class="form-group">
						<label for="">Refund Expiry (more than 24 hours before departure date)</label>
						<select class="form-control">
							<option value="	"></option>
						</select>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<div class="text-center">
					<button id="editBtnReservation" class="btn btn-primary"><i class="fa fa-edit"></i> EDIT</button>
					<div id="viewBtnsReservation" class="hidden">
						<button id="viewBtnReservation" class="btn btn-default">CANCEL</button>
						<button type="submit" class="btn btn-primary">SAVE</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="box box-danger">
			<div class="box-header text-center">
				<h3 class="box-title">Rental Rules</h3>
			</div>
			<div class="box-body"  style="min-height: 380px;">
				<div id="viewRentalRules">
					<div class="padding-side-10" style="margin-top: 7%;">
						<table class="table table-striped table-bordered">
							<tbody>
								<tr>
									<th>Rental Fee</th>
									<td></td>
								</tr>
								<tr>
									<th>Cancellation Fee</th>
									<td></td>
								</tr>
								<tr>
									<th>Payment Due</th>
									<td></td>
								</tr>
								<tr>
									<th>Refund Expiry</th>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="padding-side-15">
						<p class="well"><strong>NOTE:</strong> The Refund Expiry only applies when the customer cancelled more than 24 hours after the Departure Date.</p>
					</div>
				</div>
				<div id="editRentalRules" class="padding-side-15 hidden">
					<div class="form-group">
						<label for="">Rental Fee</label>
						<input type="text" class="form-control">
					</div>
					<div class="form-group">
						<label for="">Cancellation Fee</label>
						<input type="text" class="form-control">
					</div>
					<div class="form-group">
						<label for="">Payment Due</label>
						<select class="form-control">
							<option value="	"></option>
						</select>
					</div>
					<div class="form-group">
						<label for="">Refund Expiry (more than 24 hours before departure date)</label>
						<select class="form-control">
							<option value="	"></option>
						</select>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<div class="text-center">
					<button id="editBtnRental" class="btn btn-primary"><i class="fa fa-edit"></i> EDIT</button>
					<div id="viewBtnsRental" class="hidden">
						<button id="viewBtnRental" class="btn btn-default">CANCEL</button>
						<button type="submit" class="btn btn-primary">SAVE</button>
					</div>
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
	$('#editBtnReservation').click(function(){
       	$('#viewReservationRules').hide();
       	$('#editBtnReservation').hide();
        $('#editReservationRules').show();
        $('#viewBtnsReservation').show()
        $('#editReservationRules').removeClass("hidden");
        $('#viewBtnsReservation').removeClass("hidden");
    });
    $('#viewBtnReservation').click(function(){
       	$('#viewReservationRules').show();
       	$('#editBtnReservation').show();
        $('#editReservationRules').hide();
        $('#viewBtnsReservation').hide()
    });
    $('#editBtnRental').click(function(){
       	$('#viewRentalRules').hide();
       	$('#editBtnRental').hide();
        $('#editRentalRules').show();
        $('#viewBtnsRental').show()
        $('#editRentalRules').removeClass("hidden");
        $('#viewBtnsRental').removeClass("hidden");
    });
    $('#viewBtnRental').click(function(){
       	$('#viewRentalRules').show();
       	$('#editBtnRental').show();
        $('#editRentalRules').hide();
        $('#viewBtnsRental').hide()
    });
</script>
@endsection