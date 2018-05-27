@extends('layouts.master') 
@section('title', 'View Driver')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="profile-side">
                            <img class="profile-user-img img-responsive img-circle" src="{{ URL::asset('uploads/profilePictures/'.$generalDriver->profile_picture) }}" alt="Driver profile picture">
                            @if($generalDriver->status === "Active")
                                <div class="profile-btn-group">
                                    <a href="{{route('drivers.edit',[$generalDriver->member_id])}}" class="btn btn-block btn-primary btn-sm"><strong>Update Information</strong></a>
                                </div>
                            @endif
                            <hr>
                            <div class="profile-btn-group">
                               <a href="@if(session()->get('opLink') && session()->get('opLink') == URL::previous())
                                {{session()->get('opLink')}}
                                @else
                                    @if($generalDriver->status === 'Active')
                                        {{route('drivers.index') }}
                                    @else
                                        {{route(URL::previous())}}
                                    @endif
                                @endif" class="btn btn-default btn-sm btn-block"><i class="fa fa-chevron-left"></i> <strong>Back</strong></a>
                            </div>
                            @if($generalDriver->status === "Active")
                                <div class="profile-van" style="margin-top: 10px;">

                                        <div class="info-box">
                                            <span class="info-box-icon bg-red"><i class="fa fa-automobile"></i></span>
                                            <div class="info-box-content">
                                              <h4><strong>{{$generalDriver->van()->first()->plate_number ?? null}}</strong></h4>
                                              <p>{{$generalDriver->van()->first()->model->description ?? null}}</p>
                                              <p style="color: gray;">{{$generalDriver->van()->first()->seating_capacity ?? null}} seats</p>
                                            </div>
                                            <!-- /.info-box-content -->
                                        </div>

                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-9">
                        <h4 class="profile-username"><strong>{{trim(strtoupper($generalDriver->full_name))}}</strong></h4>
                        <div style="margin-bottom: 3%;">
                            <button onclick="window.open('{{route('pdf.perDriver', [$generalDriver->member_id])}}')" class="btn btn-default btn-sm btn-flat pull-right"> <i class="fa fa-print"></i> PRINT INFORMATION</button>
                            <h4>Personal Information</h4>
                        </div>
                        <table class="table table-bordered table-striped info-table">
                            <tr>
                                <th>Contact Number</th>
                                <td>{{$generalDriver->contact_number}}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{$generalDriver->address}}</td>
                            </tr>
                            <tr>
                                <th>Provincial Address</th>
                                <td>{{$generalDriver->provincial_address}}</td>
                            </tr>
                            <tr>
                                <th>Gender</th>
                                <td>{{$generalDriver->gender}}</td>
                            </tr>
                            <tr>
                                <th>SSS No.</th>
                                <td>{{$generalDriver->SSS}}</td>
                            </tr>
                            <tr>
                                <th>License No.</th>
                                <td>{{$generalDriver->license_number}}</td>
                            </tr>
                            <tr>
                                <th>License Expiry Date</th>
                                <td>{{$generalDriver->expiry_date}}</td>
                            </tr>
                        </table>
                        <h4>Contact Person</h4>
                        <table class="table table-bordered table-striped info-table">
                            <tr>
                                <th>Contact Person</th>
                                <td>{{$generalDriver->person_in_case_of_emergency}}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{$generalDriver->emergency_address}}</td>
                            </tr>
                            <tr>
                                <th>Contact Number</th>
                                <td>{{$generalDriver->emergency_contactno}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection