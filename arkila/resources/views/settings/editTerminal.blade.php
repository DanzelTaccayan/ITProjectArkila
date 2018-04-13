@extends('layouts.form')
@section('title', 'Edit Terminal')
@section('back-link', route('settings.index'))
@section('form-action', route('terminal.update', [$terminal->terminal_id]))
@section('method_field', method_field('PATCH'))
@section('form-title', 'EDIT TERMINAL')
@section('form-body')

    <div class="form-group">
        <div class="form-group">
            <label>Terminal Name:</label>
            <p class="info-container">{{$terminal->description}}</p>
            <input name="editTerminalName" type="hidden" value='{{$terminal->description}}' required>
        </div>
        <div class="form-group">
            <label for="">Booking Fee: <span class="text-red">*</span></label>
            <input class="form-control" type="number" step="0.25" name="editBookingFee" value="{{$terminal->booking_fee}}" val-settings-amount required>
        </div>
    </div>

@endsection
@section('form-btn')
    <button type="submit" class="btn btn-primary">Save Changes</button>
@endsection

