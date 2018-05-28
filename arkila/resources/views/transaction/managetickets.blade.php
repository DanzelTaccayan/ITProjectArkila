@extends('layouts.master')
@section('title', 'Ticket Sale')
@section('links')
    @parent
    {{ Html::style('/jquery/bootstrap3-editable/css/bootstrap-editable.css') }}
    <style>
        .list-arrows button{
            min-width: 95px;
            max-width: 95px;
        }

        .well{
            margin-bottom: 0px;
            min-height: 450px;
        }

        .ticket-box{
        }
        .dual-list .list-group {
            margin-top: 8px;
        }

        .list-left li, .list-right li {
            cursor: pointer;
        }

        .list-arrows {
            padding-top: 100px;
        }

        .list-arrows button {
            margin-bottom: 20px;
        }

        .with-shadow{
            box-shadow:0px 0px 15px 0px rgba(0, 0, 0, 0.96);
        }
        .scrollbar {
            padding:0px;
            height: 100%;
            float: left;
            width: 100%;
            background: #fff;
            overflow-y: scroll;
            margin-bottom: 15px;
        }

        .ticket-overflow {
            min-height: 320px;
            max-height: 320px;
        }

        .scrollbar-info::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
            background-color: #F5F5F5;
            border-radius: 10px; }

        .scrollbar-info::-webkit-scrollbar {
            width: 12px;
            background-color: #F5F5F5; }

        .scrollbar-info::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
            background-color: #33b5e5; }

        .square::-webkit-scrollbar-track {
            border-radius: 0 !important; }

        .square::-webkit-scrollbar-thumb {
            border-radius: 0 !important; }

        .thin::-webkit-scrollbar {
            width: 6px; }

        .list-group-style {
            margin-bottom: 0px;
        }

        .list-group-item:first-child {
            border-top-left-radius: 0px ;
            border-top-right-radius: 0px ;
        }
        .select2-container--open
        .select2-dropdown--below{
            z-index:1100;
        }

        #driverChange{
            color: white;
        }
        .d-inline{
            display: inline-block!important;
        }
        .back {
            margin-bottom: 10px;
            margin-left: 10px;
        }
    </style>
@stop
@section('content')
        <div class="padding-side-5">
            <div>   
                <div class="d-inline">
                    <h2 class="text-white">LIST OF UNUSED TICKETS</h2>
                </div>
                <div class="d-inline back">    
                    <a href="{{route('transactions.index')}}" class="btn bg-maroon btn-flat">SELL AND DEPART</a>
                </div>
            </div>
            <div class="box box-solid">
                <div class="box-body with-shadow">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">

                            @foreach($terminals as $terminal)
                                    <li class="@if($terminals->first() == $terminal){{'active'}}@endif"><a href="#terminal{{$terminal->destination_id}}" data-toggle="tab">{{$terminal->destination_name}}</a></li>
                            @endforeach

                        </ul>

                        <div class="tab-content">
                            @foreach($terminals as $terminal)
                                    <div class="tab-pane @if($terminals->first() == $terminal){{'active'}}@endif" id="terminal{{$terminal->destination_id}}">
                                        <div id="manageTickets{{$terminal->destination_id}}">
                                            <div class="pull-left col-md-6">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-sm  btn-flat checkbox-toggle"><i class="fa fa-square-o"></i>
                                                    </button>
                                                    <button name="initialMultiRefund" type="button" class="btn btn-default btn-sm btn-flat"><i  class="fa fa-money"></i></button>
                                                    <button name="initialMultiDelete" type="button" class="btn btn-default btn-sm btn-flat"><i  class="fa fa-trash"></i></button>
                                                </div>
                                            </div>
                                            <table id="sold-tickets{{$terminal->destination_id}}" class="table table-bordered sold-tickets">
                                                <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Ticket No.</th>
                                                    <th>Destination</th>
                                                    <th>Date Purchased</th>
                                                    <th id="actionHead" class="text-center">Actions</th>
                                                    <th id="destHead" class="hidden">Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach(App\Ticket::whereIn('destination_id',$terminal->routeFromDestination->pluck('destination_id'))->where('status','Pending')->get() as $ticket)
                                                    <tr id="ticket{{$ticket->ticket_id}}">
                                                        <td><input value="{{$ticket->ticket_id}}" name="checkInput" type="checkbox"></td>
                                                        <td>{{ $ticket->ticket_number }}</td>
                                                        <td>{{ $ticket->destination->destination_name}}</td>
                                                        <td>{{ $ticket->updated_at }}</td>
                                                        <td id="actionBody{{$ticket->ticket_id}}">
                                                            <div class="text-center">
                                                                <button type="button" data-ticketid="{{$ticket->ticket_id}}" data-ticketnumber="{{$ticket->ticket_number}}" data-amount="{{$ticket->fare}}" name="initialRefund"  class="btn btn-primary btn-sm" data-toggle="modal" data-target="#refund-modal"><i class="fa fa-money"></i> REFUND</button>

                                                                <button type="button" data-ticketid="{{$ticket->ticket_id}}" data-ticketnumber="{{$ticket->ticket_number}}" name="initialLost" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#lost-modal"><i class="fa fa-search-minus"></i> LOST</button>

                                                                <button type="button" data-ticketid="{{$ticket->ticket_id}}" data-ticketnumber="{{$ticket->ticket_number}}" name="initialCancel" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#cancel-modal"><i class="fa fa-trash"></i> CANCEL</button>
                                                            </div>
                                                        </td>
                                                        <td id="destBody{{$ticket->ticket_id}}" class="hidden">
                                                            <select name="" id="" class="form-control">
                                                                <option value="">dest 1</option>
                                                                <option value="">dest 2</option>
                                                                <option value="">dest 3</option>
                                                            </select>
                                                            <div class="pull-right">
                                                                <button class="btn btn-default btn-sm btn-flat btn-cancel">CANCEL</button>
                                                                <button class="btn btn-info btn-sm btn-flat">CHANGE</button>
                                                            </div>
                                                        </td>


                                                    </tr>
                                        @endforeach
                                        </tbody>
                                        </table>
                                        </div>
                                    </div>
                            @endforeach
                                {{--Refund--}}
                                <div class="modal" id="refund-modal">
                                    <form id="refundForm" method="POST">
                                        {{csrf_field()}}
                                        {{method_field('PATCH')}}
                                        <div class="modal-dialog" style="margin-top: 10%;">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span></button>
                                                    <h4 class="modal-title"></h4>
                                                </div>
                                                <div class="modal-body">
                                                    <h1 class="text-center text-blue"><i class="fa fa-money"></i> REFUND?</h1>
                                                    <p class="text-center">REFUNDED TICKETS WILL <strong class="text-red">NOT BE RECORDED AS SALE</strong></p>
                                                    <p class="text-center">ARE YOU SURE <strong id="refundTicketNumber" class="text-maroon"></strong> WILL BE REFUNDED?</p>
                                                    <h3 class="text-center ">VALUE: <strong id="refundAmount" class="text-green"></strong></h3>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="text-center">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                                                        <button type="submit" class="btn btn-primary">YES</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </form>
                                </div>

                                {{--Lost--}}
                                <div class="modal" id="lost-modal">
                                    <form id="lostForm" method="POST">
                                        <div class="modal-dialog" style="margin-top: 10%;">

                                            {{csrf_field()}}
                                            {{method_field('PATCH')}}
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span></button>
                                                    <h4 class="modal-title"></h4>
                                                </div>
                                                <div class="modal-body">
                                                    <h1 class="text-center text-yellow"><i class="fa fa-search-minus"></i> LOST?</h1>
                                                    <p class="text-center">LOST OR UNRETURNED TICKETS WILL STILL BE <strong class="text-green">RECORDED AS SALE</strong></p>
                                                    <p class="text-center">ARE YOU SURE <strong id="lostTicketNumber" class="text-maroon"></strong> IS LOST OR UNRETURNED?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="text-center">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                                                        <button type="submit" class="btn btn-primary">YES</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- /.modal-content -->
                                        </div>
                                    </form>
                                    <!-- /.modal-dialog -->
                                </div>

                                {{--Cancel--}}
                                <div class="modal" id="cancel-modal">
                                    <form id="cancelForm" method="POST">
                                        {{csrf_field()}}
                                        {{method_field('DELETE')}}
                                        <div class="modal-dialog" style="margin-top: 10%;">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span></button>
                                                    <h4 class="modal-title"></h4>
                                                </div>
                                                <div class="modal-body">
                                                    <h1 class="text-center text-red"><i class="fa fa-trash"></i> CANCEL?</h1>
                                                    <p class="text-center">CANCELLED TRANSACTIONS <strong class="text-red">WILL NOT BE RECORDED AS SALE</strong>.</p>
                                                    <p class="text-center">ARE YOU SURE YOU WANT TO CANCEL <strong id="cancelTicketNumber" class="text-maroon"></strong>?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="text-center">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                                                        <button type="submit" class="btn btn-primary">YES</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                    </form>
                                    <!-- /.modal-dialog -->
                                </div>

                                {{--MultiRefund--}}
                                <div class="modal" id="multirefund-modal">
                                    <div class="modal-dialog" style="margin-top: 10%;">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span></button>
                                                <h4 class="modal-title"></h4>
                                            </div>
                                            <div class="modal-body">
                                                <h1 class="text-center text-blue"><i class="fa fa-money"></i> REFUND?</h1>
                                                <p class="text-center">REFUNDED TICKETS WILL <strong class="text-red">NOT BE RECORDED AS SALE.</strong></p>
                                                <p class="text-center">ARE YOU SURE THE <strong id="multiRefundModal" class="text-maroon"></strong> WILL BE REFUNDED?</p>
                                                <h3 class="text-center ">TOTAL VALUE: <strong id="multiRefundModalAmount" class="text-green"></strong></h3>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="text-center">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                                                    <button name="multiRefund" type="button" class="btn btn-primary" data-dismiss="modal">YES</button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>

                                {{--MultiDelete--}}
                                <div class="modal" id="multidelete-modal">
                                    <div class="modal-dialog" style="margin-top: 10%;">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span></button>
                                                <h4 class="modal-title"></h4>
                                            </div>
                                            <div class="modal-body">
                                                <h1 class="text-center text-red"><i class="fa fa-trash"></i> CANCEL?</h1>
                                                <p class="text-center">CANCELLED TRANSACTIONS <strong class="text-red">WILL NOT BE RECORDED AS SALE</strong>.</p>
                                                <p class="text-center">ARE YOU SURE YOU WANT TO CANCEL THE <strong id="multiDeleteModal" class="text-maroon"></strong>?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="text-center">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                                                    <button name="multiDelete" type="button" data-dismiss="modal" class="btn btn-primary">YES</button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection

@section('scripts')
    @parent
    {{ Html::script('/jquery/bootstrap3-editable/js/bootstrap-editable.min.js') }}

    <script>
        $(function() {

            //Refund
            $('button[name="initialRefund"]').on('click',function(){
                var amount = $(this).data('amount');
                var ticketNumber = $(this).data('ticketnumber');
                var ticketId = $(this).data('ticketid');


                $('#refundTicketNumber').text(ticketNumber+' TICKET');
                $('#refundAmount').text('₱ '+amount);
                $('#refundForm').prop('action',"/home/transactions/refund/"+ticketId)
            });

            //Cancel
            $('button[name="initialCancel"]').on('click',function(){
                var ticketId = $(this).data('ticketid');
                var ticketNumber = $(this).data('ticketnumber');

                $('#cancelTicketNumber').text(ticketNumber+' TICKET');
                $('#cancelForm').prop('action','/home/transactions/'+ticketId);
            });

            //Lost
            $('button[name="initialLost"]').on('click', function(){
                var ticketId = $(this).data('ticketid');
                var ticketNumber = $(this).data('ticketnumber');

                $('#lostTicketNumber').text(ticketNumber+' TICKET');
                $('#lostForm').prop('action', '/home/transactions/lost/'+ticketId);
            });

            //Multi Refund
            $('button[name="initialMultiRefund"]').on('click',function(){
                var checked = $('input[name="checkInput"]:checked');
                var amount = 0;

                if(checked.length > 0) {
                    $.each(checked, function (index, createdElement) {
                        var ticketId = $(createdElement).val();
                        amount += parseFloat($('button[name="initialRefund"][data-ticketid="'+ticketId+'"]').data('amount'));
                    });

                    $('#multiRefundModal').text('('+checked.length+') SELECTED TICKETS');
                    $('#multiRefundModalAmount').text('₱ '+amount.toFixed(2));
                    $('#multirefund-modal').modal('show');
                }
            });

            $('button[name="multiRefund"]').on('click',function(){
                var checked = $('input[name="checkInput"]:checked');
                var checkedArr = [];

                if(checked.length > 0){
                    $.each(checked,function(index, createdElement){
                        checkedArr.push($(createdElement).val());
                    });

                    $.ajax({
                        method:'PATCH',
                        url: '{{route('transactions.multipleRefund')}}',
                        data: {
                            '_token': '{{csrf_token()}}',
                            'refund': checkedArr
                        },
                        success: function(response){
                            checkedArr.forEach(function(ticketId){
                                $('#ticket'+ticketId).remove();
                                $('#refund-modal'+ticketId).remove();
                            });

                            new PNotify({
                                title: "Success!",
                                text: "Successfully refunded the following tickets:  "+ response,
                                hide: true,
                                delay: 2500,
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

                        },
                        error:function(response) {
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

            //Multi Cancel
            $('button[name="initialMultiDelete"]').on('click',function(){
                var checkCount = $('input[name="checkInput"]:checked').length;
                if(checkCount > 0) {
                    $('#multiDeleteModal').text('('+checkCount+') SELECTED TICKETS');
                    $('#multidelete-modal').modal('show');
                }
            });

            $('button[name="multiDelete"]').on('click',function(){
                var checked = $('input[name="checkInput"]:checked');
                var checkedArr = [];

                if(checked.length > 0){
                    $.each(checked,function(index, createdElement){
                        checkedArr.push($(createdElement).val());
                    });

                    $.ajax({
                        method:'DELETE',
                        url: '{{route('transactions.multipleDelete')}}',
                        data: {
                            '_token': '{{csrf_token()}}',
                            'delete': checkedArr
                        },
                        success: function(response){
                            checkedArr.forEach(function(ticketId){
                                $('#ticket'+ticketId).remove();
                                $('#refund-modal'+ticketId).remove();
                            });

                            new PNotify({
                                title: "Success!",
                                text: "Successfully cancelled the following tickets:  "+ response,
                                hide: true,
                                delay: 2500,
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

                        },
                        error:function(response) {
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

        });
    </script>
    <script>
        $(function(){
            var activeTab = document.location.hash;
            if(!activeTab){

                activeTab = @if($terminals->first()->terminal_id ?? null) "{{'#terminal'.$terminals->first()->terminal_id}}"; @else {{" ;"}}@endif
            }

            $(".tab-pane").removeClass("active in");
            $(".tab-menu").removeClass("active in");
            $(activeTab).addClass("active");
            $(activeTab + "-menu").addClass("active");

            $('a[href="#'+ activeTab +'"]').tab('show');
            window.location.hash = activeTab;

        });
        $(function(){
            var hash = window.location.hash;
            hash && $('ul.nav a[href="' + hash + '"]').tab('show');

            $('.nav-tabs a').click(function (e) {
                $(this).tab('show');
                var scrollmem = $('body').scrollTop() || $('html').scrollTop();
                window.location.hash = this.hash;
                $('html,body').scrollTop(scrollmem);
            });
        });
    </script>
    <script>
        $(function () {
            //Enable iCheck plugin for checkboxes
            //iCheck for checkbox and radio inputs
            $('.sold-tickets input[type="checkbox"]').iCheck({
                checkboxClass: 'icheckbox_flat-blue'
            });

            //Enable check and uncheck all functionality
            $(".checkbox-toggle").click(function () {
                var clicks = $(this).data('clicks');
                if (clicks) {
                    //Uncheck all checkboxes
                    $(".sold-tickets input[type='checkbox']").iCheck("uncheck");
                    $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
                } else {
                    //Check all checkboxes
                    $(".sold-tickets input[type='checkbox']").iCheck("check");
                    $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
                }
                $(this).data("clicks", !clicks);
            });
        });
    </script>
    <script>
        $(function() {
            $('.sold-tickets').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': false,
                'order': [[ 3, "desc" ]], 
                'aoColumnDefs': [
                    {
                    'bSortable': false,
                    'aTargets': [0]
                    },

                    {
                    'bSortable': false,
                    'aTargets': [4]
                    }
                ], 
            })
        })
    </script>
@endsection