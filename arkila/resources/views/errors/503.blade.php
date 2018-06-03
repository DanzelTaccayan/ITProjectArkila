@extends('layouts.error') 
@section('title', 'Service Unavailable') 
@section('content') 

<div class="error-page">

    <div class="section text-center" style="margin-top:15%">
        <h1 style="font-size:100pt"><i class="fa fa-thumbs-down"></i></h1>
        <h1 class="text-yellow" style="font-size:50pt">This service is unavailable at the moment.</h1>
        <a href="" class="btn btn-default"><i class="fa fa-home"></i> BACK TO HOME</a>

    </div>
    
</div>
<!-- /.error-page -->

@endsection