@extends('layouts.driver')
@section('title', 'Driver Profile')
@section('content-title', 'Driver Home') @section('content')
<div class="col-md-6">
    <!-- Profile Image -->
    <div class="box box-primary">
        <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" src="{{ URL::asset('adminlte/dist/img/avatar.png') }}" alt="User profile picture">
            <h3 class="profile-username text-center">{{ $profile->first_name.' '.$profile->middle_name.' '.$profile->last_name }}</h3>
            <p class="text-muted text-center"></p>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <div class="col-md-6">
                <div class="text-center form-group">
                <button type="button" class="btn btn-primary btn-group-justified text-center" data-toggle="modal" data-target="#driverChangePassword">Change Password</button>
            </div>
            </div>
            <div class="col-md-6">
                <div>
                <i class="fa fa-bell"></i> Enable/Disable Notifications
                <span class="label pull-right">
                    <label class="switch">
                        <input type="checkbox" class="status" data-id="{{$profile->member_id}}"
                        @if($profile->notification === 'Enable') checked @endif>
                        <span class="slider round"></span>
                    </label>
                </span>
                </div>
            </div>
                       
            
            <!-- /.text -->
        </div>
        <!-- /.box-footer -->
    </div>
    <!-- /.box -->
</div>
<!-- /.col -->

<div class="col-md-6">
    <div class="box">
        <div class="box-header text-center">
            <h3 class="box-title">Personal Info</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <label for="">Contact Number:</label>
                    <p class="info-container">{{$profile->contact_number}}</p>
                </div>
                <!-- /.form -->
                <div class="col-md-8">
                    <label for="">Address:</label>
                    <p class="info-container">{{$profile->address}}</p>
                </div>
            </div>
            <!-- /.form -->
            <div class="row">
            <div class="col-md-4">
                <label for="">Birthday:</label>
                <p class="info-container">{{$profile->birth_date}}</p>
            </div>
            <!-- /.form -->
            <div class="col-md-4">
                <label for="">Trips Completed:</label>
                <p class="info-container">{{$counter}}</p>
            </div>
            <!-- /.form -->
            </div>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>
<!-- /.col -->

<!-- CHANGE PASSWORD MODAL-->
<div class="modal fade" id="driverChangePassword">
    <div class="modal-dialog" style="margin-top:150px;">
        <div class="col-md-offset-2 col-md-8">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change Password</h4>
                </div>
                <!-- /.modal-header -->
                <div class="modal-body">
                    <div class="box">
                        <div class="box-body">
                            <form action="{{route('drivermodule.changePassword',[$driverId])}}" method="POST">
                                {{csrf_field()}} {{method_field('PATCH')}}
                                <div class="form-group" class="control-label">
                                    <input type="hidden" id="userid" value="{{$driverId}}">
                                    <label for="">Current password:</label>
                                    <input value="" id="current_password" name="current_password" type="password" class="info-container">
                                    <div id="pass_response" class="response"></div>
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group" class="control-label">
                                    <label for="">New Password:</label>
                                    <input value="" id="" name="password" type="password" class="info-container" required>
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group" class="control-label">
                                    <label for="">Confirm New Password:</label>
                                    <input value="" id="" name="password_confirmation" type="password" class="info-container" required>
                                </div>
                                <!-- /.form-group -->

                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.modal-body -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-group-justified text-center">Submit</button>
                </div>
                <!-- /.modal-footer -->
                </form>
                <!-- /.form -->
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection @section('scripts') @parent

<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 20px;
    }

    /* Hide default HTML checkbox */

    .switch p {
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
        background-color: #ccc;
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

    p:checked+.slider {
        background-color: #2196F3;
    }

    p:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    p:checked+.slider:before {
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

<script>
    $(document).ready(function() {
        $('#current_password').keyup(function() {
            var id = $("#userid").val();
            var current_pass = $("#current_password").val();
            if (current_pass != '') {
                $('#pass_response').show();
                $.ajax({
                    type: 'POST',
                    url: "{{route('drivermodule.checkCurrentPassword')}}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'id': id,
                        'current_password': current_pass,
                    },
                    success: function(response) {
                        if (response.success) {
                            $("#pass_response").html("<span class='not-exists'>* Correct.</span>");
                        } else {
                            $("#pass_response").html("<span class='exists'>Wrong</span>");
                        }
                    }
                });
            } else {
                $('#pass_response').hide();
            }

        });

        $('.status').on('click', function(event) {
            id = $(this).data('id');
            $.ajax({
                type: 'POST',
                url: "{{ route('drivermodule.notification') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id': id
                },
                success: function(data) {
                    //empty
                },
            });
        });


    });
</script>

@endsection
