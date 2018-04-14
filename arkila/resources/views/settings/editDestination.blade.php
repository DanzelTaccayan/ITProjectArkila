@extends('layouts.form')
@section('title', 'Edit Destination')
@section('back-link', route('settings.index'))
@section('form-action', route('destinations.update', [$destination->destination_id]))
@section('method_field', method_field('PATCH'))
@section('form-title', 'EDIT DESTINATION')
@section('form-body')

	 <div>
	 	<label for="destination">Description:</label>
	 	<p class="info-container">{{$destination->description}}</p>
	 	<input type="hidden" name="editDestination" value='{{$destination->description}}' required>
	 </div>

     <div class="form-group">
        <label>Fare:<span class="text-red">*</span></label>
        <input type="number" class="form-control" name="editDestinationFare" step = "0.25" value="{{$destination->amount}}" val-settings-amount required>
     </div>

     <div class="form-group">
		<label>Number of Tickets: <span class="text-red">*</span> </label>
        <input type="number" class="form-control" name="editTickets" value="PALAGYAN NA LANG HEHE" val-settings-amount required>
     </div>

@endsection
@section('form-btn')
    <button type="submit" class="btn btn-primary">Save Changes</button>
@endsection
