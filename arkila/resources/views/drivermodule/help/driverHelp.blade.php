@extends('layouts.driver') 
@section('title', 'Driver Help') 
@section('content-title', 'Driver Help')
@section('content')
<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <div class="box box-solid">
            <div class="box-header  with-border">
                <h5 class="text-center"><strong>View Announcements and Van Queue</strong></h5>
            </div>
            <div class="box-body">
                <ul>
                    <li>
                        <strong>Step 1:</strong> Go to the Home tab on the Menu
                    </li>
                    <li>
                        <strong>Step 2:</strong> View announcements in the announcements column
                    </li>
                    <li>
                        <strong>Step 3:</strong> View van queue in the van queue column
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
                        <strong>Step 1:</strong> Go to the Trip Log tab on the Menu
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
                        <strong>Step 1:</strong> Go to the Create Report tab on the Menu
                    </li>
                    <li>
                        <strong>Step 2:</strong> Choose which terminal you want to create a report for and click on the select terminal button which will redirect you to the report page
                    </li>
                    <li>
                        <strong>Step 3:</strong> Under the report page, Enter the number of passengers per destination, Date of departure and the time of departure
                    </li>
                    <li>
                        <strong>Step 4:</strong> You will then be shown your total number of passengers and the total booking fee for the said trip
                    </li>
                    <li>
                        <strong>Step 5:</strong> Click on the submit button to turn the report in to the admin
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
                        <strong>Step 1:</strong> Go to the Profile tab on the Menu
                    </li>
                    <li>
                        <strong>Step 2:</strong> Under the profile tab, you can enable or disable notifications, change your password and view your personal information
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
