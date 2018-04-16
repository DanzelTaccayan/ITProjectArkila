@extends('layouts.master') 
@section('title', 'Notifications') 
@section('content-header','Notifications')
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

@endsection