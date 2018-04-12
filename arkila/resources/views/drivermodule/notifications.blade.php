@extends('layouts.driver')
@section('title', 'Driver Profile')
@section('content-title', 'Driver Profile')
@section('content')
<div class="desktop">
  <div class="col-md-6">
    <div class="box">
        <div class="box-header with-border">
            <i class="fa fa-bell"></i>
            <h3 class="box-title">Notifications</h3>

            <div class="pull-right">
              <a href="#">Mark All as Read</a>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="list-group">
            <a href="" class="list-group-item">
                  <p><span class="text-green fa fa-check-circle"></span> Accepted </p>
                  <small>10/10/2018 01:00 PM</small>
            </a>
            <a href="" class="list-group-item">
              <p><span class="text-red fa fa-times-circle"></span> Deleted/Cancelled</p>
              <small>10/10/2018 01:00 PM</small>
            </a>
            <a href="" class="list-group-item">
              <p><span class="text-blue fa fa-info-circle"></span> Information </p>
              <small>10/10/2018 01:00 PM</small>
            </a>
            <a href="" class="list-group-item">
              <p><span class="text-yellow fa fa-truck"></span> Departed </p>
              <small>10/10/2018 01:00 PM</small>
            </a>
          </div>

        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</div>
<!-- /.desktop -->

@endsection @section('scripts') @parent


<style>
    /* if desktop */

    .mobile_device_380px {
        display: none;
    }

    .mobile_device_480px {
        display: none;
    }


    /* if mobile device max width 380px */

    @media only screen and (max-device-width: 380px) {
        .mobile_device_380px {
            display: block;
        }
        .desktop {
            display: none;
        }
    }

    /* if mobile device max width 480px */

    @media only screen and (max-device-width: 480px) {
        .mobile_device_480px {
            display: block;
        }
        .desktop {
            display: none;
        }
    }
</style>

@endsection
