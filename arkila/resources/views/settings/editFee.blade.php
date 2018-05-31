@extends('layouts.form')
@section('title', 'Edit Fee')
@section('back-link', route('settings.index'))
@section('form-action', route('fees.update', [$fee->fad_id]))
@section('method_field', method_field('PATCH'))
@section('form-title', 'EDIT FEE')
@section('form-body')

	<div>
	 	<label for="description">Description:</label>
	 	<p class="info-container">{{$fee->description}}</p>
	 	<input type="hidden" name="editFeesDesc" value='{{$fee->description}}' required>
	</div>

    <div class="form-group">
        <label>Amount: <span class="text-red">*</span></label>
        <input type="number" class="form-control" name="editFeeAmount" min="0" value="{{$fee->amount}}" placeholder="Php 0.00" val-partAmount required>
    </div>

@endsection
@section('form-btn')
    <button type="submit" class="btn btn-primary">Save Changes</button>
@endsection
