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
      <div>
        <h2>
          Arkila - BanTrans 
          <small>Date: {{Carbon\Carbon::now()->formatLocalized('%d %B %Y')}}</small>
        </h2>
      </div>
      <!-- /.col -->
    </div>

    <!-- info row -->
    <div>
      <div>
        <h4>Customer Information</h4>
      </div>
      <div>
        <table>
          <tbody>
            <tr>
              <th>Rental Code:</th>
              <td>{{strtoupper($rental->rental_code)}}</td>
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
              <td>{{$rental->customer_name}}</td>
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
              <td> Rental
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
        <h4>Itenerary</h4>
        <table>
          <thead>
          <tr>
            <th>Destination</th>
            <th>Departure Date</th>
            <th>Departure Time</th>
            <th>Number of Days</th>
            <th>Fare</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td>{{$rental->destination}}</td>
            <td>{{$rental->departure_date->formatLocalized('%d %B %Y')}}</td>
            <td>{{date('g:i A', strtotime($rental->departure_time))}}</td>
            <td>{{$rental->number_of_days}}</td>
            <td>P{{$rental->rental_fare}}</td>
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
        <div>
          <div>
            <table>
            @if($destinations)
              <tr>
                <th>Subtotal:</th>
                <td>P{{number_format($rental->rental_fare - $rental->rental_fee, 2)}}</td>
              </tr>
              <tr>
                <th>Rental Fee</th>
                <td>P{{$rental->rental_fee}}</td>
              </tr>
              <tr>
                <th><h4>Total:</h4></th>
                <td><h4>P{{number_format($rental->rental_fare, 2)}}</h4></td>
              </tr>
              @else
              <tr>
                <th>Subtotal:</th>
                <td>P{{$rental->rental_fare}}</td>
              </tr>
              <tr>
                <th>Rental Fee</th>
                <td>P0.00</td>
              </tr>

              <tr>
                <th><h4>Total:</h4></th>
                <td><h4>P{{$rental->rental_fare}}</h4></td>
              </tr>
              @endif              
            </table>
          </div>
        </div>
        <div>
          <p><strong>Date Paid:</strong> {{Carbon\Carbon::now()->formatLocalized('%d %B %Y')}}</p>
        </div>
      </div>
      <!-- /.col -->
      <div>
          <h4>Van Details</h4>
          <table>
            <thead>
              <tr>
                <th>Van Unit</th>
                <th>Van Model</th>
                <th>Seating Capacity</th>
                <th>Driver</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{$rental->van->plate_number}}</td>
                <td>{{$rental->van->model->description}}</td>
                <td>{{$rental->van->seating_capacity}}</td>
                <td>{{$rental->driver->full_name}}</td>
              </tr>
            </tbody>
          </table>
        <div>
          <p>PLEASE BRING A VALID ID</p>
        </div>
      </div>
      <!-- /.col -->

    </div>
    <!-- /.row -->


        <p>
          <strong>NOTE:</strong> Its less than 24 hours before your specified departure time, if you will cancel now you will NOT be able to refund. 
          If you cancel your rental more than 1 day (24 Hours) before your specified departure time, you will receive a full refund excluding the rental fee, if any. A cancellation fee will also be charged.
        </p>
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
