@extends('layouts.master')
@section('title', 'Company Profile')
@section('links')
@parent
<style>
th {
    text-align:center;
    width:25%;
}
</style>
@endsection
@section('content')

<div class="padding-side-15">
    <div>
        <h2 class="text-white">COMPANY PROFILE</h2>
    </div>  
	<div class="box box-solid" style="height: ;">
        <div class="box-body">
            <div class="row">

                <div class="col-md-3">
                    <img class="profile-user-img img-responsive img-circle" src="{{ URL::asset('img/bantrans-logo.png') }}" alt="profile picture">
                    <h3 class="text-center">{{$main->destination_name}}</h3>
                    <p class="text-center" style="margin-bottom: 20px">Main Terminal</p>
                </div>
                <div class="col-md-9">
                    <div>   
                        <h4>CONTACT DETAILS</h4>  
                        <table class="table table-bordered table-striped">  
                            <tbody> 
                                <tr>
                                    <th>Address</th>
                                    <td>{{$profile->address}}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{$profile->email}}</td>
                                </tr>
                                <tr>
                                    <th>Phone No.</th>
                                    <td>{{$profile->contact_number}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="pull-right">   
                            <a href="{{route('company-profile.edit', $profile->id)}}" type="button" class="btn btn-sm btn-flat btn-primary"><i class="fa fa-edit"> </i> EDIT</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <hr>
                    <div>   
                        <h4>MAIN TERMINAL FEES</h4>
                        <table class="table table-bordered table-striped">  
                            <tbody> 
                                @foreach($fees as $fee)
                                <tr>
                                    <th>{{$fee->description}}</th>
                                    <td>{{$fee->amount}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <a href="{{route('settings.index')}}" type="button" class="btn btn-sm pull-right btn-flat btn-primary"><i class="fa fa-gears"> </i> GO TO FEES</a>
                    </div>
            {{-- @foreach ($profiles as $profile)
                
                <div class="form-group">
                    <label>Contact Number:</label>
                    <input type="text" name="contactNumber" class="form-control" value="{{$profile->contact_number}}" disabled>
                </div>

                <div class="form-group">
                    <label>Address:</label>
                    <input type="text" class="form-control" value="{{$profile->address}}" disabled>
                </div>
                <div class="form-group">
                    <label>Email :</label>
                    <input type="text" class="form-control" value="{{$profile->email}}" disabled>
                </div>
            </div>

            <div class="col-md-6">
                <a href="{{route('profile.edit',[$profile->id])}}" class="btn btn-outline-secondary btn-sm"><i class="fa fa-pencil-square-o"></i> Edit</a>
            </div>
            <div class="col-md-6">
            @endforeach
            <a href="{{route('accountSettings')}}" class="btn btn-outline-primary btn-sm"><i class="fa fa-pencil-square-o"></i> Change Password</a>
            </div> --}}
        </div> 
    </div>
</div>
@endsection


