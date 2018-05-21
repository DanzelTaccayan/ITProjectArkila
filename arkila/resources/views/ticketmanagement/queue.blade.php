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
        height: 480px;
    }

</style>

@endsection
@section('content')

<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="20000">
  <!-- Wrapper for slides -->
  <div class="carousel-inner">
    <div class="item active">
        
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
                        <li data-val='#' class="list-group-item col-lg-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center"><strong>CABANTUAN-A</strong></h4></li>
                        
                        <li data-val='#' class="list-group-item col-lg-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center"><strong>CABANTUAN-A</strong></h4></li>
                        
                        <li data-val='#' class="list-group-item col-lg-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center"><strong>CABANTUAN-A</strong></h4></li>
                        
                        <li data-val='#' class="list-group-item col-lg-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center"><strong>CABANTUAN-A</strong></h4></li>
                        
                        <li data-val='#' class="list-group-item col-lg-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center"><strong>CABANTUAN-A</strong></h4></li>
                        
                        <li data-val='#' class="list-group-item col-lg-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center"><strong>CABANTUAN-A</strong></h4></li>
                        
                        <li data-val='#' class="list-group-item col-lg-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center"><strong>CABANTUAN-A</strong></h4></li>
                        
                        <li data-val='#' class="list-group-item col-lg-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center"><strong>CABANTUAN-A</strong></h4></li>
                        
                        <li data-val='#' class="list-group-item col-lg-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center"><strong>CABANTUAN-A</strong></h4></li>
                        
                        <li data-val='#' class="list-group-item col-lg-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center"><strong>CABANTUAN-A</strong></h4></li>
                        
                        <li data-val='#' class="list-group-item col-lg-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center"><strong>CABANTUAN-A</strong></h4></li>
                        
                        <li data-val='#' class="list-group-item col-lg-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center"><strong>CABANTUAN-A</strong></h4></li>
                        
                        <li data-val='#' class="list-group-item col-lg-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center"><strong>CABANTUAN-A</strong></h4></li>
                        
                        <li data-val='#' class="list-group-item col-lg-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center"><strong>CABANTUAN-A</strong></h4></li>
                        
                        <li data-val='#' class="list-group-item col-lg-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center"><strong>CABANTUAN-A</strong></h4></li>

                        <li data-val='#' class="list-group-item col-lg-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center"><strong>CABANTUAN-A</strong></h4></li>
                        
                        <li data-val='#' class="list-group-item col-lg-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center"><strong>CABANTUAN-A</strong></h4></li>
                        
                        <li data-val='#' class="list-group-item col-lg-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center"><strong>CABANTUAN-A</strong></h4></li>
                        
                        

                    </ul>

                </div>
            </div>
    </div>

    <div class="item">
      
            <div class="box box-solid ticket-box">
                <div class="box-header bg-blue bg-gray">
                    <img src="{{ URL::asset('img/bantrans-logo.png') }}" style="width: 75px; height:75px; float: right; margin-right: 2%; margin-top: 1% " alt="User Image">
                    <span >
                        <h2>SAN JOSE CITY</h2>
                        <h4>ON DECK: <strong>BBB-3213</strong></h4>
                    </span>
                </div>
                <div class="box-body well">
                    <ul class="list-group">
                        <li data-val='#' class="list-group-item col-lg-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center"><strong>Asigan-1</strong></h4></li>
                        <li data-val='#' class="list-group-item col-lg-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center"><strong>Asigan-1</strong></h4></li>

                        
                        <li data-val='#' class="list-group-item col-lg-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center"><strong>Asigan-1</strong></h4></li>

                        
                        <li data-val='#' class="list-group-item col-lg-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center"><strong>Asigan-1</strong></h4></li>

                        
                        <li data-val='#' class="list-group-item col-lg-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center"><strong>Asigan-1</strong></h4></li>

                        
                        <li data-val='#' class="list-group-item col-lg-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center"><strong>Asigan-1</strong></h4></li>

                        
                        <li data-val='#' class="list-group-item col-lg-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center"><strong>Asigan-1</strong></h4></li>

                        
                        
                        
                        

                    </ul>

                </div>
            </div>
    </div>
  </div>
</div>



@endsection
@section('scripts') 
@parent

@endsection