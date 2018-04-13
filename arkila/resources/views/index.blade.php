@extends('layouts.customer_non_user')
@section('content')
<section style="background: url('{{ URL::asset('img/photogrid.jpg') }}') center center repeat; background-size: cover;" class="bar background-white relative-positioned">
        <div class="container">
            <!-- Carousel Start-->
            <div class="home-carousel">
                <div class="dark-mask mask-primary"></div>
                <div class="container">
                    <div class="homepage owl-carousel">
                        <div class="item">
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <h1>3 Branches to serve you!</h1>
                                    <p>Baguio. Cabanatuan. San Jose.</p>
                                </div>
                                <div class="col-md-7"><img src="{{ URL::asset('img/template-homepage.png') }}" alt="" class="img-fluid">
                                </div>
                                <!-- col-->
                            </div>
                            <!-- row-->
                        </div>
                        <!-- item-->
                        <div class="item">
                            <div class="row">
                                <div class="col-md-7 text-center"><img src="../img/template-mac.png" alt="" class="img-fluid"></div>
                                <div class="col-md-5">
                                    <h2>Baguio Terminal Operating Hours</h2>
                                    <ul class="list-unstyled">
                                        <li>Operating Hours 4:00 am - 6:00 pm daily</li>
                                        <li>Office Hours 7:00 am - 7:00 pm daily</li>
                                    </ul>
                                </div>
                                <!-- col-->
                            </div>
                            <!-- row-->
                        </div>
                        <!-- item-->
                        <div class="item">
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <h1>Need a Van Rental for a special occasion?</h1>
                                    <p>Ban Trans is here for you!</p>
                                </div>
                                <div class="col-md-7"><img src="../img/template-easy-customize.png" alt="" class="img-fluid"></div>
                                <!-- col-->
                            </div>
                            <!-- row-->
                        </div>
                        <!-- item-->
                        <div class="item">
                            <div class="row">
                                <div class="col-md-7"><img src="../img/template-easy-code.png" alt="" class="img-fluid"></div>
                                <div class="col-md-5">
                                    <h1>Need a Reservation for a Trip?</h1>
                                    <p>We got you!</p>
                                </div>
                                <!-- col-->
                            </div>
                            <!-- row-->
                        </div>
                        <!-- item-->
                    </div>
                    <!-- homepage-->
                </div>
                <!-- container-->
            </div>
            <!-- Carousel End-->
        </div>
        <!-- container-->
    </section>
    <!-- section-->
      <section class="bar bg-gray no-mb padding-big text-md-center" id="rentals">
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <h2 class="text-uppercase">Rentals</h2>
              <p class="mb-small">We offer van rentals to any destination of your choice. We have a variety of van models to choose from! <strong>Rent now, pay later! (one day validation)</strong></p>
              <p><a href="{{route('customermodule.user.rental.customerRental')}}" class="btn btn-template-main">Rent Now</a></p>
            </div>
            <div class="col-md-6 text-center"><img src="img/template-easy-customize.png" alt="" class="img-fluid"></div>
          </div>
        </div>
      </section>
      <section class="bar no-mb color-white padding-big text-md-center bg-primary" id="reservations">
        <div class="container">
          <div class="row">
            <div class="col-md-6 text-center"><img src="img/template-easy-code.png" alt="" class="img-fluid"></div>
            <div class="col-md-6">
              <h2 class="text-uppercase">Reservations</h2>
              <p class="mb-small">Get a privilege to be in our priority lane. Reserve a slot to one of our numerous destinations <strong>Reserve now, pay later! (one day validation)</strong></p>
              <p><a href="{{route('customermodule.user.reservation.customerReservation')}}" class="btn btn-template-outlined-white">Reserve Now</a></p>
            </div>
          </div>
        </div>
      </section>
@stop
@section('scripts')
@parent

@endsection