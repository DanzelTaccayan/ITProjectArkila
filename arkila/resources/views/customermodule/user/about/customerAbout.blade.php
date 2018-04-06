@extends('layouts.customer_user')
@section('content')
<section id="">
            <section class="bar" style="background-color: lightgray;">
               <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="heading">
                            <h2>About Ban Trans</h2>
                        </div>
                        <p class="lead">Ban Trans is a van transport association established in Baguio City in 2006 for UV Express franchisees or operators. It has three terminals located in Baguio City, Cabanatuan City, and San Jose City.</p>
                        <ul>
                            <li>
                                <p class="lead">Operating Hours 4:00 am - 6:00 pm daily</p>
                            </li>
                            <li>
                                <p class="lead">Office Hours 7:00 am - 7:00 pm daily</p>
                            </li>
                        </ul>
                    </div><!-- col-->
                </div>
                <!-- row-->
                </div><!-- container-->
            </section>
            <!-- bar-->
            <section class="bar mt-0" style="background-color: lightgray;">
               <div class="container">
               <div class="row">
                    <div class="col-md-4">
                        <div class="heading">
                            <h2>Our Mission</h2>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore voluptatibus ipsa a sint unde, blanditiis beatae aliquid eveniet maxime in expedita voluptas perspiciatis nulla. Atque optio accusantium, nobis dignissimos tempora.</p>
                    </div>
                    <div class="col-md-4">
                        <div class="heading">
                            <h2>Our services</h2>
                        </div>
                        <ul class="ul-icons list-unstyled">
                            <li>
                                <div class="icon-filled"><i class="fa fa-check"></i></div>Regular trips to Cabanatuan and San Jose including neighboring provinces
                            </li>
                            <li>
                                <div class="icon-filled"><i class="fa fa-check"></i></div>Van Rentals to any destination.
                            </li>
                        </ul>
                    </div><!-- col-->
                    <div class="col-md-4">
                        <div class="heading">
                            <h2>Our Vision</h2>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore voluptatibus ipsa a sint unde, blanditiis beatae aliquid eveniet maxime in expedita voluptas perspiciatis nulla. Atque optio accusantium, nobis dignissimos tempora.</p>
                    </div><!-- col-->
                </div>
                <!-- row-->
                </div><!-- container-->
            </section>
            <!-- bar-->
        <section style="background: url(../img/fixed-background-2.jpg) center top no-repeat; background-size: cover;" class="bar text-center bg-fixed relative-positioned">
            <div class="dark-mask"></div>
            <div class="container">
                <div class="row showcase text-center">
                    <div class="col-md-4 col-sm-6">
                        <div class="item">
                            <div class="icon-outlined icon-sm icon-thin"><i class="fa fa-car"></i></div>
                            <h4><span class="h1 counter">{{$numberOfVans}}</span><br>Vans</h4>
                        </div><!-- item-->
                        </div><!-- col-->
                    <div class="col-md-4 col-sm-6">
                        <div class="item">
                            <div class="icon-outlined icon-sm icon-thin"><i class="fa fa-user"></i></div>
                            <h4><span class="h1 counter">{{$numberOfOperators}}</span><br>Operators</h4>
                        </div><!-- item-->
                        </div><!-- col-->
                    <div class="col-md-4 col-sm-6">
                        <div class="item">
                            <div class="icon-outlined icon-sm icon-thin"><i class="fa fa-users"></i></div>
                            <h4><span class="h1 counter">{{$numberOfDrivers}}</span><br>Drivers</h4>
                        </div><!-- item-->
                        </div><!-- col-->
                </div>
                <!-- row-->
            </div>
            <!-- container-->
        </section>
        <!-- bar-->
        <section class="bar no-mb" style="background-color: lightgray;">
            <div class="container">
                <div class="col-md-12">
                    <div class="heading">
                        <h2>Meet Our Employees</h2>
                    </div>
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div data-animate="fadeInUp" class="team-member">
                                <div class="image"><img src="../img/person-1.jpg" alt="" class="img-fluid rounded-circle"></div>
                                <h3>Juan Reyes</h3>
                                <p class="role">Cashier</p>
                            </div><!-- team-member-->
                        </div><!-- col-->
                        <div class="col-md-3">
                            <div data-animate="fadeInUp" class="team-member">
                                <div class="image"><img src="../img/person-1.jpg" alt="" class="img-fluid rounded-circle"></div>
                                <h3>James Santos</h3>
                                <p class="role">Cashier</p>
                            </div><!-- team-member-->
                        </div><!-- col-->
                        <div class="col-md-3">
                            <div data-animate="fadeInUp" class="team-member">
                                <div class="image"><img src="../img/person-1.jpg" alt="" class="img-fluid rounded-circle"></div>
                                <h3>Jenny Cruz</h3>
                                <p class="role">Cashier</p>
                            </div><!-- team-member-->
                        </div><!-- col-->
                        <div class="col-md-3">
                            <div data-animate="fadeInUp" class="team-member">
                                <div class="image"><img src="url(../img/person-2.jpg)" alt="" class="img-fluid rounded-circle"></div>
                                <h3>Jinky Pascua</h3>
                                <p class="role">Cashier</p>
                            </div><!-- team-member-->
                        </div><!-- col-->
                    </div>
                    <!-- row-->
                </div>
                <!--col -->
            </div>
            <!-- container-->
        </section>
        <!-- bar-->
    </section>
    <!--    main section-->
@stop