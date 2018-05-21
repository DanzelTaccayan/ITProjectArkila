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
    </style>
@stop
@section('content')
        <div class="padding-side-5">
            <div>   
                <div class="d-inline">
                    <h2 class="text-white">LIST OF UNUSED TICKETS</h2>
                </div>
                <div class="d-inline">    
                    <a href=" " class="btn bg-maroon btn-flat">POS</a>
                </div>
            </div>
            <div class="box box-solid">
                <div class="box-body with-shadow">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">

                            @foreach($terminals as $terminal)
                                @if($terminal->vanQueue->where('queue_number',1)->first() ?? null)
                                    <li class="@if($terminals->first() == $terminal){{'active'}}@endif"><a href="#terminal{{$terminal->destination_id}}" data-toggle="tab">{{$terminal->destination_name}}</a></li>
                                @endif
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
                                                    <th id="actionHead">Actions</th>
                                                    <th id="destHead" class="hidden">Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach(App\Transaction::where('destination',$terminal->destination_name)->where('status','Pending')->get() as $transaction)
                                                    <tr id="transaction{{$transaction->transaction_id}}">
                                                        <td><input value="{{$transaction->transaction_id}}" name="checkInput" type="checkbox"></td>
                                                        <td>{{ $transaction->ticket->ticket_number }}</td>
                                                        <td>{{ $transaction->destination}}</td>
                                                        <td>{{ $transaction->created_at }}</td>
                                                        <td id="actionBody{{$transaction->transaction_id}}">
                                                            <div class="text-center">
                                                                <button type="button" data-transaction="{{$transaction->transaction_id}}" data-amount="{{$transaction->amount_paid}}" name="initialRefund"  class="btn btn-primary btn-sm" data-toggle="modal" data-target="#refund-modal{{$transaction->ticket->ticket_id}}"><i class="fa fa-money"></i> REFUND</button>

                                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#lost-modal{{$transaction->ticket->ticket_id}}"><i class="fa fa-search-minus"></i> LOST</button>

                                                                <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#delete-modal{{$transaction->ticket->ticket_id}}"><i class="fa fa-trash"></i> DELETE</button>
                                                            </div>
                                                        </td>
                                                        <td id="destBody{{$transaction->transaction_id}}" class="hidden">
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
                                        @foreach(App\Transaction::where('destination',$terminal->destination_name)->where('status','Pending')->get() as $transaction)
                                        <div class="modal" id="refund-modal{{$transaction->ticket->ticket_id}}">
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
                                                        <p class="text-center">ARE YOU SURE <strong class="text-maroon">{{ $transaction->ticket->ticket_number }} TICKET</strong> WILL BE REFUNDED?</p>
                                                        <h3 class="text-center ">VALUE: <strong id="amount{{$transaction->transaction_id}}" class="text-green"></strong></h3>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="text-center">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                                                            <button data-transaction="{{$transaction->transaction_id}}" data-dismiss="modal" name="refund" type="button" class="btn btn-primary">YES</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <div class="modal" id="lost-modal{{$transaction->ticket->ticket_id}}">
                                            <div class="modal-dialog" style="margin-top: 10%;">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span></button>
                                                        <h4 class="modal-title"></h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h1 class="text-center text-yellow"><i class="fa fa-search-minus"></i> LOST?</h1>
                                                        <p class="text-center">LOST OR UNRETURNED TICKETS WILL STILL BE <strong class="text-green">RECORDED AS SALE</strong></p>
                                                        <p class="text-center">ARE YOU SURE <strong class="text-maroon">{{ $transaction->ticket->ticket_number }} TICKET</strong> IS LOST OR UNRETURNED?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="text-center">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                                                            <button data-transaction="{{$transaction->transaction_id}}" name="lostButton" type="button" data-dismiss="modal" class="btn btn-primary">YES</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <div class="modal" id="delete-modal{{$transaction->ticket->ticket_id}}">
                                            <div class="modal-dialog" style="margin-top: 10%;">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span></button>
                                                        <h4 class="modal-title"></h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h1 class="text-center text-red"><i class="fa fa-trash"></i> DELETE?</h1>
                                                        <p class="text-center">DELETED TRANSACTIONS <strong class="text-red">WILL NOT BE RECORDED AS SALE</strong>.</p>
                                                        <p class="text-center">ARE YOU SURE YOU WANT TO DELETE <strong class="text-maroon">{{ $transaction->ticket->ticket_number }} TICKET</strong>?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="text-center">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                                                            <button type="button" name="deleteTransaction" data-transaction="{{$transaction->transaction_id}}" class="btn btn-primary" data-dismiss="modal">YES</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                                
                                        @endforeach


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
                                        <div class="modal" id="multidelete-modal">
                                            <div class="modal-dialog" style="margin-top: 10%;">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span></button>
                                                        <h4 class="modal-title"></h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h1 class="text-center text-red"><i class="fa fa-trash"></i> DELETE?</h1>
                                                        <p class="text-center">DELETED TRANSACTIONS <strong class="text-red">WILL NOT BE RECORDED AS SALE</strong>.</p>
                                                        <p class="text-center">ARE YOU SURE YOU WANT TO DELETE THE <strong id="multiDeleteModal" class="text-maroon"></strong>?</p>
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

                            @endforeach
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
            $('button[name="deleteButton"]').on('click',function(){
                var transactionId = $(this).data('transaction');
                $.ajax({
                    method:'PATCH',
                    url: '/home/transactions/changeDestination/'+transactionId,
                    data: {
                        '_token': '{{csrf_token()}}',
                        'destination': $('#changeDestination'+transactionId).val(),
                    },
                    success: function(response){
                        $('#changeDestination'+transactionId).val(response);
                    }

                });
            });

            //Refund
            $('button[name="initialRefund"]').on('click',function(){
                var amount = $(this).data('amount');
                var transactionId = $(this).data('transaction');

                $('#amount'+transactionId).text('₱ '+amount);
            });
            $('button[name="refund"]').on('click',function(){
                var transactionId = $(this).data('transaction');

                $.ajax({
                    method:'PATCH',
                    url: '/home/transactions/refund/'+transactionId,
                    data: {
                        '_token': '{{csrf_token()}}'
                    },
                    success: function(){
                        $('#transaction'+transactionId).remove();
                        $('#refund-modal'+transactionId).remove();
                    }
                });
            });
            $('button[name="initialMultiRefund"]').on('click',function(){
                var checked = $('input[name="checkInput"]:checked');
                var amount = 0;

                if(checked.length > 0) {
                    $.each(checked, function (index, createdElement) {
                        var transactionId = $(createdElement).val();
                        amount += parseFloat($('button[name="initialRefund"][data-transaction="'+transactionId+'"]').data('amount'));
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
                        success: function(){
                            checkedArr.forEach(function(transactionId){
                                $('#transaction'+transactionId).remove();
                                $('#refund-modal'+transactionId).remove();
                            })
                        }
                    });
                }

            });

            //Delete
            $('button[name="deleteTransaction"]').on('click',function(){
                var transactionId = $(this).data('transaction');

                $.ajax({
                    method:'DELETE',
                    url: '/home/transactions/'+transactionId,
                    data: {
                        '_token': '{{csrf_token()}}'
                    },
                    success: function(){
                        $('#transaction'+transactionId).remove();
                        $('#refund-modal'+transactionId).remove();
                    }
                });
            });
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
                        success: function(){
                            checkedArr.forEach(function(transactionId){
                                $('#transaction'+transactionId).remove();
                                $('#refund-modal'+transactionId).remove();
                            })
                        }
                    });
                }

            });

            //Lost
            $('button[name="lostButton"]').on('click',function(){
                var transactionId = $(this).data('transaction');

                $.ajax({
                    method:'PATCH',
                    url: '/home/transactions/lost/'+transactionId,
                    data: {
                        '_token': '{{csrf_token()}}'
                    },
                    success: function(){
                        $('#transaction'+transactionId).remove();
                        $('#refund-modal'+transactionId).remove();
                    }
                });
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
                "order": [[ 1, "desc" ]]
            })
        })
    </script>
@endsection