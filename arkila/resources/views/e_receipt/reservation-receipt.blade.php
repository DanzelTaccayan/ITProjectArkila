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
          <i class="fa fa-globe"></i> Arkila - BanTrans 
          <small class="pull-right">Date: 2/10/2014</small>
        </h2>
      </div>
      <!-- /.col -->
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
              <td>RV1234567890</td>
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
              <td>John Doe</td>
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
            <th>Terminal</th>
            <th>Destination</th>
            <th>Departure Date</th>
            <th>Estimated Time</th>
            <th>Ticket Qty</th>
            <th>Fare</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td>San Jose</td>
            <td>Asingan</td>
            <td>20 May 2019</td>
            <td class="text-right">1:00 PM</td>
            <td class="text-right">1</td>
            <td class="text-right">₱ 200.00</td>
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
                <td class="text-right">₱ 200.00</td>
              </tr>
              <tr>
                <th>Reservation Fee</th>
                <td class="text-right">₱ 200.00</td>
              </tr>
              <tr style="border-top: 2px solid black;">
                <th class="text-blue"><h4>Total:</h4></th>
                <td class="text-blue text-right"><h4>₱ 400.00</h4></td>
              </tr>
            </table>
          </div>
        </div>
        <div>
          <p><strong>Date Paid:</strong> 20 May 2019</p>
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
          <strong>NOTE:</strong> Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr
          jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
        </p>
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
