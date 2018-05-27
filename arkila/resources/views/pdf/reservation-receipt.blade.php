<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BanTrans | Reservation Receipt</title>
    @include('layouts.partials.stylesheets')
</head>
<body onload="window.print();">   
<div class="wrapper">   
    <section class="receipt">   
        <div class="row">
          <div class="col-xs-12">
            <h2 class="page-header">
              <strong>RESERVATION CODE:</strong>
              <small class="pull-right">Date: 2/10/2014</small>
            </h2>
          </div>
          <!-- /.col -->
        </div> 
        <div class="row invoice-info">
          <div class="col-sm-4 invoice-col">
            Contact Us
            <address>
              <strong>Admin, Inc.</strong><br>
              795 Folsom Ave, Suite 600<br>
              San Francisco, CA 94107<br>
              Phone: (804) 123-5432<br>
              Email: info@almasaeedstudio.com
            </address>
        </div> 
    </section>
</div>
</body>
</html>