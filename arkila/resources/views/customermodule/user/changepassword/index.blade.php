@extends('layouts.landing')
@section('content')
<section class="mainSection">
    <div class="container" id="content">
        <div class="heading text-center">
            <h2 style="color: #000040; padding-top:10px;">Change Password</h2>
        </div>
        <div class="col-md-3 mx-auto boxContainer" style=" padding: 30px;">
            <form action="{{route('drivermodule.changePassword', $customerId)}}" method="POST">
              {{csrf_field()}}
              {{method_field('PATCH')}}
                <div class="form-group" style="padding-top:10px;">
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
                    <input name="password_confirmation" type="password" class="form-control">
                    <label>Confirm Password:</label>
                </div>
                <div class="pull-right" style="padding-bottom:10px;">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
</section>
@endsection
