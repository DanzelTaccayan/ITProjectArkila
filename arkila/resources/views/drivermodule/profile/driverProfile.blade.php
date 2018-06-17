@extends('layouts.driver')
@section('title', 'Driver Profile')
@section('content-title', 'Driver Home') @section('content')
<div class="row">
    <div class="col-md-5">
        <div class="box box-solid">
            <div class="box-body box-profile">

                <img class="profile-user-img img-responsive img-circle" src="{{ URL::asset('uploads/profilePictures/'.$profile->profile_picture) }}" alt="User profile picture">
                <h3 class="profile-username text-center" style="margin-bottom: 0">
                    {{ $profile->first_name.' '.$profile->middle_name.' '.$profile->last_name }}
                </h3>
                <div class="text-center">
                    <p>{{$profile->user->username}}</p> 
                </div>
                <div class="text-center">
                    <div class="text-center form-group">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#driverChangePassword" style="width:280px;">Account Settings</button>
                    </div>
                </div>
                <hr>
                <div class="padding-side-5">
                    <div class="text-center">
                        <h4>PERSONAL INFO</h4>
                    </div>
                    <p class="text-muted text-center"></p>
                        <label for="">Contact Number:</label>
                        <p class="info-container">{{$profile->contact_number}}</p>
                        <label for="">Address:</label>
                        <p class="info-container">{{$profile->address}}</p>
                        <p><strong>NOTE:</strong> If there is a mistake in your infomation please approach the clerk.</p>
                    <hr>
                    <div class="profile-van" style="margin-top: 10px;">
                        <div class="info-box">
                            <span class="info-box-icon bg-red"><i class="fa fa-automobile"></i></span>
                            <div class="info-box-content">
                              <h4><strong>{{auth()->user()->member->van->first()->plate_number ?? 'None'}}</strong></h4>
                              <p>{{auth()->user()->member->van->first()->model->description  ?? 'None'}}</p>
                              <p style="color: gray;">{{auth()->user()->member->van->first()->seating_capacity  ?? 'None'}} seats</p>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.box -->
</div>
<!-- CHANGE PASSWORD MODAL-->
<div class="modal" id="driverChangePassword">
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
                <form action="{{route('drivermodule.changePassword',[$driverId])}}" method="POST" data-parsley-validate="" class="parsley-form">
                    {{csrf_field()}} {{method_field('PATCH')}}
                    <div class="form-group" class="control-label">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="hidden" id="userid" value="{{$driverId}}">
                                <label for="">Current password:</label>
                            </div>
                            <div class="col-md-8"> 
                                <input value="" id="current_password" name="current_password" type="password" class="form-control" style="width: 100%;" val-cpassword required>
                                <div id="pass_response" class="response"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /.form-group -->
                    <hr>
                    <div class="form-group" class="control-label">
                       <div class="row">
                           <div class="col-md-4">
                               <label for="">New Password:</label>
                           </div>
                           <div class="col-md-8">
                               <input value="" id="newPassword" name="password" type="password" class="form-control" style="width: 100%;" required val-npassword required>
                           </div>
                       </div>
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group" class="control-label">
                       <div class="row">
                           <div class="col-md-4">
                               <label for="">Confirm New Password:</label>
                           </div>
                           <div class="col-md-8">
                               <input value="" id="confirmPassword" name="password_confirmation" type="password" class="form-control" style="width: 100%;">
                           </div>
                       </div>  
                    </div>
                    <!-- /.form-group -->
                <!-- /.modal-body -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-group-justified text-center">Save Changes</button>
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
