@extends('layouts.form')
@section('title', 'Edit Booking Fee')
@section('back-link', route('settings.index'))
@section('form-action', route('bookingfee.update',[$bookingfee->destination_id]))
@section('method_field', method_field('PATCH'))
@section('form-title', 'EDIT BOOKING FEE')
@section('form-body')

  
    <div class="form-group">
        <label>Terminal Name: <span class="text-red">*</span> </label>
        <input type="text" class="form-control" value="{{$bookingfee->destination_name}}" disabled>
    </div>
    <input type="hidden" name="type" value="Terminal">
  
    <div id="terminalForm">
      <div class="form-group">
          <label>Booking Fee: <span class="text-red">*</span> </label>
          <input type="number" class="form-control terminalInput terminalRequired" min="1" max="5000" name="bookingFee" value="{{$bookingfee->booking_fee}}" val-partAmount required>
      </div>
    </div>

  @section('form-btn')
    <button type="submit" class="btn btn-primary">Save Changes</button>
  @endsection    

@endsection
@section('scripts') 
@parent

@endsection
