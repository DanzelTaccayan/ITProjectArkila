<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Arkila- BanTrans | Receipt</title>

  <style>
    .table>tbody>tr>th,.table>tbody>tr>td {
      border-top: none;
    }
  </style>

</head>
<body>
<div>
  <!-- Main content -->
  <section>
    <!-- title row -->
    <div>
      <div >
        <h2>
          Arkila - BanTrans 
          <small>Date: {{Carbon\Carbon::now()->formatLocalized('%d %B %Y')}}</small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div>
      <div >
        <h4>Customer Information</h4>
      </div>
      <div>
        <table>
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
      <div>
        <table>
          <tbody>
            <tr>
              <th>Customer:</th>
              <td>{{$reservation->name}}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- /.col -->
      <div>
        <table>
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
    <div>
       <div>
        <h4>Reservation Details</h4>
        <table>
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
            <td>{{date('g:i A', strtotime($reservation->reservationDate->departure_time))}}</td>
            <td>{{$reservation->ticket_quantity}}</td>
            <td>P{{number_format($reservation->fare + $reservation->reservation_fee, 2)}}</td>
          </tr>
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div>
       <div>
        <h4>Receipt</h4>
      </div>
      <div>
        <div>
          <div>
            <table>
            <tr>
                <th>Subtotal:</th>
                <td>P{{$reservation->fare}}</td>
              </tr>
              <tr>
                <th>Reservation Fee</th>
                <td>P{{$reservation->reservation_fee}}</td>
              </tr>
              <tr>
                <th><h4>Total:</h4></th>
                <td><h4>P{{number_format($reservation->fare + $reservation->reservation_fee, 2)}}</h4></td>
              </tr>
            </table>
          </div>
        </div>
        <div>
          <p><strong>Date Paid:</strong> {{$reservation->date_paid->formatLocalized('%d %B %Y')}}</p>
        </div>
      </div>
      <!-- /.col -->
      <div>
        <div>
          <p>PLEASE BRING A VALID ID</p>
        </div>
      </div>
      <!-- /.col -->

    </div>
    <!-- /.row -->


        <p>
          <strong>NOTE:</strong> If less than 24 hours before your specified departure time, if you will cancel now you will NOT be able to refund.
          If you cancel your reservation more than 1 day (24 Hours) before your specified departure time, you will receive a full refund excluding the reservation fee and an additional charge for the cancellation fee.
        </p>
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
