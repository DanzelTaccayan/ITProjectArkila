@extends('layouts.driver') 
@section('title', 'Driver Help') 
@section('content-title', 'Driver Help')
@section('content')
<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <div class="box box-solid">
            <div class="box-header  with-border">
                <h5 class="text-center"><strong>View Announcements and Van's Queue Number</strong></h5>
            </div>
            <div class="box-body">
                <ul>
                    <li>
                        <strong>Step 1:</strong> Go to the "Home" tab on the navigation bar.
                    </li>
                    <li>
                        <strong>Step 2:</strong> View announcements in the "Announcements" tab.
                    </li>
                    <li>
                        <strong>Step 3:</strong> View van's queue number in the "On Queue" tab.
                    </li>
                </ul>
            </div>
            <!-- box-body-->
        </div>
        <!-- box-->
        <div class="box box-solid">
            <div class="box-header  with-border">
                <h5 class="text-center"><strong>View Trip Log</strong></h5>
            </div>
            <div class="box-body">
                <ul>
                    <li>
                        <strong>Step 1:</strong> Go to the "Trip Log" tab on the navigation bar.
                    </li>
                    <li>
                        <strong>Step 2:</strong> View pending, accepted and declined trips in the trips table
                    </li>
                </ul>
            </div>
            <!-- box-body-->
        </div>
        <!-- box-->
        <div class="box box-solid">
            <div class="box-header  with-border">
                <h5 class="text-center"><strong>Create Report</strong></h5>
            </div>
            <div class="box-body">
                <ul>
                    <li>
                        <strong>Step 1:</strong> Go to the "Create Report" tab on the navigation bar.
                    </li>
                    <li>
                        <strong>Step 2:</strong>Under the "Departure Details" tab, choose which origin terminal and the departure date and time.
                    </li>
                    <li>
                        <strong>Step 3:</strong> Under the "Passenger Count" tab, enter the number of regular or discounted tickets that came from the main terminal or short trip.
                    </li>
                    <li>
                        <strong>Step 4:</strong> After entering the information of the report, click the "Submit" button to create the report.
                    </li>
                    <li>
                        <strong>Step 5:</strong> The departure details, shares and passenger count will be shown after clicking the submit button.
                    </li>
                </ul>
            </div>
            <!-- box-body-->
        </div>
        <!-- box-->
        <div class="box box-solid">
            <div class="box-header with-border">
                <h5 class="text-center"><strong>Profile</strong></h5>
            </div>
            <div class="box-body">
                <ul>
                    <li>
                        <strong>Step 1:</strong> On the top right side of the page, click the name of the driver and you will be redirected to the profile page.
                    </li>
                    <li>
                        <strong>Step 2:</strong> Under the profile page, you can see your personal information and you can change your password by click the "Account Settings" button.
                    </li>
                </ul>
            </div>
            <!-- box-body-->
        </div>
        <!-- box-->
    </div>
    <!-- col-->
</div>
<!-- row-->
@endsection 
