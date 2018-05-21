@extends('layouts.customer_user')
@section('content')
<section class="mainSection">
        <div id="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-9">
                        <div class=" boxContainer">
                            <div id="reservation">
                                <h4 class="text-center">NO RESERVATION.</h4>
                                <ul class="list-group">
                                    @foreach($rentals as $rental)
                                    <li class="list-group-item">
                                        <div class="row">
                                        <div class="col-md-6">
                                        
                                        <p>{{$rental->destination}}</p>
                                        
                                        <small>
                                            @if($rental->status === 'Pending')
                                        <i class="fa fa-circle-o" style="color:orange;"></i>
                                        Request:
                                        @elseif($rental->status === 'Accepted')
                                        <i class="fa fa-check-circle" style="color:green;"></i>
                                        Request:
                                        @elseif($rental->status === 'Declined' | $rental->status ==='Cancelled' )
                                        <i class="fa fa-times-circle" style="color:red;"></i>
                                        Request:
                                         @elseif($rental->status === 'Departed')
                                        <i class="fa fa-truck" style="color:blue;"></i>
                                        Departed: 
                                        @endif
                                        <span style="color: gray;">{{$rental->departure_date}} {{$rental->departure_time}}</span></small>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="pull-right">
                                                    <button id="viewRentalModal{{$rental->rent_id}}" type="button" class="btn btn-primary"
                                                    data-toggle="modal"
                                                    data-target="#viewRental{{$rental->rent_id}}"
                                                    data-rentvehicle="{{$rental->vanmodel->description ?? null}}"
                                                    data-rentdestination="{{$rental->destination}}"
                                                    data-rentcontact="{{$rental->contact_number}}"
                                                    data-rentdays="{{$rental->number_of_days}}"
                                                    data-rentdate="{{$rental->departure_date}}"
                                                    data-renttime="{{$rental->departure_time}}"
                                                    data-rentcomment="{{$rental->comments}}"
                                                    @if($rental->status === 'Accepted' && $rental->model_id != null && $rental->plate_number != null)
                                                    @endif>View</button>
                                                    @if($rental->status === 'Accepted')
                                                      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#cancelWarning{{$rental->rent_id}}">Cancel</button>
                                                    @elseif($rental->status === 'Declined' || $rental->status === 'Pending')
                                                      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteWarning{{$rental->rent_id}}">Cancel</button>
                                                    @endif

                                                </div>
                                        </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!-- box-->
                    </div>
                    <div class="col-md-3 mt-4 mt-md-0">
                      <!-- CUSTOMER MENU -->
                      <div class="panel panel-default sidebar-menu">
                        <div class="panel-heading">
                          <h3 class="h4 panel-title">MY TRANSACTIONS</h3>
                        </div>
                        <div class="panel-body">
                          <ul class="nav nav-pills flex-column text-sm">
                            <li class="nav-item"><a href="customer-orders.html" class="nav-link active"><i class="fa fa-list"></i>My Rentals</a></li>
                            <li class="nav-item"><a href="customer-wishlist.html" class="nav-link"><i class="fa fa-heart"></i> My Reservations</a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                </div>
                <!-- boxContainer-->
            </div>
            <!-- container-->
        </div>
        <!-- content-->
    </section>
    <!-- mainSection-->
    @foreach($rentals as $rental)
    <div id="viewRental{{$rental->rent_id}}" aria-hidden="true" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Rental Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Type of Vehicle</th>
                                <td id="vehicleType{{$rental->rent_id}}"></td>
                            </tr>
                            <tr>
                                <th>Destination</th>
                                <td id="rentalDestination{{$rental->rent_id}}"></td>
                            </tr>
                            <tr>
                                <th>Contact Number</th>
                                <td id="rentalContactNumber{{$rental->rent_id}}"></td>
                            </tr>
                            <tr>
                                <th>Number of Days</th>
                                <td id="rentalNumOfDays{{$rental->rent_id}}"></td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td id="rentalDate{{$rental->rent_id}}"></td>
                            </tr>
                            <tr>
                                <th>Time</th>
                                <td id="rentalTime{{$rental->rent_id}}"></td>
                            </tr>
                            <tr>
                                <th>Comments</th>
                                <td id="rentalComment{{$rental->rent_id}}"></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Reservation Details Modal-->
    @foreach($reservations as $reservation)
    <div id="viewReservation{{$reservation->id}}" aria-hidden="true" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Reservation Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Destination</th>
                                <td id="reservationDest{{$reservation->id}}"></td>
                            </tr>
                            <tr>
                                <th>Contact Number</th>
                                <td id="reservationContactNumber{{$reservation->id}}"></td>
                            </tr>
                            <tr>
                                <th>Number of Seats</th>
                                <td id="reservationSeats{{$reservation->id}}"></td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td id="reservationDate{{$reservation->id}}"></td>
                            </tr>
                            <tr>
                                <th>Time</th>
                                <td id="reservationTime{{$reservation->id}}"></td>
                            </tr>
                            <tr>
                                <th>Comments</th>
                                <td id="reservationComment{{$reservation->id}}"></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @foreach($rentals as $rental)
    <div class="modal fade" id="cancelWarning{{$rental->rent_id}}">
        <div class="modal-dialog">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Confirm</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body row" style="margin: 0% 1%;">
                            <div class="col-md-2" style="font-size: 35px; margin-top: 7px;">
                                <i class="fa fa-exclamation-triangle pull-left" style="color:#d9534f;">  </i>
                            </div>
                            <div class="col-md-10">
                                <p>Are you sure you want to cancel this request?</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <form action="{{route('customermodule.cancelRental', [$rental->rent_id])}}" method="POST">
                                {{csrf_field()}}
                                {{method_field('PATCH')}}
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                <button type="submit" class="btn btn-danger">Yes</button>
                            </form>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.col -->
            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>
    @endforeach
    <!-- Delete Modal-->
    @foreach($rentals as $rental)
    <div class="modal fade" id="deleteWarning{{$rental->rent_id}}">
        <div class="modal-dialog">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Confirm</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body row" style="margin: 0% 1%;">
                            <div class="col-md-2" style="font-size: 35px; margin-top: 7px;">
                                <i class="fa fa-exclamation-triangle pull-left" style="color:#d9534f;">  </i>
                            </div>
                            <div class="col-md-10">
                                <p>Are you sure you want to delete this request?</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <form action="{{route('customermodule.deleteRental', [$rental->rent_id])}}" method="POST">
                                {{csrf_field()}}
                                {{method_field('PATCH')}}
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                <button type="submit" class="btn btn-danger">Yes</button>
                            </form>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.col -->
            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>
    @endforeach
    <!-- /.modal -->
    @foreach($reservations as $reservation)
    <div class="modal fade" id="deleteWarning{{$reservation->id}}">
        <div class="modal-dialog">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Confirm</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body row" style="margin: 0% 1%;">
                            <div class="col-md-2" style="font-size: 35px; margin-top: 7px;">
                                <i class="fa fa-exclamation-triangle pull-left" style="color:#d9534f;">  </i>
                            </div>
                            <div class="col-md-10">
                                <p>Are you sure you want to delete this request?</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <form action="{{route('customermodule.deleteReservation', [$reservation->id])}}" method="POST">
                            {{csrf_field()}}
                            {{method_field('DELETE')}}
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                <button type="submit" class="btn btn-danger">Yes</button>
                            </form>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.col -->
            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>
    @endforeach
@stop

@section('scripts')
@parent
    @foreach($rentals as $rental)
        <script>
            $(document).ready(function(){
                $('#viewRentalModal{{$rental->rent_id}}').click(function(){
                    $('#vehicleType{{$rental->rent_id}}').html($(this).data('rentvehicle}'));
                    $('#rentalDestination{{$rental->rent_id}}').html($(this).data('rentdestination'));
                    $('#rentalContactNumber{{$rental->rent_id}}').html($(this).data('rentcontact'));
                    $('#rentalNumOfDays{{$rental->rent_id}}').html($(this).data('rentdays'));
                    $('#rentalDate{{$rental->rent_id}}').html($(this).data('rentdate'));
                    $('#rentalTime{{$rental->rent_id}}').html($(this).data('renttime'));
                    $('#rentalComment{{$rental->rent_id}}').html($(this).data('rentcomment'));
                });
            });
        </script>
    @endforeach
    @foreach($reservations as $reservation)
        <script>
            $(document).ready(function(){
                $('#viewReservationModal{{$reservation->id}}').click(function(){
                    $('#reservationDest{{$reservation->id}}').html($(this).data('reservedestination').toString());
                    $('#reservationContactNumber{{$reservation->id}}').html($(this).data('reservecontact').toString());
                    $('#reservationSeats{{$reservation->id}}').html($(this).data('reserveseats').toString());
                    $('#reservationDate{{$reservation->id}}').html($(this).data('reservedate').toString());
                    $('#reservationTime{{$reservation->id}}').html($(this).data('reservetime').toString());
                    $('#reservationComment{{$reservation->id}}').html($(this).data('reservecomment').toString());
                    // console.log(r.toString());
                    // console.log(r);
                });
            });
        </script>
    @endforeach
    <script>
        $(document).ready(function() {
            $('#rental').DataTable({
                'paging': false,
                'lengthChange': false,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': true
            });
            $('#reservation').DataTable({
                'paging': false,
                'lengthChange': false,
                'searching': false,
                'ordering': true,
                'info': true,
                'autoWidth': true
            });
        });
    </script>
@stop
