@extends('layouts.customer_user')
@section('content')
<section class="mainSection">
        <div id="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 mt-4 mt-md-0">
                      <!-- CUSTOMER MENU -->
                      <div class="panel panel-default sidebar-menu">
                        <div class="panel-heading">
                          <h3 class="h4 panel-title">MY TRANSACTIONS</h3>
                        </div>
                        <div class="panel-body">
                          <ul class="nav nav-pills flex-column text-sm">
                            <li class="nav-item"><a href="{{route('customermodule.rentalTransaction')}}" class="nav-link"><i class="fa fa-circle-o"></i> My Rentals</a></li>
                            <li class="nav-item"><a href="#" class="nav-link active"><i class="fa fa-circle-o"></i> My Reservations</a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-9">
                        <div class=" boxContainer" style="min-height:350px;">
                            <div id="reservation">
                            @if ($requests->count() == 0)
                                <h2 class="text-center"  style="padding-top: 10%; color: lightgray;">NO TRANSACTION.</h2>
                            @else
                                <ul class="list-group">
                                    @foreach($requests as $reservation)
                                    <li class="list-group-item">
                                        <div class="row">
                                        <div class="col-md-6">
                                        
                                        <h4 style="margin-bottom: 1px;">{{$reservation->destination_name}}</h4>
                                        <p style="color: gray;">{{$reservation->created_at->formatLocalized('%d %B %Y')}} {{ date('g:i A', strtotime($reservation->created_at)) }}</p>

                                        <small>
                                        @if($reservation->status === 'UNPAID')
                                        <i class="fa fa-circle-o" style="color:red;"></i>
                                        {{strtoupper($reservation->status)}}
                                         @elseif($reservation->status === 'PAID')
                                        <i class="fa fa-check-circle" style="color:green;"></i>
                                        {{strtoupper($reservation->status)}}
                                        @elseif($reservation->status === 'CANCELLED')
                                        <i class="fa fa-check-circle" style="color:red;"></i>
                                        {{strtoupper($reservation->status)}}
                                        @elseif($reservation->status === 'REFUNDED')
                                        <i class="fa fa-check-circle" style="color:blue;"></i>
                                        {{strtoupper($reservation->status)}}
                                        @elseif($reservation->status === 'TICKET ON HAND')
                                        <i class="fa fa-check-circle" style="color:yellow;"></i>
                                        {{strtoupper($reservation->status)}}
                                        @elseif($reservation->status === 'EXPIRED')
                                        <i class="fa fa-check-circle" style="color:red;"></i>
                                        {{strtoupper($reservation->status)}}


                                        @endif
                                        </small>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="pull-right">
                                            @if($reservation->status == 'UNPAID' || $reservation->status == 'PAID' || $reservation->status == 'TICKET ON HAND')
                                                <button class="btn btn-default" data-toggle="modal" data-target="#reservationCancel{{$reservation->id}}">CANCEL</button>
                                            @endif
                                                <button id="viewRentalModal{{$reservation->id}}" type="button" class="btn btn-primary" data-toggle="modal" data-target="#{{'reservationView'.$reservation->id}}">View</button>       
                                            </div>
                                        </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                        <!-- box-->
                    </div>
                    @foreach($requests as $reservation)
                    <div class="modal fade" id="reservationCancel{{$reservation->id}}">
                        <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-red">
                                        <h4 class="modal-title">WARNING</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                    @php $time = explode(':', $reservation->reservationDate->departure_time); @endphp
                                    @if($reservation->status == 'PAID')
                                    @if(Carbon\Carbon::now()->gt($reservation->reservationDate->reservation_date->subDays(1)->setTime($time[0], $time[1], $time[2])))
                                    <p>Its less than 24 hours before your specified departure time, if you will cancel now <strong class="text-red">you will NOT be able to refund</strong>.
                                    Are you sure you want to cancel your reservation?</p>
                                    @else
                                    <p>If you cancel your reservation more than 1 day (24 Hours) before your specified departure time, you will receive a full refund excluding the reservation fee and an additional charge for the cancellation fee.
                                    Are you sure you want to cancel your reservation?</p>
                                    @endif
                                    @elseif($reservation->status == 'PENDING' || $reservation->status == 'UNPAID')
                                    <p>Are you sure you want to cancel your reservation?</p>
                                    @endif
                                    </div>
                                    <div class="modal-footer">   
                                        <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                                        <form action="{{route('reservation.cancel', $reservation->id)}}" method="POST">
                                        {{csrf_field()}} {{method_field('PATCH')}}
                                        <button type="submit" name="cancel" value="Cancel" class="btn btn-danger">CANCEL</button>
                                        </form>
                                    </div>
                                </div>
                        </div>
                        <!-- /.modal-dialog -->
                    </div>

                    <div class="modal fade" id="{{'reservationView'.$reservation->id}}">
                        <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-red">
                                        <h4 class="modal-title">RESERVATION DETAILS</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-striped table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Reservation Code</th>
                                                    <td>{{strtoupper($reservation->rsrv_code)}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Destination</th>
                                                    <td>{{$reservation->destination_name}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Departure Date</th>
                                                    <td>{{$reservation->reservationDate->reservation_date->formatLocalized('%d %B %Y')}} {{date('g:i A', strtotime($reservation->reservationDate->departure_time))}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Departure Day</th>
                                                    <td>{{$reservation->reservationDate->reservation_date->formatLocalized('%A')}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Expiry Date</th>
                                                    <td>{{$reservation->expiry_date->formatLocalized('%d %B %Y')}} {{$reservation->expiry_date->format('g:i A')}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    @if($reservation->status == 'UNPAID' && Carbon\Carbon::now()->gt($reservation->expiry_date))
                                                    <td>Expired</td>
                									@else
                                                    <td>{{$reservation->status}}</td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <th>Ticket Qty</th>
                                                    <td>{{$reservation->ticket_quantity}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Total Fee</th>
                                                    <td>₱{{number_format($reservation->fare + $reservation->reservation_fee, 2)}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Refund Code</th>
                                                    @if($reservation->status == 'UNPAID' && Carbon\Carbon::now()->gt($reservation->expiry_date))
                                                    <td>Expired</td>
                									@elseif($reservation->status == 'REFUNDED')
                                                    <td>REFUNDED</td>
                                                    @elseif($reservation->status == 'CANCELLED' && $reservation->is_refundable == false)
                                                    <td>CANCELLED</td>
                                                    @else
                                                    <td>{{$reservation->refund_code ?? 'Please pay first to get a refund code.'}}</td>
                                                    @endif
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">   
                                        <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                                        @if($reservation->status == 'PAID')
                                        <a href="{{route('reservation.receipt', $reservation->id)}}" class="btn btn-info"><i class="fa fa-download"></i> Receipt</a> 
                                        @endif
                                    </div>
                                </div>
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                </div>
                    @endforeach
                <!-- boxContainer-->
            </div>
            <!-- container-->
        </div>
        <!-- content-->
    </section>
    <!-- mainSection-->
@stop