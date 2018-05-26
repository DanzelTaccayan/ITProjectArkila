@extends('layouts.customer_user')
@section('content')
<section class="mainSection">
        <div id="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-9">
                        <div class=" boxContainer">
                            <div id="reservation">
                            @if ($requests == 0)
                                <h4 class="text-center">NO RESERVATION.</h4>
                            @else
                                <ul class="list-group">
                                    @foreach($rentals as $rental)
                                    <li class="list-group-item">
                                        <div class="row">
                                        <div class="col-md-6">
                                        
                                        <h4 style="margin-bottom: 1px;">{{$rental->destination}}</h4>
                                        <p style="color: gray;">{{$rental->created_at->formatLocalized('%d %B %Y')}} {{ date('g:i A', strtotime($rental->created_at)) }}</p>

                                        <small>
                                        @if($rental->status === 'Unpaid')
                                        <i class="fa fa-circle-o" style="color:red;"></i>
                                        {{strtoupper($rental->status)}}
                                         @elseif($rental->status === 'Paid')
                                        <i class="fa fa-check-circle" style="color:green;"></i>
                                        {{strtoupper($rental->status)}}
                                        @endif
                                        </small>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="pull-right">
                                                    <button id="viewRentalModal{{$rental->id}}" type="button" class="btn btn-primary">View</button>                                           
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
                    <div class="col-md-3 mt-4 mt-md-0">
                      <!-- CUSTOMER MENU -->
                      <div class="panel panel-default sidebar-menu">
                        <div class="panel-heading">
                          <h3 class="h4 panel-title">MY TRANSACTIONS</h3>
                        </div>
                        <div class="panel-body">
                          <ul class="nav nav-pills flex-column text-sm">
                            <li class="nav-item"><a href="#" class="nav-link active"><i class="fa fa-list"></i>My Rentals</a></li>
                            <li class="nav-item"><a href="{{route('customermodule.reservationTransaction')}}" class="nav-link"><i class="fa fa-heart"></i> My Reservations</a></li>
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
@stop