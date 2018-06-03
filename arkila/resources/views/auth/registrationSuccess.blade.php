@extends('layouts.customer_non_user')
@section('content')
<div class="content">
    <div class="container" style="height: 500px;">
        <div class="col-md-8 mx-auto text-center">
            <div class="boxContainer" style="padding: 10px; margin-top:10%;">
                <h2><i class="fa fa-check-circle" style="font-size: 100px; color: #4bca4b;"></i></h2>
                <h3 class="text-center">Registered Successfully!</h3>
                @if(session('registrationsuccess'))
                  <p>{{session('registrationsuccess')}}</p>
                @endif
                <a href="{{route('customer.non-user.index')}}" class="btn btn-template-outlined"><i class="fa fa-chevron-left"> Back to home</i></a>
            </div>
        </div>
    </div>
</div>
@stop
