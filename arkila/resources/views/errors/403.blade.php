@extends('layouts.error') 
@section('title', 'Error 403') 
@section('content') 

<div class="error-page">

    <div class="section text-center" style="margin-top:14%">       
        <h1 style="font-size:100pt"><i class="fa fa-thumbs-down"></i></h1>
        <h1 class="text-yellow" style="font-size:50pt">You don't have permission to access / on this server</h1>
        <a href="{{redirect()->back()->getTargetUrl()}}" class="btn btn-default"><i class="fa fa-home"></i> BACK TO HOME</a>
    </div>
    <!-- /.error-content -->
</div>

@endsection