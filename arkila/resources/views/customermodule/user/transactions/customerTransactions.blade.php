@extends('layouts.customer_user')
@section('content')
<section id="mainSection" style="background-image: url('{{ URL::asset('img/customer_background.jpg') }}');">
        <div id="content">
            <div class="container">
                <div class="heading text-center">
                    <h2>MY TRANSACTIONS</h2>
                </div>
                <div class="col-md-8 mx-auto" id="boxContainer">
                    <div class="box border-bottom-0">
                        <ul class="nav nav-pills nav-fill">
                            <li class="nav-item"><a class="nav-link active" href="#rentals" data-toggle="tab">Rentals</a></li>
                            <li class="nav-item"><a class="nav-link" href="#reservations" data-toggle="tab">Reservations</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane table-responsive" id="rentals">
                                <table id="rentals" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Destination</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Time</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($rentals as $rental)
                                        <tr>
                                            <td>{{$rental->destination}}</td>
                                            <td>{{$rental->departure_date}}</td>
                                            <td>{{$rental->departure_time}}</td>
                                            <td>{{$rental->status}}</td>
                                            <td>
                                                <div class="text-center">
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
                                                      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteWarning{{$rental->rent_id}}">Delete</button>
                                                    @endif

                                                </div>
                                            </td>
                                        </tr>

                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- tab-pane-->
                            <div class="tab-pane table-responsive" id="reservations">
                                <table id="reservations" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Destination</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Time</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($reservations as $reservation)
                                        <tr>
                                            <td>{{$reservation->destination->description}}</td>
                                            <td>{{$reservation->departure_date}}</td>
                                            <td>{{$reservation->departure_time}}</td>
                                            <td>
                                                <div class="text-center">
                                                    <button id="viewReservationModal{{$reservation->id}}" type="button" class="btn btn-primary"
                                                    data-toggle="modal"
                                                    data-target="#viewReservation{{$reservation->id}}"
                                                    data-reservedestination="{{$reservation->destination->description}}"
                                                    data-reservecontact="{{$reservation->contact_number}}"
                                                    data-reserveseats="{{$reservation->number_of_seats}}"
                                                    data-reservedate="{{$reservation->departure_date}}"
                                                    data-reservetime="{{$reservation->departure_time}}"
                                                    data-reservecomment="{{$reservation->comments}}">View</button>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteWarning{{$reservation->id}}">Delete</button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- tab-pane-->
                        </div>
                        <!-- tab-content-->
                    </div>
                    <!-- box-->
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
                                <p>Are you sure you want to cancel this request?</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <form action="{{route('customermodule.cancelRental', [$rental->rent_id])}}" method="POST">
                                {{csrf_field()}}
                                {{method_field('PATCH')}}
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                <button type="submit" class="btn btn-danger" style="width:30%;">Yes</button>
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
                            <form action="{{route('customermodule.deleteRental', [$rental->rent_id])}}" method="POST">
                                {{csrf_field()}}
                                {{method_field('PATCH')}}
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                <button type="submit" class="btn btn-danger" style="width:30%;">Yes</button>
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
                                <button type="submit" class="btn btn-danger" style="width:30%;">Yes</button>
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
@stop
