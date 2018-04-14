@extends('layouts.master')
@section('title','Dashboard')
@section('content')
<div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua">{{$numberOfOperators}}</span>
            <div class="info-box-content">
              <span class="info-box-text text-center" style="margin: 5px;">Operators</span>
              <span >
                <a type="button" href="{{route('operators.index')}}" class="btn btn-info center-block"><i class="fa fa-eye"></i> View operators</a>
                </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red">{{$numberOfVans}}</span>
            <div class="info-box-content">
              <span class="info-box-text text-center" style="margin: 5px;">Van units</span>
              <span>
                <a href="{{route('vans.index')}}" type="button" class="btn btn-danger center-block"><i class="fa fa-eye"></i> View units</a>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green">{{$numberOfReservations}}</span>

            <div class="info-box-content">
              <span class="info-box-text text-center" style="margin: 5px;">Reservations</span>
              <span>
                <a href="{{route('reservations.index')}}" type="button" class="btn btn-success center-block"><i class="fa fa-eye"></i> View requests</a>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow">{{$numberOfRentals}}</span>
            <div class="info-box-content">
              <span class="info-box-text text-center" style="margin: 5px;">Rentals</span>
              <span>
                  <a href="{{route('rental.index')}}" type="button" class="btn btn-warning center-block"><i class="fa fa-eye"></i> View requests</a>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>

      <!-- solid sales graph -->
      <div class="box box-solid bg-teal-gradient">
        <div class="box-header">
          <i class="fa fa-th"></i>

          <h3 class="box-title">Sales Graph</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i>
            </button>
          </div>
        </div>
        <div class="box-body border-radius-none">
          <div class="chart" id="line-chart" style="height: 250px;"></div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer no-border">
          <div class="row">
            <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
              <input type="text" class="knob" data-readonly="true" value="20" data-width="60" data-height="60"
                     data-fgColor="#39CCCC">
              <div class="knob-label">Mail-Orders</div>
            </div>
            <!-- ./col -->
            <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
              <input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60"
                     data-fgColor="#39CCCC">
              <div class="knob-label">Online</div>
            </div>
            <!-- ./col -->
            <div class="col-xs-4 text-center">
              <input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60"
                     data-fgColor="#39CCCC">
              <div class="knob-label">In-Store</div>
            </div>
            <!-- ./col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-footer -->
      </div>
@endsection
