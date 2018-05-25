@extends('layouts.form_lg') 
@section('title', 'Refund Reservation') 
@section('form-id', 'regForm') 
@section('form-action', route('reservations.store')) 
@section('form-method', 'POST') 
@section('form-body') 
{{csrf_field()}}
@endsection
<div class="padding-side-25">
	<div class="box box-solid">
		<div class="box-header with-border text-center">
			<h4>
            <a href=""><i class="pull-left fa fa-chevron-left"></i></a>
            </h4>
			<h4 class="box-title">
				REFUND
			</h4>
		</div>
		<div class="box-body">
	        <div class="form-group">
	   			<label class="col-md-4 control-label" for="">Reservation Code</label>
	   			<div class="col-md-6">
	   				<p class="info-container">{{$request->rsrv_code}}</p>
	   			</div>
	       	</div>
	       	<div class="form-group">
	   			<label class="col-md-4 control-label" for="">Paid Amount</label>
	   			<div class="col-md-6">
	   				<p class="info-container"><strong>{{$request->fare}}</strong></p>
	   			</div>
	       	</div>
	       	<div class="form-group">
	   			<label class="col-md-4 control-label" for="">Enter Refund Code</label>
	   			<div class="col-md-6">
	   				<input type="text" name="refundCode" class="form-control" required>
	   			</div>
	       	</div>
		</div>
		<div class="box-footer">
			<button type="submit" value="Refund" class="btn btn-primary">REFUND</button>
		</div>
	</div>
</div>