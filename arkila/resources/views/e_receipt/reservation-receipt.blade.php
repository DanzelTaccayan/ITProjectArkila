<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Arkila- BanTrans | Receipt</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  @include('layouts.partials.stylesheets')

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style>
    .table>tbody>tr>th,.table>tbody>tr>td {
      border-top: none;
    }
  </style>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          Arkila - BanTrans 
          <small class="pull-right">Date: {{Carbon\Carbon::now()->formatLocalized('%d %B %Y')}}</small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <div class="row"> 
      <div class="col-md-12"> 
        <div class="pull-right"> 
          <img src="{{ URL::asset('img/apple-touch-icon.png')}}" alt="arkila_logo" style="width:80px;height:80px;">
          <img src="{{ URL::asset('img/bantrans-logo.png') }}" alt="bantrans_logo" style="height:80px; width:80px;">
          <div class="clearfix">  </div>
        </div>
      </div>
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-12">
        <h4>Customer Information</h4>
      </div>
      <div class="col-sm-4 invoice-col">
        <table class="table borderless">
          <tbody>
            <tr>
              <th>Reservation Code:</th>
              <td>{{strtoupper($reservation->rsrv_code)}}</td>
            </tr>
          </tbody>
        </table>
        <address>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <table class="table borderless">
          <tbody>
            <tr>
              <th>Customer:</th>
              <td>{{$reservation->name}}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- /.col -->
      <div class="col-sm-3 invoice-col">
        <table class="table borderless">
          <tbody>
            <tr>
              <th>Receipt Type:</th>
              <td> Reservation
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <h4>Reservation Details</h4>
        <table class="table table-striped">
          <thead>
          <tr>
            <th>Terminal Origin</th>
            <th>Destination</th>
            <th>Departure Date</th>
            <th>Estimated Time</th>
            <th>Ticket Qty</th>
            <th>Fare</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td>{{$main->first()->destination_name}}</td>
            <td>{{$reservation->destination_name}}</td>
            <td>{{$reservation->reservationDate->reservation_date->formatLocalized('%d %B %Y')}}</td>
            <td class="text-right">{{date('g:i A', strtotime($reservation->reservationDate->departure_time))}}</td>
            <td class="text-right">{{$reservation->ticket_quantity}}</td>
            <td class="text-right">₱{{$reservation->fare - $rule->fee}}</td>
          </tr>
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <div class="col-xs-12">
        <h4>Receipt</h4>
      </div>
      <div class="col-xs-6">
        <div class="well">
          <div class="table-responsive">
            <table class="table ">
              <tr>
                <th style="width:50%">Subtotal:</th>
                <td class="text-right">₱{{number_format($reservation->fare - $rule->fee, 2)}}</td>
              </tr>
              <tr>
                <th>Reservation Fee</th>
                <td class="text-right">₱{{$rule->fee}}</td>
              </tr>
              <tr style="border-top: 2px solid black;">
                <th class="text-blue"><h4>Total:</h4></th>
                <td class="text-blue text-right"><h4>₱{{$reservation->fare}}</h4></td>
              </tr>
            </table>
          </div>
        </div>
        <div>
          <p><strong>Date Paid:</strong> {{$reservation->date_paid->formatLocalized('%d %B %Y')}}</p>
        </div>
      </div>
      <!-- /.col -->
      <div class="col-xs-4">
        <div>
          <p class="well text-center">PLEASE BRING A VALID ID</p>
        </div>
      </div>
      <!-- /.col -->

    </div>
    <!-- /.row -->


        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
          <strong>NOTE:</strong> If less than 24 hours before your specified departure time, if you will cancel now you will NOT be able to refund.
          If you cancel your reservation more than 1 day (24 Hours) before your specified departure time, you will receive a full refund excluding the reservation fee and an additional charge for the cancellation fee.
        </p>
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
