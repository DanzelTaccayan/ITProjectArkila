@extends('layouts.form')
@section('title', 'Edit Profile')
@section('back-link', route('profile.index'))
@section('form-action', route('profile.update', [$profile->id]))
@section('method_field', method_field('PATCH'))
@section('form-title', 'EDIT TERMINAL')
@section('form-body')

    <div class="form-group">
        <img class="profile-user-img img-responsive img-circle" src="{{ URL::asset('img/jl.JPG') }}" alt="profile picture">

        <div class="form-group">
            <label>Contact Number: <span class="text-red">*</span></label>
            <div class = "input-group">  
                <div class = "input-group-addon">
                    <span>+63</span>
                </div>
                <input type="text" class="form-control" placeholder="Contact Number" name="contactNumber" id="contactNumber" value="{{$profile->contact_number}}" data-inputmask='"mask": "999-999-9999"' data-mask data-parsley-errors-container="#errContactNumber" data-mask val-phone required>
            </div>
            <p id="errContactNumber"></p>
        </div>

        <div class="form-group">
            <label>Address:</label>
            <input type="text" class="form-control" name="address" value="{{$profile->address}}" required>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="text" class="form-control" name="email" value="{{$profile->email}}" required>
        </div>
    </div>

@endsection
@section('form-btn')
    <button type="submit" class="btn btn-primary">Save Changes</button>
@endsection
