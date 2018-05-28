@extends('layouts.master')
@section('title', 'Booking Rules')
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
								<th>Duration Days</th>
								<td></td>
							</tr>
							<tr>
								<th></th>
								<td></td>
							</tr>
							<tr>
								<th></th>
								<td></td>
							</tr>
						</tbody>
					</table>	
				</div>
				<div id="editReservationRules" class="padding-side-15 hidden">
					<div class="form-group">
						<label for="">Label</label>
						<input type="text" class="form-control">
					</div>
					<div class="form-group">
						<label for="">Label</label>
						<input type="text" class="form-control">
					</div>
					<div class="form-group">
						<label for="">Label</label>
						<input type="text" class="form-control">
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
								<th></th>
								<td></td>
							</tr>
							<tr>
								<th></th>
								<td></td>
							</tr>
							<tr>
								<th></th>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div id="editRentalRules" class="padding-side-15 hidden">
					<div class="form-group">
						<label for="">Label</label>
						<input type="text" class="form-control">
					</div>
					<div class="form-group">
						<label for="">Label</label>
						<input type="text" class="form-control">
					</div>
					<div class="form-group">
						<label for="">Label</label>
						<input type="text" class="form-control">
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