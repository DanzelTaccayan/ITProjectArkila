@extends('layouts.ticketQueue')
@section('title', 'Ticket Queue')
@section('links')
@parent
<link rel="stylesheet" href="{{ URL::asset('/jquery/bootstrap3-editable/css/bootstrap-editable.css') }}">

<style>
    .ticket-box{
    
    }
    .dual-list .list-group {
        margin-top: 8px;
    } 

    .queueNumber{
        border-top-left-radius: 2px;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 2px;
        display: block;
        float: left;
        height: 45px;
        width: 60px;
        text-align: center;
        font-size: 30px;
        background: rgba(0,0,0,0.2);
    }

    li {
        margin: .5% 0%;
    }

    .box-body {
        height: 605px;
    }

</style>

@endsection
@section('content')
     
<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">

        <div class="dual-list list-right">
            <div class="box box-solid ticket-box">
                <div class="box-header bg-blue bg-gray">
                    <img src="{{ URL::asset('img/bantrans-logo.png') }}" style="width: 75px; height:75px; float: right; margin-right: 2%; margin-top: 1% " alt="User Image">
                    <span >
                        <h2>CABANATUAN CITY</h2>
                        <h4>ON DECK: <strong>AAA-111</strong></h4>
                    </span>
                </div>
                <div class="box-body well">
                    <ul class="list-group">
                        <li data-val='#' class="list-group-item col-lg-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center">CABANTUAN-A</h4></li>
                        <li data-val='#' class="list-group-item col-lg-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center">CABANTUAN-A</h4></li>
                        <li data-val='#' class="list-group-item col-md-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center">CABANTUAN-A</h4></li>
                        <li data-val='#' class="list-group-item col-md-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center">CABANTUAN-A</h4></li>
                        <li data-val='#' class="list-group-item col-md-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center">CABANTUAN-A</h4></li>
                        <li data-val='#' class="list-group-item col-md-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center">CABANTUAN-A</h4></li>
                        <li data-val='#' class="list-group-item col-md-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center">CABANTUAN-A</h4></li>
                        <li data-val='#' class="list-group-item col-md-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center">CABANTUAN-A</h4></li>

                    </ul>

                </div>
            </div>
        </div>

    <div class="carousel-item">
        
    </div>
    <div class="carousel-item">
    
    </div>
  </div>
</div>

@endsection
@section('scripts') 
@parent
<script>
    $('.carousel').carousel({
      interval: 2000
    });
</script>
@endsection