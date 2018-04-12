@extends('layouts.driver')
@section('title', 'Driver Profile')
@section('content-title', 'Driver Profile')
@section('content')
<div class="desktop">
  <div class="col-md-9">

        <div>
            
            <h4><i class="fa fa-bell pull-left"></i> Notifications</h4>

            <a href="#"  class="pull-right">Mark All as Read</a>
            <div class="clearfix">  </div>
        </div>
        <!-- /.box-header -->
        <div class="">
          <div class="list-group">
            <a href="" class="list-group-item" style="margin-top: 5px;">
                  <p style="margin:0 0 0;"> Accepted </p>
                  <span class="text-green fa fa-check-circle"></span> <small>10/10/2018 01:00 PM</small>
            </a>
            <a href="" class="list-group-item" style="margin-top: 5px;">
              <p style="margin:0 0 0;"><span class="text-red fa fa-times-circle"></span> Deleted/Cancelled</p>
              <small>10/10/2018 01:00 PM</small>
            </a>
            <a href="" class="list-group-item" style="margin-top: 5px;">
              <p style="margin:0 0 0;"><span class="text-blue fa fa-info-circle"></span> Information </p>
              <small>10/10/2018 01:00 PM</small>
            </a>
            <a href="" class="list-group-item" style="margin-top: 5px;">
              <p style="margin:0 0 0;"><span class="text-yellow fa fa-truck"></span> Departed </p>
              <small>10/10/2018 01:00 PM</small>
            </a>
          </div>

        </div>
        <!-- /.box-body -->
    <!-- /.box -->
  </div>
</div>
<!-- /.desktop -->

@endsection @section('scripts') @parent

{{-- 
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
</style> --}}

@endsection
