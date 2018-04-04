@extends('layouts.form')
@section('title', 'Manange Users')
@section('back-link', URL::previous())
@section('form-action', route('driver.update', [$driver_user->id]))
@section('method_field', method_field('PATCH'))
@section('form-title', 'Manage Account')
@section('links')
@parent
  <link rel="stylesheet" href="public\css\myOwnStyle.css">

@stop
@section('content')
@section('form-body')


<div class="form-group">
  <label for="payor">User name:</label>
  <span name="username">{{$driver_user->username}}</span>
</div>
<div class="form-group">
  <label for="Particulars">Name:</label>
  <span name="fullname">{{$driver_user->first_name . " " . $driver_user->middle_name . " " . $driver_user->last_name}}</span>
</div>
<div class="form-group">
  <label for="Particulars">Email Address:</label>
  <span name="email">{{$driver_user->email}}</span>
</div>


<div class="well">
  <div class="box-body no-padding">
    <ul class="nav nav-pills nav-stacked">
      <li><a href="#"><i class="fa fa-inbox"></i> Enable/Disable Account
        <span class="label pull-right">
          <label class="switch">
            <input type="checkbox" class="status" data-id="{{$driver_user->id}}" @if ($driver_user->status == 'enable') checked @endif>
            <span class="slider round"></span>
          </label>
        </span></a>
      </li>
    </ul>
  </div>

  <button type="button" class="btn btn-danger btn-block" style="margin-top:5%" data-toggle="modal" data-target="#resetPass">Reset Password</button>

  <!-- Modal for Reset Password-->
    <div class="modal fade" id="resetPass">
        <div class="modal-dialog">
            <div class="col-md-offset-2 col-md-8">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"> Confirm</h4>
                    </div>
                    <div class="modal-body row" style="margin: 0% 1%;">
                            <h1><i class="fa fa-exclamation-triangle pull-left text-yellow"> </i></h1>
                              <p>Are you sure you want to reset {{ $driver_user->name }}'s password?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" style="width:40%">Reset Password</button>

                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


</div>

@endsection

@section('scripts')
@parent
    <style>
    .switch {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 20px;
    }

    /* Hide default HTML checkbox */

    .switch input {
        display: none;
    }

    /* The slider */

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: gray;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 15px;
        width: 18px;
        left: 5px;
        bottom: 3px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #0275d8;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(13px);
        -ms-transform: translateX(13px);
        transform: translateX(13px);
    }

    /* Rounded sliders */

    .slider.round {
        border-radius: 100px;
    }

    .slider.round:before {
        border-radius: 80%;
    }
</style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
      $(document).ready(function(){
        $('.status').on('click', function(event){
          id = $(this).data('id');
          $.ajax({
            type: 'POST',
            url: "{{ URL::route('changeDriverStatus') }}",
            data: {
              '_token': $('input[name=_token]').val(),
              'id': id
            },
            success: function(data){
              //empty
            },
          });
        });
      });
    </script>
@endsection
