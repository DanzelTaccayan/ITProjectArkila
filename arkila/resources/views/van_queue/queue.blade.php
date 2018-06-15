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

ol.arrow-drag{
  margin: 0 0 9px 0;
  min-height: 10px;
}
  ol.arrow-drag li{
    display: block;
    color: $linkColor;
    background: $grayLighter;
  }


  ol.arrow-drag li.placeholder{
    position: relative;
    margin: 0;
    padding: 0;
    border: none;
  }
  ol.arrow-drag li.placeholder:before{
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
  margin-bottom:  10px;
  height: 450px;
}
.queue-body-color{
  height:450px;
  background: whitesmoke;
}
.special-unit-body{
  height: 400px;
  background: whitesmoke;
}
.terminal-body{
  height: 200px;
}
.form-horizontal .editable{
  padding: 0;
}
.report-header {
    padding: 10px;
    color: white;
}
.sblue {
    background: slateblue;
}

.msgreen {
    background: mediumseagreen;
}
.smaroon {
    background: #800000;
}


  </style>
@endsection

@section('content-header','Van Queue')

@section('content')

@if($terminals->count() === 0)
        <div class="padding-side-10">
            <div class="box box-solid" style="height: 300px; padding: 50px;">
              <div class="box-body">
                  <div class="text-center">
                    <h1><i class="fa fa-warning text-red"></i>NO TERMINAL/DESTINATION FOUND</h1>
                    <h4>CREATE A TERMINAL/DESTINATION FIRST BEFORE YOU CAN USE THE VAN QUEUE FEATURE</h4>
                    <a href="{{route('terminalCreate.create')}}" class="btn btn-success btn-flat btn-lg">CREATE TERMINAL</a>
                </div>
              </div>
            </div>
        </div>
@else
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
                                  <option data-driver="{{$van->members()->where('role','Driver')->first()->member_id ?? null}}" value="{{$van->van_id}}">{{ $van->plate_number }}</option>
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
                                  <button id="addQueueButt" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> ADD TO QUEUE</button>
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
                          <li class=" @if($terminals->first() == $terminal){{'active'}} @else {{''}}@endif" data-val="{{$terminal->destination_id}}"><a href="#queue{{$terminal->destination_id}}" id="#queue{{$terminal->destination_id}}" data-toggle="tab">{{$terminal->destination_name}}</a></li>
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
                @foreach($terminals as $key => $terminal)
                  <div data-val='{{$terminal->destination_id}}' class="tab-pane @if($terminals->first() == $terminal) {{'active'}} @else {{''}} @endif" id="queue{{$terminal->destination_id}}">
                    <div class="box box-solid" style="min-height: 590px;">
                      <div class="box-body">
                        <div id="queuelist{{$terminal->destination_id}}">
                          @include('van_queue.partials.queuelist')
                        </div>
                        <div id="boardform{{$terminal->destination_id}}" class="hidden">
                          @include('van_queue.partials.boardform')
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
        @include('layouts.partials.preloader_div')
</div>

@endif

@endsection

@section('scripts')
  @parent
  <script src="{{ URL::asset('/jquery/bootstrap3-editable/js/bootstrap-editable.min.js') }}"></script>
  <script src="{{ URL::asset('/jquery/jquery-sortable.js') }}"></script>

  <script>
    $('.select2').select2();
    setDriver();

    $('#van').on('change',function(){
        setDriver();
    });

    function setDriver(){
        var driverId = $('#van option:selected').data('driver');

        $('#driver').val(driverId);
        $('#driver').trigger('change');
    }

    $('form[name="formPutOnDeck"]').on('submit',function() {
        $('#submit-loader').removeClass('hidden');
        $('#submit-loader').css("display","block");
        $(this).find('button[type="submit"]').prop('disabled',true);
        $("#ondeck-sp"+$(this).data('van')).hide();
        $("#item-sp"+$(this).data('van')).show();
    });

    $('form[name="deleteForm"]').on('submit',function(){
        $('#submit-loader').removeClass('hidden');
        $('#submit-loader').css("display","block");

        $(this).find('button[type="submit"]').prop('disabled',true);
        if($(this).data('type') === "normal") {
            $('#deleteitem'+$(this).data('van')).hide();
            $("#item"+$(this).data('van')).show();
        } else {
            $("#item-sp"+$(this).data('van')).show();
            $("#delete-sp"+$(this).data('van')).hide();
        }
    });

    $('form[name=""]')

  </script>
    <!-- List sortable -->
    <script>
    $(function(){
     var url = window.location.href;
     var activeTab = document.location.hash;

     if(!activeTab){
            activeTab = @if($terminals->first()->destination_id ?? null)
                "{{'#queue'.$terminals->first()->destination_id}}";
        @else
                "{{''}}";
        @endif
    }

     $(".tab-pane").removeClass("active in");
     $(".tab-menu").removeClass("active in");
     $(activeTab).addClass("active");
     $(activeTab + "-menu").addClass("active");

     $('a[href="#queue'+ activeTab +'"]').tab('show')

        var activeDestinationId = activeTab[activeTab.length-1];
     if(activeDestinationId) {
         if($('#destination').val() !== activeDestinationId) {
             $('#destination').val(activeDestinationId);
             $('#destination').trigger('change');
         }
     }

    });

    $(function(){
      var hash = window.location.hash;
      hash && $('ul.nav a[href="' + hash + '"]').tab('show');

      $('.nav-stacked a').click(function (e) {
      $(this).tab('show');
      var scrollmem = $('body').scrollTop() || $('html').scrollTop();
      window.location.hash = this.hash;
      $('html,body').scrollTop(scrollmem);
      });
    });
</script>

    <script>
    
        $(function() {
            specialUnitChecker();
            $('#destinationTerminals').children().on('click', function(){
                var destinationId = $(this).data('val');

                $('#destination').val(destinationId);
                $('#destination').trigger('change');
            });
            //Update Remarks
            $('button[name="updateRemarksButton"]').on('click',function() {
                var queueId = $(this).data('val');
                var button = $(this);

                button.prop('disabled',true);
                $("#remarkitem"+queueId).hide();
                $("#item"+queueId).show();

                $.ajax( {
                        method:'PATCH',
                        url: '/home/vanqueue/'+queueId+'/updateRemarks',
                        data:
                            {
                                '_token': '{{csrf_token()}}',
                                'remark' : $('#remark'+queueId).val()
                            },
                        success: function(response) {
                            button.prop('disabled',false);
                            PNotify.removeAll();
                            $('#badge'+queueId).empty();
                            if($('#remark'+queueId).val() !== "NULL") {
                                $('#badge'+queueId).append($('#remark'+queueId).val());
                            }

                            new PNotify({
                                title: "Success!",
                                text: response,
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
                            specialUnitChecker();
                        },
                        error: function(response){
                            button.prop('disabled',false);
                            $.notify({
                                // options
                                icon: 'fa fa-warning',
                                message: response.responseJSON.error
                            },{
                                // settings
                                type: 'danger',
                                autoHide: true,
                                clickToHide: true,
                                autoHideDelay: 2500,
                                placement: {
                                    from: 'bottom',
                                    align: 'right'
                                },
                                icon_type: 'class',
                                animate: {
                                    enter: 'animated bounceIn',
                                    exit: 'animated bounceOut'
                                }
                            });
                        }
                    });


            });

            //Change Position
            $('button[name="changePosButton"]').on('click',function(){
                var queueId = $(this).data('vanqueue');
                var newQueueNum = $('#posOption'+queueId).val();
                var button = $(this);

                button.prop('disabled',true);
                $("#positem"+queueId).hide();
                $("#item"+queueId).show();

                $.ajax(
                    {
                        method:'PATCH',
                        url: '/updateQueueNumber/'+queueId,
                        data:
                            {
                                '_token': '{{csrf_token()}}',
                                'new_queue_num' : newQueueNum,
                            },
                        success: function(response) {
                            button.prop('disabled',false);
                            PNotify.removeAll();
                            if($('#queueIndicator'+queueId).text() != newQueueNum){
                                if($('#queueIndicator'+queueId).text() < newQueueNum){
                                    $('#unit'+queueId).insertAfter('#unit'+response[parseInt(newQueueNum)-2].vanQueueId);
                                } else {
                                    $('#unit'+queueId).insertBefore('#unit'+response[newQueueNum].vanQueueId);
                                }

                                response.forEach(function(element){
                                    $('#queueIndicator'+element.vanQueueId).text(element.queueNumber);
                                    $('#posOption'+element.vanQueueId).val(element.queueNumber);
                                });

                                new PNotify({
                                    title: "Success!",
                                    text: "Successfully changed the van's position on the queue",
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

                                specialUnitChecker();
                            } else {
                                new PNotify({
                                    title: "Notification",
                                    text: "The van's position on the queue has not been changed",
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
                        },
                        error: function(response) {
                            button.prop('disabled',false);

                            $.notify({
                                // options
                                icon: 'fa fa-warning',
                                message: response.responseJSON.error
                            },{
                                // settings
                                type: 'danger',
                                autoHide: true,
                                clickToHide: true,
                                autoHideDelay: 2500,
                                placement: {
                                    from: 'bottom',
                                    align: 'right'
                                },
                                icon_type: 'class',
                                animate: {
                                    enter: 'animated bounceIn',
                                    exit: 'animated bounceOut'
                                }
                            });
                        }
                    });
            });

            //Change Destination
            $('button[name="destBtn"]').on('click',function() {
                var queueId = $(this).data('val');
                var destId = $('#destOption'+queueId).val();
                var button = $(this);

                button.prop('disabled',true);
                $("#destitem" + queueId).hide();
                $("#item" + queueId).show();
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
                            button.prop('disabled',false);
                            PNotify.removeAll();
                            if(response === "Destination not Updated") {
                                new PNotify({
                                    title: "Success!",
                                    text: "Destination not updated",
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
                            } else {
                                new PNotify({
                                    title: "Success!",
                                    text: "Successfully updated the van's destination",
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
                                $('#unit' + queueId).appendTo($('#queue-list' + destId));
                                $('#posOption' + queueId).empty();

                                //Change the settings of the old destination of the moved van
                                response.oldQueue.forEach(function (element) {
                                    $('#queueIndicator' + element.vanQueueId).text(element.queueNumber);

                                    //Empty
                                    $('#posOption' + element.vanQueueId).empty();

                                    //Append all the choices
                                    for (var i = 1; i <= response.oldQueue.length; i++) {
                                        $('#posOption' + element.vanQueueId).append($("<option></option>")
                                            .attr("value", i).text(i));
                                    }

                                    //Change the val
                                    $('#posOption' + element.vanQueueId).val(element.queueNumber);
                                });

                                //Change the settings of the new destination of the moved van
                                response.newQueue.forEach(function (element) {
                                    $('#queueIndicator' + element.vanQueueId).text(element.queueNumber);

                                    //Empty
                                    $('#posOption' + element.vanQueueId).empty();

                                    //Append all the choices
                                    for (var i = 1; i <= response.newQueue.length; i++) {
                                        $('#posOption' + element.vanQueueId).append($("<option></option>")
                                            .attr("value", i).text(i));
                                    }

                                    //Change the val
                                    $('#posOption' + element.vanQueueId).val(element.queueNumber);
                                });

                                specialUnitChecker();
                            }
                        },
                    error:
                        function(response) {
                            button.prop('disabled',false);
                            $.notify({
                                // options
                                icon: 'fa fa-warning',
                                message: response.responseJSON.error
                            },{
                                // settings
                                type: 'danger',
                                autoHide: true,
                                clickToHide: true,
                                autoHideDelay: 2500,
                                placement: {
                                    from: 'bottom',
                                    align: 'right'
                                },
                                icon_type: 'class',
                                animate: {
                                    enter: 'animated bounceIn',
                                    exit: 'animated bounceOut'
                                }
                            });
                        }
                });
            });

            //Move to special units
            $('a[name="moveToSpecialUnitsList"]').on('click',function() {
                var queueId = $(this).data('val');
                $('#submit-loader').removeClass('hidden');
                $('#submit-loader').css("display","block");
                $.ajax({
                    method:'PATCH',
                    url:'/moveToSpecialUnit/'+queueId,
                    data:
                        {
                            '_token': '{{csrf_token()}}'
                        },
                    success: function() {
                        location.reload();
                    },
                    error: function(response){
                        $('#submit-loader').addClass('hidden');
                        $('#submit-loader').css("display","none");

                        $.notify({
                            // options
                            icon: 'fa fa-warning',
                            message: response.responseJSON.error
                        },{
                            // settings
                            type: 'danger',
                            autoHide: true,
                            clickToHide: true,
                            autoHideDelay: 2500,
                            placement: {
                                from: 'bottom',
                                align: 'right'
                            },
                            icon_type: 'class',
                            animate: {
                                enter: 'animated bounceIn',
                                exit: 'animated bounceOut'
                            }
                        });
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
                            if(response.length > 0) {
                                PNotify.removeAll();
                                response.forEach(function(element){
                                    new PNotify({
                                        title: element.terminal+' Terminal',
                                        text: 'The van unit('+element.plateNumber+') on deck has a remark of '+element.remarks+' and cannot depart. Please move it to the special units list in order for the next van to be on deck  or remove its remark in order to board passengers',
                                        icon: 'glyphicon glyphicon-exclamation-sign',
                                        hide: false,
                                        confirm: {
                                            confirm: true,
                                            buttons: [{
                                                text: 'Ok',
                                                addClass: 'btn-primary',
                                                click: function(notice) {
                                                    notice.remove();
                                                }
                                            },
                                                null]
                                        },
                                        buttons: {
                                            closer: false,
                                            sticker: false
                                        },
                                        history: {
                                            history: false
                                        }
                                    });
                                });

                            }
                        }
                    });
            }

            $('#specialUnitList').load('/listSpecialUnits/'+$('#destinationTerminals li.active').data('val'));

            $('#addQueueButt').on('click', function() {
                var destination = $('#destination').val();
                var van = $('#van').val();
                var driver = $('#driver').val();

                if( destination != null && van != null && driver != null) {
                    $('#submit-loader').removeClass('hidden');
                    $('#submit-loader').css("display","block");
                    $.ajax({
                        method:'POST',
                        url: '/home/vanqueue/'+destination+'/'+van+'/'+driver,
                        data: {
                            '_token': '{{csrf_token()}}'
                        },
                        success: function(response){
                            if(response != "Van is already on Queue"){
                                window.location.hash = response;
                                location.reload();
                            }
                        },
                        error: function (response) {
                            $('#submit-loader').addClass('hidden');
                            $('#submit-loader').css("display","none");

                            $.notify({
                                // options
                                icon: 'fa fa-warning',
                                message: response.responseJSON.error
                            },{
                                // settings
                                type: 'danger',
                                autoHide: true,
                                clickToHide: true,
                                autoHideDelay: 2500,
                                placement: {
                                    from: 'bottom',
                                    align: 'right'
                                },
                                icon_type: 'class',
                                animate: {
                                    enter: 'animated bounceIn',
                                    exit: 'animated bounceOut'
                                }
                            });
                        }
                    });

                } else {
                    if( driver == null ) {
                        $.notify({
                            // options
                            icon: 'fa fa-warning',
                            message: 'Please choose a driver to drive the van'
                        },{
                            // settings
                            type: 'danger',
                            autoHide: true,
                            clickToHide: true,
                            autoHideDelay: 2500,
                            placement: {
                                from: 'bottom',
                                align: 'right'
                            },
                            icon_type: 'class',
                            animate: {
                                enter: 'animated bounceIn',
                                exit: 'animated bounceOut'
                            }
                        });
                    }
                    if(destination == null) {
                        $.notify({
                            // options
                            icon: 'fa fa-warning',
                            message: 'Please choose a destination before adding the van to the queue'
                        },{
                            // settings
                            type: 'danger',
                            autoHide: true,
                            clickToHide: true,
                            autoHideDelay: 2500,
                            placement: {
                                from: 'bottom',
                                align: 'right'
                            },
                            icon_type: 'class',
                            animate: {
                                enter: 'animated bounceIn',
                                exit: 'animated bounceOut'
                            }
                        });
                    }
                    if (van == null) {
                        $.notify({
                            // options
                            icon: 'fa fa-warning',
                            message: 'Please choose a van to add in the queue'
                        },{
                            // settings
                            type: 'danger',
                            autoHide: true,
                            clickToHide: true,
                            autoHideDelay: 2500,
                            placement: {
                                from: 'bottom',
                                align: 'right'
                            },
                            icon_type: 'class',
                            animate: {
                                enter: 'animated bounceIn',
                                exit: 'animated bounceOut'
                            }
                        });
                    }
                }
            });

        var group = $("ol.serialization").sortable({
        group: 'serialization',
        delay: 500,
        onDrop: function ($item, container, _super) {
          var queue = group.sortable("serialize").get();
          var jsonString = JSON.stringify(queue, null, ' ');

          $('#serialize_output2').text(jsonString);
          _super($item, container);

          $.ajax({
            method:'PATCH',
            url: '{{route("vanqueue.updateVanQueue")}}',
            data: {
                '_token': '{{csrf_token()}}',
                'vanQueue': queue,
                'number': container.el.data('number')
            },
            success: function(queue){
               queue.forEach(function(element){
                   $('#queueIndicator'+element.vanQueueId).text(element.queueNumber);
                   $('#posOption'+element.vanQueueId).val(element.queueNumber);
               });
                PNotify.removeAll();
                new PNotify({
                    title: "Success!",
                    text: "Successfully changed the order of the queue",
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

               specialUnitChecker();
            },
              error: function(response){
                  $.notify({
                      // options
                      icon: 'fa fa-warning',
                      message: response.responseJSON.error
                  },{
                      // settings
                      type: 'danger',
                      autoHide: true,
                      clickToHide: true,
                      autoHideDelay: 2500,
                      placement: {
                          from: 'bottom',
                          align: 'right'
                      },
                      icon_type: 'class',
                      animate: {
                          enter: 'animated bounceIn',
                          exit: 'animated bounceOut'
                      }
                  });
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
                    p = li[i].getElementsByClassName('hidden_plateNo')[0];
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
  

    <script>


      $(document).ready(function(){
        $(".remarkitem").hide();
        $(".positem").hide();
        $(".destitem").hide();
        $(".deleteitem").hide();
        $(".ondeck-sp").hide();

        $('a[name = "remarkBtn"]').click(function(){
            $("#item"+$(this).data('val')).hide();
            $("#remarkitem"+$(this).data('val')).show();
            $("#remarkitem"+$(this).data('val')).removeClass("hidden");
        });

        $('a[name="posBtn"]').click(function(){
            $("#item"+$(this).data('val')).hide();
            $("#positem"+$(this).data('val')).show();
            $("#positem"+$(this).data('val')).removeClass("hidden");
        });

          $('a[name="destBtn"]').click(function(){
            $("#item"+$(this).data('val')).hide();
            $("#destitem"+$(this).data('val')).show();
            $("#destitem"+$(this).data('val')).removeClass("hidden");
        });

        $(".itemBtn").click(function(){
            $("#remarkitem"+$(this).data('val')).hide();
            $("#positem"+$(this).data('val')).hide();
            $("#destitem"+$(this).data('val')).hide();
            $("#deleteitem"+$(this).data('val')).hide();
            $("#item"+$(this).data('val')).show();
        });

        $('a[name="deleteBtn"]').click(function(){
            $("#item"+$(this).data('val')).hide();
            $("#deleteitem"+$(this).data('val')).show();
            $("#deleteitem"+$(this).data('val')).removeClass("hidden");
        });
      });
    </script>

    <script>
        $(document).ready(function(){
        $(".delete-sp").hide();
        $(".ondeck-sp").hide();

        $('a[name="deleteSpBtn"]').click(function(){
            $("#item-sp"+$(this).data('val')).hide();
            $("#delete-sp"+$(this).data('val')).show();
            $("#delete-sp"+$(this).data('val')).removeClass("hidden");
        });

        $('a[name="ondeckBtn"]').click(function(){
            $("#item-sp"+$(this).data('val')).hide();
            $("#ondeck-sp"+$(this).data('val')).show();
            $("#ondeck-sp"+$(this).data('val')).removeClass("hidden");
        });

        $(".itemSpBtn").click(function(){
            $("#delete-sp"+$(this).data('val')).hide();
            $("#ondeck-sp"+$(this).data('val')).hide();
            $("#item-sp"+$(this).data('val')).show();
        });
    });
    </script>
    @foreach($terminals as $key => $terminal)
      <script>
        $('#boardBtn{{$terminal->destination_id}}').click(function(){
          $('#boardform{{$terminal->destination_id}}').removeClass('hidden');
          $('#boardform{{$terminal->destination_id}}').show();
          $('#queuelist{{$terminal->destination_id}}').hide();
        });
        $('#cancelboardBtn{{$terminal->destination_id}}').click(function(){
          $('#boardform{{$terminal->destination_id}}').hide();
          $('#queuelist{{$terminal->destination_id}}').show();
        });
      </script>
    @endforeach

@endsection
