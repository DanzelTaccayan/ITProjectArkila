@extends('layouts.customer_user')
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
                                    <h1>Need a Seat Reservation for a Trip?</h1>
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
        <!-- section-->
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
    <section style="background: url('{{ URL::asset('img/fixed-background-2.jpg') }}') center top no-repeat; background-size: cover;" class="bar text-center bg-fixed relative-positioned">
        <div class="dark-mask"></div>
        <div class="container">
            <div class="col-md-8 mx-auto"> 
                <div class="heading text-center" style="color:white;">
                    <h2><i class="fa fa-bullhorn"></i> Announcements</h2>
                </div>
                <div id="announcements" class="container">
                </div>
            </div>                  
        </div>    
    </section>
    <!-- section-->
    <section style="background: url('{{ URL::asset('img/bron_gradient.jpg') }}') center top no-repeat; background-size: cover;" class="bar text-center ">
        <div class="dark-mask"></div>
        <div class="container">
            <div class="heading text-center">
                <h2><i class="fa fa-bolt"></i> Weather Updates</h2>
            </div>
            <div class="row">
                <div class="col-lg-4 text-center" style="padding-top:5px;">
                    <!-- Baguio Weather Widget-->
                    <!-- weather widget start --><a target="_blank" href="http://www.booked.net/weather/baguio-city-12231"><img src="https://w.bookcdn.com/weather/picture/28_12231_1_1_e67e22_250_d35401_ffffff_ffffff_1_2071c9_ffffff_0_6.png?scode=124&domid=w209&anc_id=37033" alt="booked.net"/></a>
                    <!-- weather widget end -->
                </div>
                <div class="col-lg-4 text-center" style="padding-top:5px;">
                    <!-- San Jose Weather Widget-->
                    <!-- weather widget start --><a target="_blank" href="http://www.booked.net/weather/munoz-w434073"><img src="https://w.bookcdn.com/weather/picture/28_w434073_1_1_e67e22_250_d35401_ffffff_ffffff_1_2071c9_ffffff_0_6.png?scode=124&domid=w209&anc_id=46479" alt="booked.net"/></a>
                    <!-- weather widget end -->
                </div>
                <div class="col-lg-4 text-center" style="padding-top:5px;">
                    <!-- Cabanatuan Weather Widget-->
                    <!-- weather widget start --><a target="_blank" href="http://www.booked.net/weather/cabanatuan-city-33111"><img src="https://w.bookcdn.com/weather/picture/28_33111_1_1_e67e22_250_d35401_ffffff_ffffff_1_2071c9_ffffff_0_6.png?scode=124&domid=w209&anc_id=68269" alt="booked.net"/></a>
                    <!-- weather widget end -->
                </div>
            </div>
        </div>
        <!-- container-->
    </section>
    <!-- section-->
    

@endsection
@section('scripts')
@parent
<script>
var myDiv = $('#announcementsLimit');
myDiv.text(myDiv.text().substring(0,250) + '...')
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $("#announcements").load("{{route('customermodule.user.indexAnnouncements')}}");
        
    });
</script>

@endsection
  
