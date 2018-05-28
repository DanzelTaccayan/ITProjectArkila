@extends('layouts.landing')
@section('content')
  
<!--Start confirm password box-->
<input type="hidden" name="token" value="{{$token}}">
<div style="margin-left:20%; margin-right:20%;">
    <div class="box box-solid box-primary">
        <div class="box-header">
            <h1 class="box-title">Reset Password</h1>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          @include('message.error')
                <!-- /.row -->
                <div class="row form-group">
                    <label class="control-label col-sm-3">Email:</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="email" name="email" value="{{$email}}" required>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="row form-group">
                    <label class="control-label col-sm-3">New Password:</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="password_confirmation" name="password" placeholder="Enter new password" required>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <div class="row form-group">
                    <label class="control-label col-sm-3">Repeat New Password:</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Enter new password" required>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <div class="row form-group pull-right">
                    <div>
                        <button type="submit" class="btn btn-flat btn-primary">Submit</button>
                    </div>
                </div>
                <!-- /.row -->
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>
@endsection
