@extends('layouts.form')
@section('title', 'Edit Booking Fee')
@section('back-link', route('route.index'))
@section('form-action', route('route.index'))
@section('form-title', 'EDIT BOOKING FEE')
@section('form-body')

{{ csrf_field() }} {{ method_field('PATCH') }}
  
    <div class="form-group">
        <label>Terminal Name: <span class="text-red">*</span> </label>
        <input type="text" class="form-control" name="addTerminal" value="{{$bookingfee->destination_name}}" disabled>
    </div>
    <input type="hidden" name="type" value="Terminal">
  
    <div id="terminalForm">
      <div class="form-group">
          <label>Booking Fee: <span class="text-red">*</span> </label>
          <input type="number" class="form-control terminalInput terminalRequired" min="0" step="0.25" name="bookingFee" value="{{$bookingfee->booking_fee}}" required>
      </div>
    </div>

  @section('form-btn')
    <button type="submit" class="btn btn-primary">Save Changes</button>
  @endsection    

@endsection
@section('scripts') 
@parent

@endsection
