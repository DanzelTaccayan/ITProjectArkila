@extends('layouts.form')
@section('title', 'Edit Profile')
@section('back-link', route('company-profile.index'))
@section('form-action', route('company-profile.update', [$company_profile->id]))
@section('method_field', method_field('PATCH'))
@section('form-title', 'EDIT COMPANY PROFILE')
@section('form-body')

    <div class="form-group">
        <div class="form-group">
            <label for="contactNumber">Contact Number: </label>
            <input value="{{old('contactNumber') ?? $company_profile->contact_number }}" type="text" name="contactNumber" class="form-control" val-contact required>    
        </div>

        <div class="form-group">
            <label>Address:</label>
            <input value="{{old('address') ?? $company_profile->address }}" type="text" name="address" class="form-control" val-address name="address">
        </div>
        <div class="form-group">
            <label>Email: </label>
            <input value="{{old('email') ?? $company_profile->email }}" type="email" name="email" class="form-control" val-email name="email">
        </div>
        <div class="form-group col-md-6 left">
            <label>Opening Time: </label>
            <input type="time" class="form-control" name="openTime" value="{{old('openTime') ?? $company_profile->open_time }}" val-time required>
        </div>
        <div class="form-group col-md-6 right">
            <label>Closing Time: </label>
            <input type="time" class="form-control" name="closeTime" value="{{old('closeTime') ?? $company_profile->close_time }}" val-time required>
        </div>
    </div>

@endsection
@section('form-btn')
    <button type="submit" class="btn btn-primary">Save Changes</button>
@endsection