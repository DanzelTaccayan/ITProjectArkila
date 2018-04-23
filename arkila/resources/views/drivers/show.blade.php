@extends('layouts.master') 
@section('title', 'View Driver')
@section('content')

<div class="box box-default with-shadow">
    <div class="box-header with-border text-center">
        <h4>
            <a href="@if(session()->get('opLink') && session()->get('opLink') == URL::previous())
            {{session()->get('opLink')}}
            @else
                @if($driver->status === 'Active')
                    {{route('drivers.index') }}
                @else
                    {{route(URL::previous())}}
                @endif
            @endif" class="pull-left"><i class="fa fa-chevron-left"></i></a>
        </h4>
        <h3 class="box-title">
            View Driver Information
        </h3>
    </div>
    <div class="box-body">
        <h3><i class="fa fa-user"></i> {{$driver->last_name}}, {{$driver->first_name}} {{$driver->middle_name}}
        </h3>
        <hr>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="contactNumberD">Contact Number:</label>
                    <p id="contactNumberD" name="contactNumberD" type="text" class="info-container">{{$driver->contact_number}}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="addressD">Address:</label>
                    <p id="addressD" name="addressD" type="text" class="info-container">{{$driver->address}}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="provincialAddressD">Provincial Address:</label>
                    <p id="provincialAddressD" name="provincialAddressD" type="text" class="info-container">{{$driver->provincial_address}}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="genderD">Gender:</label>
                    <p id="genderD" name="genderD" type="text" class="info-container">{{$driver->gender}}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="sssD">SSS No:</label>
                    <p id="sssD" name="sssD" type="text" class="info-container">{{$driver->SSS}}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="licenseNoD">License No:</label>
                    <p id="licenseNoD" name="licenseNoD" type="text" class="info-container" >{{$driver->license_number}}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="licenseExpiryDateD">License Expiry Date:</label>
                    <p id="licenseExpiryDateD" name="licenseExpiryDateD" type="text" class="info-container">{{$driver->expiry_date}}</p>
                </div>
            </div>
        </div>
        <hr>    
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="contactPersonD">Contact Person</label>
                    <p id="contactPersonD" name="contactPersonD" type="text" class="info-container">{{$driver->person_in_case_of_emergency}}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="addressD">Address</label>
                    <p id="addressD" name="addressD" type="text" class="info-container">{{$driver->emergency_address}}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="contactNumberD">Contact Number</label>
                    <p id="contactNumberD" name="contactNumberD" type="text" class="info-container">{{$driver->emergency_contactno}}</p>
                </div>
            </div>
        </div>
        <div>
            <button onclick="window.open('{{route('pdf.perDriver', [$driver->member_id])}}')" class="btn btn-default btn-sm btn-flat pull-right"> <i class="fa fa-print"></i> PRINT</button>   
        </div>
    </div>
</div>
@endsection