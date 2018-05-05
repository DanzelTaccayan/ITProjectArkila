@extends('layouts.master') 
@section('title', 'View Driver')
@section('links')
@parent  
<style>
    .info-table th{
        width:150px;
    }
    .profile-btn-group{
        padding-left:  25px;
        padding-right: 25px;
        margin-top: 10px;
    }
    .profile-van{
        padding-left:  25px;
        padding-right: 25px;
    }

    .profile-van p{
        margin: 0;
    }
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="profile-side">
                            <img class="profile-user-img img-responsive img-circle" src="#" alt="Driver profile picture">
                            <div class="profile-btn-group">
                                <a href="#" class="btn btn-block btn-info btn-sm"><strong>Update Information</strong></a>
                            </div>
                            <hr>
                            <div class="profile-van">
                                <div class="info-box">
                                    <span class="info-box-icon bg-navy"><i class="fa fa-automobile"></i></span>
                                    <div class="info-box-content">
                                      <h4><strong>AAA 123</strong></h4>
                                      <p>HI ACE</p>
                                      <p style="color: gray;">16 seats</p>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </div>
                            <div class="profile-btn-group">
                               <a href="@if(session()->get('opLink') && session()->get('opLink') == URL::previous())
                                {{session()->get('opLink')}}
                                @else
                                    @if($driver->status === 'Active')
                                        {{route('drivers.index') }}
                                    @else
                                        {{route(URL::previous())}}
                                    @endif
                                @endif" class="btn btn-primary btn-sm btn-block"><i class="fa fa-chevron-left"></i> <strong>Back</strong></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <h4 class="profile-username"><strong>{{trim(strtoupper($driver->full_name))}}</strong></h4>
                        <div style="margin-bottom: 3%;">
                            <button onclick="window.open('{{route('pdf.perDriver', [$driver->member_id])}}')" class="btn btn-default btn-sm btn-flat pull-right"> <i class="fa fa-print"></i> PRINT INFORMATION</button>
                            <h4>Personal Information</h4>
                        </div>
                        <table class="table table-bordered table-striped info-table">
                            <tr>
                                <th>Contact Number</th>
                                <td>{{$driver->contact_number}}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{$driver->address}}</td>
                            </tr>
                            <tr>
                                <th>Provincial Address</th>
                                <td>{{$driver->provincial_address}}</td>
                            </tr>
                            <tr>
                                <th>Gender</th>
                                <td>{{$driver->gender}}</td>
                            </tr>
                            <tr>
                                <th>SSS No.</th>
                                <td>{{$driver->SSS}}</td>
                            </tr>
                            <tr>
                                <th>License No.</th>
                                <td>{{$driver->license_number}}</td>
                            </tr>
                            <tr>
                                <th>License Expiry Date</th>
                                <td>{{$driver->expiry_date}}</td>
                            </tr>
                        </table>
                        <h4>Contact Person</h4>
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>Contact Person</th>
                                <td>{{$driver->person_in_case_of_emergency}}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{$driver->emergency_address}}</td>
                            </tr>
                            <tr>
                                <th>Contact Number</th>
                                <td>{{$driver->emergency_contactno}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection