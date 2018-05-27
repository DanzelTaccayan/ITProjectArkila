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
            <input value="{{$profile->contact_number}}" type="text" class="form-control" required>    
        </div>

        <div class="form-group">
            <label>Address:</label>
            <input value="{{$profile->address}}" type="text" class="form-control" name="address">
        </div>
        <div class="form-group">
            <label>Email: </label>
            <input value="{{$profile->email}}" type="text" class="form-control" name="email">
        </div>
    </div>

@endsection
@section('form-btn')
    <button type="submit" class="btn btn-primary">Save Changes</button>
@endsection
