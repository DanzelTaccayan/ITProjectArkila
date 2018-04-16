@extends('layouts.form')
@section('title', 'Create New Destination')
@section('back-link', route('settings.index'))
@section('form-action', route('destinations.store'))
@if(count($terminals) > 0)
    @section('form-title', 'CREATE DESTINATION')
@else
    @section('form-title', 'Please Create a Terminal first Before Creating a Destination')
@endif
@section('form-body')
    @if(count($terminals) > 0)
    <div class="form-group">
        <label>Destination Name: <span class="text-red">*</span></label>
        <input list="destinations" name="addDestination" type="text" class="form-control" val-settings-desc required>
         <datalist id="destinations">
            @foreach($destinations as $destination)
            <option value="{{$destination->description}}">
            @endforeach
    </datalist>
    </div>
    <div class="form-group">
        <label>Terminal:</label>

        <select class="form-control" name="addDestinationTerminal">
          @foreach($terminals as $terminal)
            <option value="{{$terminal->terminal_id}}">{{$terminal->description}}</option>
          @endforeach
        </select>

    </div>
    <div class="form-group">
        <label>Regular Fare: <span class="text-red">*</span></label>
        <input type="number" class="form-control" name="addDestinationFare" step="0.25" placeholder="Php 0.00"  val-settings-amount required>
    </div>
    <div class="form-group">
        <label>Discounted Fare: <span class="text-red">*</span></label>
        <input type="number" class="form-control" name="addDestinationFare" step="0.25" placeholder="Php 0.00"  val-settings-amount required>
    </div>
    <div class="form-group">
        <label>Number of Tickets: <span class="text-red">*</span> </label>
        <input type="number" class="form-control" name="numberOfTickets" val-settings-amount required>
    </div>

    @endsection
    @section('form-btn')
        <button type="submit" class="btn btn-primary">Create</button>
    @endsection
@endif
