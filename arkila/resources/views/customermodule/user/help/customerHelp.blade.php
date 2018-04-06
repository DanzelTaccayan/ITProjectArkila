@extends('layouts.customer_user')
@section('content')
<section id="mainSection" style="background-image: url('{{ URL::asset('img/customer_background.jpg') }}'); height: 100%;
    background-size: cover;">
        <div class="col-md-8 mx-auto">
            <div class="heading text-center">
                <h2>FAQ's</h2>
            </div>
            <div class="card card-primary">
                <div class="card-header">
                    <h5>1. How to rent a van?</h5>
                </div>
                <div class="card-body">
                    <ul>
                        <li><strong>Step 1:</strong> Go to the Services tab on the Menu</li>
                        <li><strong>Step 2:</strong> Select the Rentals tab</li>
                        <li><strong>Step 3:</strong> Fill out the necessary information in the form</li>
                        <li><strong>Step 4:</strong> Click on the book button</li>
                        <li><strong>Step 5:</strong> A pop up will confirm that you have successfully rented a van</li>
                    </ul>
                </div>
                <!-- card-body-->
            </div>
            <!-- card-->
            <div class="card card-primary">
                <div class="card-header">
                    <h5>2. How to Reserve a Trip?</h5>
                </div>
                <div class="card-body">
                    <ul>
                        <li><strong>Step 1:</strong> Go to the Services tab on the Menu</li>
                        <li><strong>Step 2:</strong> Select the Reservations tab</li>
                        <li><strong>Step 3:</strong> Fill out the necessary information in the form</li>
                        <li><strong>Step 4:</strong> Click on the book button</li>
                        <li><strong>Step 5:</strong> A pop up will confirm that you have successfully booked a trip</li>
                    </ul>
                </div>
                <!-- card-body-->
            </div>
            <!-- card-->
            <div class="card card-primary">
                <div class="card-header">
                    <h5>3. How to view your reservations/rentals?</h5>
                </div>
                <div class="card-body">
                    <ul>
                        <li><strong>Step 1:</strong> Go to the My Transactions tab on the Menu</li>
                        <li><strong>Step 2:</strong> Select either the Rentals or Reservations tab</li>
                        <li><strong>Step 3:</strong> You may view your current transactions and or delete them if desired</li>
                    </ul>
                </div>
                <!-- card-body-->
            </div>
            <!-- card-->
        </div>
        <!-- col-->
    </section>
    <!--    main section-->
@stop