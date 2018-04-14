@extends('layouts.form')
@section('title', 'Create New Terminal')
@section('back-link', route('settings.index'))
@section('form-action', route('terminal.store'))
@section('form-title', 'CREATE TERMINAL')
@section('form-body')
	
    <div class="form-group">
        <div class="form-group">
            <label>Terminal Name: <span class="text-red">*</span> </label>
            <input type="text" class="form-control" name="addTerminalName" val-settings-desc required>
        </div>
        <div class="form-group">
            <label>Booking Fee: <span class="text-red">*</span> </label>
            <input type="number" class="form-control" step="0.25" name="bookingFee" val-settings-amount required>
        </div>
    </div>

@endsection
@section('form-btn')
    <button type="submit" class="btn btn-primary">Create</button>
@endsection
