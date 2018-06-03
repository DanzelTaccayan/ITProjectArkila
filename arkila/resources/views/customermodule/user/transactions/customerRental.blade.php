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
                            <li class="nav-item"><a href="#" class="nav-link active"><i class="fa fa-circle-o"></i>My Rentals</a></li>
                            <li class="nav-item"><a href="{{route('customermodule.reservationTransaction')}}" class="nav-link"><i class="fa fa-circle-o"></i> My Reservations</a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-9">
                        <div class=" boxContainer" style="min-height:350px;">
                            <div id="reservation">
                            @if ($requests->count() == 0)
                                <h2 class="text-center" style="padding-top: 10%">NO RENTAL AVAILABLE.</h2>
                            @else
                                <ul class="list-group">
                                    @foreach($requests as $rental)
                                    <li class="list-group-item">
                                        <div class="row">
                                        <div class="col-md-6">
                                        
                                        <h4 style="margin-bottom: 1px;">{{$rental->destination}}</h4>
                                        <p style="color: gray;">{{$rental->created_at->formatLocalized('%d %B %Y')}} {{ date('g:i A', strtotime($rental->created_at)) }}</p>

                                        <small>
                                        @if($rental->status == 'Pending')
                                        <i class="fa fa-circle" style="color:gray;"></i>
                                        {{strtoupper($rental->status)}}
                                        @elseif($rental->status == 'Unpaid')
                                        <i class="fa fa-dot-circle-o" style="color:orange;"></i>
                                        {{strtoupper($rental->status)}}
                                         @elseif($rental->status == 'Paid')
                                        <i class="fa fa-check-circle" style="color:green;"></i>
                                        {{strtoupper($rental->status)}}
                                        @elseif($rental->status == 'Cancelled')
                                        <i class="fa fa-minus-circle" style="color:gray;"></i>
                                        {{strtoupper($rental->status)}}
                                        @elseif($rental->status == 'Departed')
                                        <i class="fa fa-chevron-circle-right" style="color:navyblue;"></i>
                                        {{strtoupper($rental->status)}}
                                        @elseif($rental->status == 'Expired')
                                        <i class="fa fa-times-circle" style="color:red;"></i>
                                        {{strtoupper($rental->status)}}
                                        @elseif($rental->status == 'No Van Available')
                                        <i class="fa fa-times-circle" style="color:red;"></i>
                                        {{strtoupper($rental->status)}}

                                        @endif
                                        </small>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="pull-right">
                                                    @if($rental->status == 'Paid' || $rental->status == 'Unpaid' || $rental->status == 'Pending')
                                                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#cancelModal{{$rental->rent_id}}">Cancel</button>                                           
                                                    @endif
                                                    <button id="viewRentalModal{{$rental->id}}" type="button" class="btn btn-primary" data-toggle="modal" data-target="#rentalView{{$rental->rent_id}}">View</button>
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
                </div>
                <!-- boxContainer-->
            </div>
            <!-- container-->
            @foreach ($requests as $rental)
            <div class="modal fade" id="{{'cancelModal'.$rental->rent_id}}">
                        <div class="modal-dialog">
                                <div class="modal-content">    
                                    <div class="modal-header bg-red">
                                        <h4 class="modal-title">WARNING</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                    @php $time = explode(':', $rental->departure_time); @endphp
                                    @if($rental->status == 'Paid')
                                    @if(Carbon\Carbon::now()->gt($rental->departure_date->subDays(1)->setTime($time[0], $time[1], $time[2])))
                                    <p>Its less than 24 hours before your specified departure time, if you will cancel now <strong class="text-red">you will NOT be able to refund</strong>.
                                    Are you sure you want to cancel your van rental?</p>
                                    @else
                                    <p>If you cancel your rental more than 1 day (24 Hours) before your specified departure time, you will receive a full refund minus a cancellation fee.
                                    Are you sure you want to cancel your van rental?</p>
                                    @endif
                                    @elseif($rental->status == 'Pending' || $rental->status == 'Unpaid')
                                    <p>Are you sure you want to cancel your van rental?</p>
                                    @endif

                                    </div>
                                    <div class="modal-footer">   
                                        <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                                        <form action="{{route('rental.cancel', $rental->rent_id)}}" method="POST">
                                        {{csrf_field()}} {{method_field('PATCH')}}
                                        <button type="submit" name="cancel" value="Cancel" class="btn btn-danger">CANCEL</button>
                                        </form>

                                    </div>
                                </div>
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                    <div class="modal fade" id="{{'rentalView'.$rental->rent_id}}">
                        <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-red">
                                        <h4 class="modal-title">RENTAL DETAILS</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-striped table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Rental Code</th>
                                                    <td>{{$rental->rental_code}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Destination</th>
                                                    <td>{{$rental->destination}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Departure Date</th>
                                                    <td>{{$rental->departure_date->formatLocalized('%d %B %Y')}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Departure Time</th>
                                                    <td>{{date('g:i A', strtotime($rental->departure_time))}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Departure Day</th>
                                                    <td>{{$rental->departure_date->formatLocalized('%A')}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Number of Rental Days</th>
                                                    <td>{{$rental->number_of_days}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Expiry Date</th>
                                                    @if($rental->status == 'Pending')
                                                    <td>{{$rental->created_at->addDays(2)->formatLocalized('%d %B %Y')}}</td>
                                                    @elseif($rental->status == 'Unpaid' || $rental->status == 'Paid')
                                                    <td>{{$rental->updated_at->addDays(2)->formatLocalized('%d %B %Y')}}</td>
                                                    @elseif($rental->status == 'Cancelled' && $rental->is_refundable == true)
                                                    <td>{{$rental->updated_at->addDays(7)->formatLocalized('%d %B %Y')}}</td>
                                                    @else
                                                    <td>{{$rental->status}}</td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    <td>{{$rental->status}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Van Unit</th>
                                                    <td>{{$rental->van->plate_number ?? 'No van assigned'}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Driver</th>
                                                    <td>{{$rental->driver->full_name ?? 'No driver assigned.'}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Driver Contact Number</th>
                                                    <td>{{$rental->driver->contact_number ?? 'No driver assigned.'}}</td>
                                                </tr>
                                                @if($rental->status == 'Paid' || $rental->status == 'Refunded' || $rental->status == 'Unpaid' || $rental->status == 'Cancelled')
                                                <tr>
                                                    <th>Refund Code</th>
                                                    @if($rental->status == 'Cancelled' && $rental->is_refundable == false)
                                                    <td>CANCELLED</td>
                                                    @elseif($rental->status == 'Refunded')
                                                    <td>REFUNDED</td>
                                                    @else
                                                    <td>{{$rental->refund_code ?? 'Please pay first to get the refund code.'}}</td>
                                                    @endif
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">   
                                        <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                                        @if($rental->status == 'Paid')
                                        <button onclick="window.open('{{route('rental.receipt', $rental->rent_id)}}')" class="btn btn-info"><i class="fa fa-download"></i> Receipt</button> 
                                        @endif
                                    </div>
                                </div>
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
            @endforeach

        </div>
        <!-- content-->
    </section>
    <!-- mainSection-->
@stop