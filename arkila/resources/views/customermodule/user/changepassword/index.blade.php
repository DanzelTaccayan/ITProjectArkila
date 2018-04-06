@extends('layouts.landing')
@section('content')
<div class="heading text-center" >
    <h2 style="color: #000040;">Fare list</h2>
</div>
<div class="col-md-5 mx-auto">
    <div class="form-control">
        <div class="form-group">
          <input type="hidden" id="userid" value="{{$customerId}}">
            <label>Current Password:</label>
            <input id="current_password" name="current_password" type="password" class="form-control">
            <div id="pass_response" class="response"></div>
        </div>
        <div class="form-group">
            <label>New Password:</label>
            <input name="password" type="password" class="form-control">
        </div>
        <div class="form-group">
            <label>Confirm Password:</label>
            <input name="password_confirmation" type="password" class="form-control">
        </div>
    </div>
</div>
@endsection