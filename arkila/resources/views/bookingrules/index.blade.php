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
			<form action="{{route('reservation.rule')}}" method="POST">
			{{ csrf_field() }}
			<div class="box-body" style="min-height: 410px;">
				<div id="viewReservationRules">
					<div class="padding-side-10" style="margin-top: 7%;">
						<table class="table table-striped table-bordered">
							<tbody>
								<tr>
									<th>Reservation Fee</th>
									<td>{{$reservationRule->fee}}</td>
								</tr>
								<tr>
									<th>Cancellation Fee</th>
									<td>{{$reservationRule->cancellation_fee}}</td>
								</tr>
								<tr>
									<th>Payment Due</th>
									<td>{{$reservationRule->payment_due}}</td>
								</tr>
								<tr>
									<th>Refund Expiry</th>
									<td>{{$reservationRule->refund_expiry}}</td>
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
						<input type="number" name="reservationFee" class="form-control" value="{{$reservationRule->fee}}">
					</div>
					<div class="form-group">
						<label for="">Cancellation Fee</label>
						<input type="number" name="reservationCancellation" class="form-control" value="{{$reservationRule->cancellation_fee}}">
					</div>
					<div class="form-group">
						<label for="">Payment Due</label>
						<select name="reservationPayment" class="form-control" id="">
							<option value="1" @if($reservationRule->payment_due == 1) {{'selected'}}@endif>1 day after reservation</option>
							<option value="2" @if($reservationRule->payment_due == 2) {{'selected'}}@endif>2 days after reservation</option>
							<option value="3" @if($reservationRule->payment_due == 3) {{'selected'}}@endif>3 days after reservation</option>
							<option value="4" @if($reservationRule->payment_due == 4) {{'selected'}}@endif>4 days after reservation</option>
						</select>
					</div>
					<div class="form-group">
						<label for="">Refund Expiry (more than 24 hours before departure date)</label>
						<select class="form-control" name="reservationRefund">
							<option value="1" @if($reservationRule->refund_expiry == 1) {{'selected'}}@endif>1 day after cancellation</option>
							<option value="2" @if($reservationRule->refund_expiry == 2) {{'selected'}}@endif>2 days after cancellation</option>
							<option value="3" @if($reservationRule->refund_expiry == 3) {{'selected'}}@endif>3 days after cancellation</option>
							<option value="4" @if($reservationRule->refund_expiry == 4) {{'selected'}}@endif>4 days after cancellation</option>
							<option value="5" @if($reservationRule->refund_expiry == 5) {{'selected'}}@endif>5 days after cancellation</option>
							<option value="6" @if($reservationRule->refund_expiry == 6) {{'selected'}}@endif>6 days after cancellation</option>
							<option value="7" @if($reservationRule->refund_expiry == 7) {{'selected'}}@endif>7 days after cancellation</option>
						</select>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<div class="text-center">
					<button type="button" id="editBtnReservation" class="btn btn-primary"><i class="fa fa-edit"></i> EDIT</button>
					<div id="viewBtnsReservation" class="hidden">
						<button type="button" id="viewBtnReservation" class="btn btn-default">CANCEL</button>
						<input type="submit" class="btn btn-primary" value="SAVE">
					</div>
				</div>
			</div>
			</form>

		</div>
	</div>
	<div class="col-md-6">
		<div class="box box-danger">
			<div class="box-header text-center">
				<h3 class="box-title">Rental Rules</h3>
			</div>
			<form action="{{route('rental.rule')}}" method="POST">
			{{ csrf_field() }}
			<div class="box-body"  style="min-height: 410px;">
				<div id="viewRentalRules">
					<div class="padding-side-10" style="margin-top: 7%;">
						<table class="table table-striped table-bordered">
							<tbody>
								<tr>
									<th>Rental Fee</th>
									<td>{{$rentalRule->fee}}</td>
								</tr>
								<tr>
									<th>Cancellation Fee</th>
									<td>{{$rentalRule->cancellation_fee}}</td>
								</tr>
								<tr>
									<th>Request Expiry</th>
									<td>{{$rentalRule->request_expiry}}</td>
								</tr>
								<tr>
									<th>Payment Due</th>
									<td>{{$rentalRule->payment_due}}</td>
								</tr>
								<tr>
									<th>Refund Expiry</th>
									<td>{{$rentalRule->refund_expiry}}</td>
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
						<input type="text" name="rentalFee" class="form-control" value="{{$rentalRule->fee}}">
					</div>
					<div class="form-group">
						<label for="">Cancellation Fee</label>
						<input type="text" name="rentalCancellation" class="form-control" value="{{$rentalRule->cancellation_fee}}">
					</div>
					<div class="form-group">
						<label for="">Request Expiry</label>
						<select name="rentalRequest" class="form-control" id="">
							<option value="1" @if($rentalRule->request_expiry == 1) {{'selected'}}@endif>1 day after request</option>
							<option value="2" @if($rentalRule->request_expiry == 2) {{'selected'}}@endif>2 days after request</option>
							<option value="3" @if($rentalRule->request_expiry == 3) {{'selected'}}@endif>3 days after request</option>
							<option value="4" @if($rentalRule->request_expiry == 4) {{'selected'}}@endif>4 days after request</option>
						</select>
					</div>
					<div class="form-group">
						<label for="">Payment Due</label>
						<select name="rentalPayment" class="form-control" id="">
							<option value="1" @if($rentalRule->payment_due == 1) {{'selected'}}@endif>1 day after payment</option>
							<option value="2" @if($rentalRule->payment_due == 2) {{'selected'}}@endif>2 days after payment</option>
							<option value="3" @if($rentalRule->payment_due == 3) {{'selected'}}@endif>3 days after payment</option>
							<option value="4" @if($rentalRule->payment_due == 4) {{'selected'}}@endif>4 days after payment</option>
						</select>
					</div>
					<div class="form-group">
						<label for="">Refund Expiry (more than 24 hours before departure date)</label>
						<select class="form-control" name="rentalRefund">
							<option value="1" @if($rentalRule->refund_expiry == 1) {{'selected'}}@endif>1 day after cancellation</option>
							<option value="2" @if($rentalRule->refund_expiry == 2) {{'selected'}}@endif>2 days after cancellation</option>
							<option value="3" @if($rentalRule->refund_expiry == 3) {{'selected'}}@endif>3 days after cancellation</option>
							<option value="4" @if($rentalRule->refund_expiry == 4) {{'selected'}}@endif>4 days after cancellation</option>
							<option value="5" @if($rentalRule->refund_expiry == 5) {{'selected'}}@endif>5 days after cancellation</option>
							<option value="6" @if($rentalRule->refund_expiry == 6) {{'selected'}}@endif>6 days after cancellation</option>
							<option value="7" @if($rentalRule->refund_expiry == 7) {{'selected'}}@endif>7 days after cancellation</option>
						</select>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<div class="text-center">
					<button type="button" id="editBtnRental" class="btn btn-primary"><i class="fa fa-edit"></i> EDIT</button>
					<div id="viewBtnsRental" class="hidden">
						<button type="button" id="viewBtnRental" class="btn btn-default">CANCEL</button>
						<button type="submit" class="btn btn-primary">SAVE</button>
					</div>
				</div>
			</div>
		</div>
		</form>

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