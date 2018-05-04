@extends('layouts.master')

@section('title','Van Queue')

@section('links')
  @parent
  <link rel="stylesheet" href="{{ URL::asset('/jquery/bootstrap3-editable/css/bootstrap-editable.css') }}">

    <style>
    
    body.dragging, body.dragging * {
  cursor: move !important;
}
.terminal-side{
    height: 610px;
    padding: 10px;
    background: white;
    border-radius: 5px
}
.dragged {
  position: absolute;
  opacity: 0.5;
  z-index: 2000;
}

ol.vertical{
  margin: 0 0 9px 0;
  min-height: 10px;
}
  ol.vertical li{
    display: block;
    color: $linkColor;
    background: $grayLighter;
  }


  ol.vertical li.placeholder{
    position: relative;
    margin: 0;
    padding: 0;
    border: none;
  }
  ol.vertical li.placeholder:before{
      position: absolute;
      content: "";
      width: 0;
      height: 0;
      margin-top: -5px;
      right: -8px;
      top: -4px;
      border: 8px solid transparent;
      border-right-color: black;
      border-left: none;
    }



    ol {
     /* Initiate a counter */
    list-style: none; /* Remove default numbering */
    *list-style: decimal; /* Keep using default numbering for IE6/7 */
    font: 15px 'trebuchet MS', 'lucida sans';
    padding: 0;
    margin-bottom: 4em;
    text-shadow: 0 1px 0 rgba(255,255,255,.5);
    }

    ol ol {
        margin: 0 0 0 2em; /* Add some left margin for inner lists */
    }

.rectangle-list{
  padding-left: 10px;
  padding-right: 10px;
}
   .rectangle-list span{
    position: relative;
    display: block;
    padding: .4em .4em .4em .8em;
    *padding: .4em;
    margin: .5em 0 .5em 2.5em;
    text-decoration: none;
    transition: all .3s ease-out; 
    background: white;  
}

.rectangle-list span:hover{
}   

.queuenum p{
    counter-increment: li;
    position: absolute; 
    left: -2.5em;
    top: 50%;
    margin-top: -1em;
    height: 2em;
    width: 2em;
    line-height: 2em;
    text-align: center;
    font-weight: bold;
    color: black;
    background-color: #fa8072;
}

.queuenum a:hover{
  background: #eb6b5c;
  transition: all .3s ease-out;

}
.queuenum a:afters{
  position: absolute; 
    content: '';
    border: .5em solid transparent;
    left: -1em;
    top: 50%;
    margin-top: -.5em;
    transition: all .3s ease-out;

}
.queue-item:hover{
    left: -.5em;    
    border-left-color: #fa8072;    
    cursor: move;

}

.special-list{
  padding-left: 10px;
  padding-right: 10px;
}

.special-list span {
    position: relative;
    display: block;
    padding: .4em .4em .4em .8em;
    margin: .5em 0 0 0;
    text-decoration: none;
    transition: all .3s ease-out;
    background: white;
}

.list-border{
    border: 1px solid #8f8685;
    border-left-width: 4px;
    background: #feb0a721;
}

.queue-heading{
  color: white;
  background: #7d66ad;
  margin-bottom: 10px;
  padding: 8px;
  text-align: center;
}
.special-unit-heading{
  color: white;
  background: #f39e2f;
  padding: 8px;
  text-align: center;
}
.terminal-heading{
  color: white;
  background: #fc7070;
  padding: 8px;
  text-align: center;
}
.queue-body{
  margin-top:10px;
  height: 450px;
  background: aliceblue;
}
.special-unit-body{
  height: 510px;
  background: bisque;
}
.terminal-body{
  height: 200px;
}
.form-horizontal .editable{
  padding: 0;
}



  </style>
@endsection

@section('content-header','Van Queue')

@section('content')
<div class="box box-solid">
  <div class="box-body" style="background: #ebbea86e;">  
    <div class="row">
      <div class="col-md-12">
        <!-- Van Queue Box -->
          {{-- <div class="box-header  bg-blue">
            <h3 class="box-title">Queue</h3>
          </div> --}}
            <div class="row">
              <div class="col-md-3">  
                <div class="box box-solid">
                  <div class="box-body">
                    <div class="well">
                      <div class="form-group">  
                        <label for="">Van Unit</label>
                        <select @if($vans->first() == null | $terminals->first() ==null | $drivers ->first() ==null) {{'disabled'}} @endif name="van" id="van" class="form-control select2">
                            @if($vans->first() != null)
                                @foreach ($vans as $van)
                                  <option value="{{$van->van_id}}">{{ $van->plate_number }}</option>
                                @endforeach
                            @else
                                <option> No Available Van Units</option>
                            @endif
                         </select>
                      </div>
                      <div class="form-group">
                        <label for="">Destination</label>
                        <select @if($vans->first() == null | $terminals->first() ==null | $drivers ->first() ==null) {{'disabled'}} @endif name="destination" id="destination" class="form-control select2">
                            @if($terminals->first() != null)
                              @foreach ($terminals as $terminal)
                                  <option value="{{$terminal->destination_id}}">{{ $terminal->destination_name }}</option>
                              @endforeach
                            @else
                                <option> No Available Destination</option>
                            @endif

                        </select>
                      </div>
                      <div class="form-group">
                        <label for="">Driver</label>
                        <select @if($vans->first() == null | $terminals->first() ==null | $drivers ->first() ==null) {{'disabled'}} @endif name="driver" id="driver" class="form-control select2">
                            @if($drivers->first() != null)
                                @foreach ($drivers as $driver)
                                    <option value="{{$driver->member_id}}">{{ $driver->full_name }}</option>
                                @endforeach
                            @else
                                <option> No Available Driver</option>
                            @endif
                        </select>
                      </div>
                      @if($vans->first() != null && $terminals->first() !=null && $drivers ->first() !=null)
                          <div class="">
                              <div class="pull-right">
                                  <button id="addQueueButt" class="btn btn-success btn-flat btn-sm"><i class="fa fa-plus"></i> ADD TO QUEUE</button>
                              </div>
                          </div>
                          @else
                          <div class="">
                              <div class="pull-right">
                                  <button  data-toggle="tooltip" class="btn btn-success btn-sm" title="Please add vans, destinations, or drivers before adding a van to the queue" disabled><i class="fa fa-plus"></i> ADD TO QUEUE</button>
                              </div>
                          </div>
                      @endif
                      <div class="clearfix">  </div>
                    </div>
                    <div class="">
                      <div class="terminal-heading">
                      <h4><i class="fa fa-map-marker"></i> TERMINAL</h4>
                      </div>
                      <div class="well terminal-body scrollbar scrollbar-info thin">
                        <ul id="destinationTerminals" class="nav nav-stacked">
                          @foreach ($terminals as $terminal)
                          <li class=" @if($terminals->first() == $terminal){{'active'}} @else {{''}}@endif" data-val="{{$terminal->destination_id}}"><a href="#{{$terminal->destination_id}}" data-toggle="tab">{{$terminal->destination_name}}</a></li>
                          @endforeach
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class= "col-md-9">
                <div class="tab-content">
                <!-- Cabanatuan Queue Tab -->
                @foreach($terminals as $terminal)
                  <div data-val='{{$terminal->destination_id}}' class="tab-pane @if($terminals->first() == $terminal) {{'active'}} @else {{''}} @endif" id="{{$terminal->destination_id}}">
                    <div class="box box-solid">
                      <div class="box-body">
                        <div class="row">
                          <div id="van-queue" class="col-md-7">  
                            <div class="queue-heading">
                              <h4>{{$terminal->destination_name}}</h4>
                            </div>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-search"></i></span>
                              <input type="text" id="queueSearch{{$terminal->destination_id}}" class="form-control" placeholder="Search in queue" onkeyup="search{{$terminal->destination_id}}()">
                            </div>
                            <div class="queue-body scrollbar scrollbar-info thin">  
                              <ol id ="queue-list{{$terminal->destination_id}}" class="rectangle-list serialization">
                                  @foreach ($queue->where('destination_id',$terminal->destination_id) as $vanOnQueue)
                                    <li id="unit{{$vanOnQueue->van_queue_id}}" class="queue-item form-horizontal">
                                      <span id="trip{{$vanOnQueue->van_queue_id}}" class="list-border">
                                        <div class="queuenum">
                                            <p name="queueIndicator" id="queue{{$vanOnQueue->van_queue_id}}">{{ $vanOnQueue->queue_number }}</p>
                                        </div>
                                        <div class=item id="item{{$vanOnQueue->van_queue_id}}">
                                          <div  class="row">
                                            <div class="col-md-12">
                                              <p class="hidden">{{ $vanOnQueue->van->plate_number }}</p>
                                              {{ $vanOnQueue->van->plate_number }}
                                              <div class="pull-right">
                                                  <i id="badge{{$vanOnQueue->van_queue_id}}" class="badge badge-pill badge-default">{{ $vanOnQueue->remarks }}</i>
                                                  <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" style="border-radius: 100%">
                                                    <i class="fa fa-gear"></i>
                                                  </button>
                                                  <div class="dropdown-menu" role="menu">
                                                    <a id="remarkBtn{{$vanOnQueue->van_queue_id}}" class="btn btn-menu btn-sm btn-flat btn-block"><i class="glyphicon glyphicon-asterisk"></i> Update Remark</a>
                                                    <a id="posBtn{{$vanOnQueue->van_queue_id}}" class="btn btn-menu btn-sm btn-flat btn-block"><i class="glyphicon glyphicon-move"></i> Change Position</a>
                                                    <a id="destBtn{{$vanOnQueue->van_queue_id}}" class="btn btn-menu btn-sm btn-flat btn-block"><i class="glyphicon glyphicon-map-marker"></i> Change Destination</a>
                                                    <a name="moveToSpecialUnitsList" data-val="{{$vanOnQueue->van_queue_id}}" class="btn btn-menu btn-sm btn-flat btn-block"><i class="glyphicon glyphicon-star"></i> Move to Special Units</a>
                                                    <a id="deleteBtn{{$vanOnQueue->van_queue_id}}" class="btn btn-menu btn-sm btn-flat btn-block"><i class="glyphicon glyphicon-trash"></i> Remove</a>
                                                  </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div id="remarkitem{{$vanOnQueue->van_queue_id}}" class="hidden">
                                          <div class="form-group">
                                            <label for="" class="col-sm-2 control-label">Remark:</label>
                                             <div class="col-sm-3">
                                              <select name="remark" id="remark{{$vanOnQueue->van_queue_id}}" class="form-control">
                                                <option value="CC">CC</option>
                                                <option value="ER">ER</option>
                                                <option value="OB">OB</option>
                                              </select>
                                             </div>
                                           </div>
                                           <div class="pull-right"> 
                                              <button class="btn btn-default btn-sm itemBtn{{$vanOnQueue->van_queue_id}}">CANCEL</button>
                                              <button name="updateRemarksButton" data-val="{{$vanOnQueue->van_queue_id}}" class="btn btn-primary btn-sm">UPDATE</button>
                                             </div>
                                             <div class="clearfix"> </div>
                                        </div>
                                        <div id="positem{{$vanOnQueue->van_queue_id}}" class="hidden">
                                          <div class="form-group">
                                            <label for="" class="col-sm-2 control-label">Position:</label>
                                             <div class="col-sm-3">
                                              <select name="changePosition" id="posOption{{$vanOnQueue->van_queue_id}}" class="form-control">
                                                  @foreach($terminals->where('destination_id',$vanOnQueue->destination_id)->first()
                                                ->vanQueue()
                                                ->whereNotNull('queue_number')
                                                ->orderBy('queue_number')->get() as $queueNumber)
                                                      <option value="{{$queueNumber->queue_number}}" @if($queueNumber->queue_number === $vanOnQueue->queue_number) {{'selected'}} @endif>{{$queueNumber->queue_number}}</option>
                                                  @endforeach
                                              </select>
                                             </div>
                                           </div>
                                           <div class="pull-right"> 
                                              <button class="btn btn-default btn-sm itemBtn{{$vanOnQueue->van_queue_id}}">CANCEL</button>
                                              <button name="changePosButton" data-val="{{$vanOnQueue->van_queue_id}}" class="btn btn-primary btn-sm">CHANGE</button>
                                             </div>
                                             <div class="clearfix"> </div>
                                        </div>
                                        <div id="destitem{{$vanOnQueue->van_queue_id}}" class="hidden">
                                            <div class="form-group">
                                              <label for="" class="col-sm-3 control-label">Destination:</label>
                                               <div class="col-sm-8">
                                                  <select id="destOption{{$vanOnQueue->van_queue_id}}" class="form-control">
                                                  @foreach($terminals as $terminal)
                                                  <option @if($terminal->destination_id == $vanOnQueue->destination_id) {{'selected'}} @endif value="{{$terminal->destination_id}}">{{$terminal->destination_name}}</option>
                                                  @endforeach
                                                  </select>
                                               </div>
                                             </div>
                                            <div class="pull-right">
                                              <button class="btn btn-default btn-sm itemBtn{{$vanOnQueue->van_queue_id}}">CANCEL</button>
                                              <button name="destBtn" data-val="{{$vanOnQueue->van_queue_id}}" class="btn btn-primary btn-sm">CHANGE</button>
                                            </div>
                                            <div class="clearfix">  </div>
                                        </div>
                                        <div id="deleteitem{{$vanOnQueue->van_queue_id}}" class="hidden">
                                                <p><strong>{{ $vanOnQueue->van->plate_number }}</strong> will be deleted. Do you want to continue?</p>
                                            <div class="pull-right">
                                                <form method="POST" action="{{route('vanqueue.destroy',[$vanOnQueue->van_queue_id])}}">
                                                    {{method_field('DELETE')}}
                                                    {{csrf_field()}}
                                                  <a class="btn btn-default btn-sm itemBtn{{$vanOnQueue->van_queue_id}}"> CANCEL</a>
                                                  <button type="submit" name="deleteBtn" data-val="{{$vanOnQueue->van_queue_id}}" class="btn btn-primary btn-sm"> YES</button>
                                                </form>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                      </span>
                                    </li>
                                  @endforeach
                              </ol>
                            </div>
                          </div>
                          <div class="col-md-5">
                            {{-- Special Unit --}}
                            <div id="special-unit" class="special-unit-heading">
                            <h4><i class="fa fa-star"></i> SPECIAL UNITS</h4>
                            </div>
                            <div class="well scrollbar scrollbar-info  thin special-unit-body">
                              <ol id='specialUnitList{{$terminal->destination_name}}' class="special-list">
                                  {{var_dump($terminal->destination_name)}}
                                  {{--@foreach($terminal->vanQueue()->where('has_privilege',1)->get() as $specializedVanOnQueue)--}}
                                      {{--<li>--}}
                                    {{--<span class="list-border">--}}
                                        {{--<div id="item-sp1">--}}
                                            {{--<div class="row">--}}
                                                {{--<div class="col-xs-12">--}}
                                                    {{--<!--plate number here-->--}}
                                                    {{--{{$specializedVanOnQueue->van->plate_number}}--}}
                                                    {{--<div class="pull-right">--}}
                                                        {{--<!--remark here -->--}}
                                                        {{--<i class="badge badge-pill badge-default ">{{$specializedVanOnQueue->remarks}}</i>--}}
                                                        {{--<!--/ remark here -->--}}
                                                        {{--<button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" style="border-radius: 100%;">--}}
                                                            {{--<i class="fa fa-gear"></i>--}}
                                                        {{--</button>--}}
                                                        {{--<div class="dropdown-menu" role="menu">--}}
                                                            {{--<a id="ondeckBtn1" class="btn btn-menu btn-sm btn-flat btn-block">On Deck</a>--}}
                                                            {{--<a id="deleteSpBtn1" class="btn btn-menu btn-sm btn-flat btn-block">Remove</a>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div id="ondeck-sp1" class="hidden">--}}
                                            {{--<div class="row">--}}
                                                {{--<div class="col-xs-12">--}}
                                                  {{--<p>Are you sure you want {{$specializedVanOnQueue->van->plate_number}} to be on deck?</p>--}}
                                                {{--</div>--}}
                                                {{--<div class="col-xs-12">--}}
                                                    {{--<div class="pull-right">--}}
                                                        {{--<form action="" method="POST">--}}
                                                            {{--{{method_field('PATCH')}}--}}
                                                            {{--{{csrf_field()}}--}}
                                                            {{--<a class="btn btn-default btn-xs itemSpBtn1">NO</a>--}}
                                                            {{--<button type="submit" class="btn btn-primary btn-xs">YES</button>--}}
                                                        {{--</form>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div id="delete-sp1" class="hidden">--}}
                                            {{--<div class="row">--}}
                                                {{--<div class="col-xs-12">--}}
                                                  {{--<p>Are you sure you want to <i class="text-red">delete</i> <strong>{{$specializedVanOnQueue->van->plate_number}}</strong>?</p>--}}
                                                {{--</div>--}}
                                                {{--<div class="col-xs-12">--}}
                                                    {{--<div class="pull-right">--}}
                                                        {{--<form method="POST" action="">--}}
                                                             {{--{{method_field('DELETE')}}--}}
                                                            {{--{{csrf_field()}}--}}
                                                            {{--<a class="btn btn-default btn-xs itemSpBtn1"> NO</a>--}}
                                                            {{--<button class="btn btn-danger btn-xs">YES</button>--}}
                                                        {{--</form>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</span>--}}
                                      {{--</li>--}}
                                  {{--@endforeach--}}
                              </ol>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
                </div>
              </div>
            </div>  
      </div>
    </div>
  </div>
</div>
      


@endsection

@section('scripts')
  @parent
  <script src="{{ URL::asset('/jquery/bootstrap3-editable/js/bootstrap-editable.min.js') }}"></script>
  <script src="{{ URL::asset('/jquery/jquery-sortable.js') }}"></script>
  <script>
    $('.select2').select2();
  </script>
    <!-- List sortable -->
    <script>
        $(function() {
            //Update Remarks
            $('button[name="updateRemarksButton"]').on('click',function() {
                var queueId = $(this).data('val');

                $.ajax( {
                        method:'PATCH',
                        url: '/home/vanqueue/'+queueId+'/updateRemarks',
                        data:
                            {
                                '_token': '{{csrf_token()}}',
                                'remark' : $('#remark'+queueId).val()
                            },
                        success: function() {
                            $("#remarkitem"+queueId).hide();
                            $("#item"+queueId).show();
                            $('#badge'+queueId).append($('#remark'+queueId).val());
                            new PNotify({
                                title: "Success!",
                                text: "Successfully update remark",
                                animate: {
                                    animate: true,
                                    in_class: 'slideInDown',
                                    out_class: 'fadeOut'
                                },
                                animate_speed: 'fast',
                                nonblock: {
                                    nonblock: true
                                },
                                cornerclass: "",
                                width: "",
                                type: "success",
                                stack: {"dir1": "down", "dir2": "right", "push": "top", "spacing1": 0, "spacing2": 0}
                            });

                        }
                    });

            });

            //Change Position
            $('button[name="changePosButton"]').on('click',function(){
                var queueId = $(this).data('val');
                var newQueueNum = $('#posOption'+queueId).val();
                $.ajax(
                    {
                        method:'PATCH',
                        url: '/updateQueueNumber/'+queueId,
                        data:
                            {
                                '_token': '{{csrf_token()}}',
                                'new_queue_num' : newQueueNum
                            },
                        success: function(response)
                        {
                            $("#positem"+queueId).hide();
                            $("#item"+queueId).show();


                            new PNotify({
                                title: "Success!",
                                text: "Successfully update remark",
                                animate: {
                                    animate: true,
                                    in_class: 'slideInDown',
                                    out_class: 'fadeOut'
                                },
                                animate_speed: 'fast',
                                nonblock: {
                                    nonblock: true
                                },
                                cornerclass: "",
                                width: "",
                                type: "success",
                                stack: {"dir1": "down", "dir2": "right", "push": "top", "spacing1": 0, "spacing2": 0}
                            });
                            if(newQueueNum == 1)
                            {
                                $('#unit'+response.beingReplacedId).before($('#unit'+queueId));
                            }
                            else
                            {
                                $('#unit'+response.beingReplacedId).after($('#unit'+queueId));
                            }


                            response[0].forEach(function(van)
                            {
                                $('#posOption'+van.vanId).val(van.queueNumber);
                                $('#queue'+van.vanId).text(van.queueNumber);
                            });

                        }
                    });
            });

            //Change Destination
            $('button[name="destBtn"]').on('click',function() {
                var queueId = $(this).data('val');
                var destId = $('#destOption'+queueId).val();

                $.ajax({
                    method:'PATCH',
                    url:'/home/vanqueue/changeDestination/'+queueId,
                    data:
                    {
                        '_token': '{{csrf_token()}}',
                        'destination': destId
                    },
                    success:
                    function(response) {
                        $("#destitem"+queueId).hide();
                        $("#item"+queueId).show();

                        new PNotify({
                            title: "Success!",
                            text: "Successfully update remark",
                            animate: {
                                animate: true,
                                in_class: 'slideInDown',
                                out_class: 'fadeOut'
                            },
                            animate_speed: 'fast',
                            nonblock: {
                                nonblock: true
                            },
                            cornerclass: "",
                            width: "",
                            type: "success",
                            stack: {"dir1": "down", "dir2": "right", "push": "top", "spacing1": 0, "spacing2": 0}
                        });

                        $('#unit'+queueId).appendTo($('#queue-list'+destId));
                        $('#posOption'+queueId).empty();

                        //Change the settings of the old destination of the moved van
                        $.each($('#queue-list'+response.oldDestiId).children().find($('select[name="changePosition"]')),function(index,element){
                            var oldQueueNumVal = index+1;

                            $(element).empty();

                            for (var i = 1; i <= response.changedOldDestiQueueNumber; i++) {
                                var option = $('<option></option>').attr("value", i).text(i);
                                $(element).append(option);
                            }

                            $(element).val(oldQueueNumVal);
                        });

                        // change the queue numbers of the vans of the past destination
                        $.each($('#queue-list'+response.oldDestiId).children().find($('p[name="queueIndicator"]')), function(index,element){
                            $(element).text(index+1);
                        });


                        //Change the settings of the old destination of the moved van
                       $.each($('#queue-list'+destId).children().find($('select[name="changePosition"]')),function(index,element) {
                           var oldQueueNumVal = $(element).val();
                           $(element).empty();
                           for (var i = 1; i <= response.newDestiQueueCount; i++) {
                               var option = $('<option></option>').attr("value", i).text(i);
                               $(element).append(option);
                           }

                           $(element).val(oldQueueNumVal);
                       });



                        $('#posOption'+queueId).val(response.newDestiQueueCount);
                        $('#queue'+queueId).text(response.newDestiQueueCount);
                    }
                });
            });

            //Put to Special Unit
            $('a[name="moveToSpecialUnitsList"]').on('click',function(){
                var queueId = $(this).data('val');

                $.ajax({
                    method:'PATCH',
                    url:'/moveToSpecialUnit/'+queueId,
                    data:
                        {
                            '_token': '{{csrf_token()}}'
                        },
                    success:
                        function(response) {
                            new PNotify({
                                title: "Success!",
                                text: "Successfully moved"+response.plateNumber+"to special units",
                                animate: {
                                    animate: true,
                                    in_class: 'slideInDown',
                                    out_class: 'fadeOut'
                                },
                                animate_speed: 'fast',
                                nonblock: {
                                    nonblock: true
                                },
                                cornerclass: "",
                                width: "",
                                type: "success",
                                stack: {"dir1": "down", "dir2": "right", "push": "top", "spacing1": 0, "spacing2": 0}
                            });
                            $('#unit'+queueId).remove();
                            $('#specialUnitList'+response.destination).load('/listSpecialUnits/'+response.destination);
                        }
                });
            });

            function specialUnitChecker() {
                $.ajax( {
                        method:'POST',
                        url: '/specialUnitChecker',
                        data: {
                                '_token': '{{csrf_token()}}'
                            },
                        success: function(response) {
                            if(response[0]) {
                                $('#confirmBoxModal').load('/showConfirmationBox/' + response[0]);
                            }
                            else {
                                if(response[1]) {
                                    $('#confirmBoxModal').load('/showConfirmationBoxOB/'+response[1]);
                                }
                            }
                        }
                    });
            }

            $('#specialUnitList').load('/listSpecialUnits/'+$('#destinationTerminals li.active').data('val'));

            $('#addQueueButt').on('click', function() {
                var destination = $('#destination').val();
                var van = $('#van').val();
                var driver = $('#driver').val();

                if( destination != "" && van != "" && driver != "") {
                    $.ajax({
                        method:'POST',
                        url: '/home/vanqueue/'+destination+'/'+van+'/'+driver,
                        data: {
                            '_token': '{{csrf_token()}}'
                        },
                        success: function(){
                            location.reload();
                        }
                    });

                }
            });

        var group = $("ol.serialization").sortable({
        group: 'serialization',
        delay: 500,
        onDrop: function ($item, container, _super) {
          var queue = group.sortable("serialize").get();
            console.log(queue);
          var jsonString = JSON.stringify(queue, null, ' ');

          $('#serialize_output2').text(jsonString);
          _super($item, container);

          $.ajax({
            method:'PATCH',
            url: '{{route("vanqueue.updateVanQueue")}}',
            data: {
                '_token': '{{csrf_token()}}',
                'vanQueue': queue
            },
            success: function(queue){
               console.log(queue);
               for(i = 0; i < queue.length; i++){
                    $('#queue'+queue[i].van_queue_id).text(queue[i].queue_number);
               }
               specialUnitChecker();
            }

        });

        }
      });

        $('#destinationTerminals li').on('click',function(e) {
            var terminal = $(e.currentTarget).data('val');
            $('#specialUnitList').load('/listSpecialUnits/'+terminal);
        });

        });
</script>

    @foreach($terminals as $terminal)
    <script>
          function search{{$terminal->destination_id}}() {
                // Declare variables
                var input, filter, ol, li, p, i;
                input = document.getElementById('queueSearch{{$terminal->destination_id}}');
                filter = input.value.toUpperCase();
                ol = document.getElementById('queue-list{{$terminal->destination_id}}');
                li = ol.getElementsByClassName('queue-item');

                // Loop through all list items, and hide those who don't match the search query
                for (i = 0; i < li.length; i++) {
                    p = li[i].getElementsByTagName('p')[0];
                    if (p.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        li[i].style.display = "";
                    } else {
                        li[i].style.display = "none";
                    }
                }
            }
    </script>
    @endforeach

    <script>
      $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
          checkboxClass: 'icheckbox_flat-blue',
          radioClass   : 'iradio_flat-blue'
        });
    </script>
  
  @foreach($queue as $vanOnQueue)
    <script>
      $(document).ready(function(){
        $("#remarkitem{{$vanOnQueue->van_queue_id}}").hide();
        $("#positem{{$vanOnQueue->van_queue_id}}").hide();
        $("#destitem{{$vanOnQueue->van_queue_id}}").hide();
        $("#deleteitem{{$vanOnQueue->van_queue_id}}").hide();
        $("#ondeck-sp{{ $vanOnQueue->van_queue_id}}").hide();
        $("#remarkBtn{{$vanOnQueue->van_queue_id}}").click(function(){
            $("#item{{$vanOnQueue->van_queue_id}}").hide();
            $("#remarkitem{{$vanOnQueue->van_queue_id}}").show();
            $("#remarkitem{{$vanOnQueue->van_queue_id}}").removeClass("hidden");
        });
        $("#posBtn{{$vanOnQueue->van_queue_id}}").click(function(){
            $("#item{{$vanOnQueue->van_queue_id}}").hide();
            $("#positem{{$vanOnQueue->van_queue_id}}").show();
            $("#positem{{$vanOnQueue->van_queue_id}}").removeClass("hidden");
        });
        $("#destBtn{{$vanOnQueue->van_queue_id}}").click(function(){
            $("#item{{$vanOnQueue->van_queue_id}}").hide();
            $("#destitem{{$vanOnQueue->van_queue_id}}").show();
            $("#destitem{{$vanOnQueue->van_queue_id}}").removeClass("hidden");
        });
        $(".itemBtn{{$vanOnQueue->van_queue_id}}").click(function(){
            $("#remarkitem{{$vanOnQueue->van_queue_id}}").hide();
            $("#positem{{$vanOnQueue->van_queue_id}}").hide();
            $("#destitem{{$vanOnQueue->van_queue_id}}").hide();
            $("#deleteitem{{$vanOnQueue->van_queue_id}}").hide();
            $("#item{{$vanOnQueue->van_queue_id}}").show();
        });
        $("#deleteBtn{{$vanOnQueue->van_queue_id}}").click(function(){
            $("#item{{$vanOnQueue->van_queue_id}}").hide();
            $("#deleteitem{{$vanOnQueue->van_queue_id}}").show();
            $("#deleteitem{{$vanOnQueue->van_queue_id}}").removeClass("hidden");
        });
      });
    </script>
    <script>
        $(document).ready(function(){
        $("#delete-sp{{$vanOnQueue->van_queue_id}}").hide();
        $("#ondeck-sp{{$vanOnQueue->van_queue_id}}").hide();
        $("#deleteSpBtn{{$vanOnQueue->van_queue_id}}").click(function(){
            $("#item-sp{{$vanOnQueue->van_queue_id}}").hide();
            $("#delete-sp{{$vanOnQueue->van_queue_id}}").show();
            $("#delete-sp{{$vanOnQueue->van_queue_id}}").removeClass("hidden");
        })
        $("#ondeckBtn{{$vanOnQueue->van_queue_id}}").click(function(){
            $("#item-sp{{$vanOnQueue->van_queue_id}}").hide();
            $("#ondeck-sp{{$vanOnQueue->van_queue_id}}").show();
            $("#ondeck-sp{{$vanOnQueue->van_queue_id}}").removeClass("hidden");
        })
        $(".itemSpBtn{{$vanOnQueue->van_queue_id}}").click(function(){
            $("#delete-sp{{$vanOnQueue->van_queue_id}}").hide();
            $("#ondeck-sp{{$vanOnQueue->van_queue_id}}").hide();
            $("#item-sp{{$vanOnQueue->van_queue_id}}").show();
        })
    });
    </script>
    @endforeach

@endsection
