@extends('layouts.form')
@section('title', 'Edit Profile')
@section('back-link', route('company-profile.index'))
@section('form-action', route('company-profile.update', [$profile->id]))
@section('method_field', method_field('PATCH'))
@section('form-title', 'EDIT COMPANY PROFILE')
@section('form-body')

    <div class="form-group">
        <div class="form-group">
            <label for="contactNumber">Contact Number: </label>
            <input value="{{old('contactNumber') ?? $profile->contact_number }}" type="text" name="contactNumber" class="form-control" required>    
        </div>

        <div class="form-group">
            <label>Address:</label>
            <input value="{{old('address') ?? $profile->address }}" type="text" name="address" class="form-control" name="address">
        </div>
        <div class="form-group">
            <label>Email: </label>
            <input value="{{old('email') ?? $profile->email }}" type="text" name="email" class="form-control" name="email">
        </div>
        <div class="form-group col-md-6 left">
            <label>Opening Time: </label>
            <input type="text" class="form-control" name="openTime" value="" required>
        </div>
        <div class="form-group col-md-6 right">
            <label>Closing Time: </label>
            <input type="text" class="form-control" name="closeTime" value="" required>
        </div>
    </div>

@endsection
@section('form-btn')
    <button type="submit" class="btn btn-primary">Save Changes</button>
@endsection
