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

</style>

@endsection
@section('content')

<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="10000">
  <!-- Wrapper for slides -->
  <div class="carousel-inner">
     @foreach($terminals as $terminal)
    <div class="item @if($terminals->first() == $terminal){{'active'}} @endif" id={{$terminal->destination_id}}> 
            <div class="box box-solid ticket-box">
                <div class="box-header bg-blue bg-gray">
                    <img src="{{ URL::asset('img/bantrans-logo.png') }}" style="width: 75px; height:75px; float: right; margin-right: 2%; margin-top: 1% " alt="User Image">
                    <span >
                        <h2>{{$terminal->destination_name}}</h2>
                        <h4 id="plno{{$terminal->destination_id}}"></h4>
                    </span>
                </div>
                
                <ul class="list-group" id="ticketul{{$terminal->destination_id}}">
                </ul>
                         
            </div>
    </div>
    @endforeach
  </div>
</div>



@endsection
@section('scripts') 
@parent
    <script>
        $(document).ready(function(){
            $.ajax({
                type: 'GET',
                url: '/getVanQueue',
                success: function(response){
                    var counter = 1; 
                    $.each(response.vanqueue, function(i,item){                            
                        $('.item').each(function(i,obj){
                            if(obj.id == item.destination_id){
                                $('#plno'+item.destination_id).append('ON DECK: <strong>'+item.van['plate_number']+'</strong>');
                                $.each(response.tickets, function(i,items){
                                    console.log(i);
                                    $.each(items, function(q,qtems){
                                        //console.log(qtems);
                                        $.each(qtems, function(r,rtems){
                                            //console.log(r);
                                            //console.log(rtems);
                                            if(obj.id == i){
                                                //<li data-val='#' class="list-group-item col-lg-4" ><span class="queueNumber bg-blue">#1</span><h4 class="text-center"><strong>Asigan-1</strong></h4></li>
                                                $('#ticketul'+i).append(
                                                    $('<li>', {class: 'list-group-item col-lg-3'}).append([
                                                        $('<span>', {class: 'queueNumber bg-blue'}).text(counter),
                                                        $('<h4>', {class: 'text-center'}).append(
                                                            $('<strong>').text(rtems)
                                                        )
                                                    ])
                                                );
                                            }
                                            counter++;        
                                        });
                                    });
                                });
                            } 
                        });
                    });
                    
                    //console.log(response.vanqueue);
                    //console.log(response.tickets);
                }    
            });
            //setInterval(function(){
                   
            //}, 2000);
        });
    </script>  
    <script type="text/javascript">
        setTimeout(function(){
           window.location.reload(1);
        }, 40000);
    </script>
@endsection