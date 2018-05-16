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
    </style>
@stop
@section('content')
        <div class="padding-side-5">
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
                                @if($terminal->vanQueue->where('queue_number',1)->first() ?? null)
                                    <div class="tab-pane @if($terminals->first() == $terminal){{'active'}}@endif" id="terminal{{$terminal->destination_id}}">
                                        <div id="manageTickets{{$terminal->destination_id}}">
                                            <div class="pull-left col-md-6">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-sm  btn-flat checkbox-toggle"><i class="fa fa-square-o"></i>
                                                    </button>
                                                    <button name="multiDelete" type="button" class="btn btn-default btn-sm btn-flat"><i class="fa fa-trash"></i></button>
                                                </div>
                                            </div>
                                            <table id="sold-tickets{{$terminal->destination_id}}" class="table table-bordered sold-tickets">
                                                <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Ticket No.</th>
                                                    <th>Destination</th>
                                                    <th>Date Purchased</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach(App\Transaction::where('destination',$terminal->destination_name)->where('status','Pending')->get() as $transaction)
                                                    <tr>
                                                        <td><input value="{{$transaction->transaction_id}}" name="checkDelete" type="checkbox"></td>
                                                        <td>{{ $transaction->ticket->ticket_number }}</td>
                                                        <td>{{ $transaction->destination}}</td>
                                                        <td>{{ $transaction->created_at }}</td>
                                                        <td>
                                                            <div class="text-center">
                                                                <button value="{{$transaction->transaction_id}}" name="refund" class="btn btn-primary btn-sm"><i class="fa fa-money"></i> Refund</button>
                                                                <button data-toggle="modal" data-target="#changeDestination{{$transaction->ticket->ticket_id}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Change Destination</button>
                                                                <button value="{{$transaction->transaction_id}}" name="deleteTransaction" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                                                            </div>

                                                         </td>

                                                    </tr>
                                        @endforeach
                                        </tbody>
                                        </table>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>

        @if($terminal ?? null)
            @foreach(App\Transaction::where('destination',$terminal->destination_name)->where('status','Pending') as $transaction)
                <div class="modal fade" id="changeDestination{{$transaction->ticket->ticket_id}}">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">{{$transaction->ticket->ticket_number}}</h4>
                            </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Destination</label>
                                        <select id="changeDestination{{$transaction->transaction_id}}" class="form-control select2">
                                            @php $changeDestinationTerminal = \App\Terminal::where('terminal_id',$transaction->terminal_id)->first() ?? null; @endphp
                                            @if(!is_null($changeDestinationTerminal))
                                                @foreach( $changeDestinationTerminal->destinations as $destination)
                                                    <option @if($transaction->destination_id == $destination->destination_id){{'selected'}}@endif value="{{$destination->destination_id}}">{{$destination->description}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button value="{{$transaction->transaction_id}}" name="changeDestinationButton" type="submit" class="btn btn-primary">Change Destination</button>
                                </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            @endforeach
        @endif
    </div>
    <div id="confirmBoxModal"></div>

    @endsection

@section('scripts')
    @parent
    {{ Html::script('/jquery/bootstrap3-editable/js/bootstrap-editable.min.js') }}

    <script>
        $(function() {
            $('button[name="changeDestinationButton"]').on('click',function(e){
                $.ajax({
                    method:'PATCH',
                    url: '/home/transactions/changeDestination/'+$(e.currentTarget).val(),
                    data: {
                        '_token': '{{csrf_token()}}',
                        'changeDestination': $('select#changeDestination'+$(e.currentTarget).val()).val(),
                    },
                    success: function(){
                        location.reload();
                    }

                });
            });

            $('button[name="refund"]').on('click',function(e){
                $.ajax({
                    method:'PATCH',
                    url: '/home/transactions/refund/'+$(e.currentTarget).val(),
                    data: {
                        '_token': '{{csrf_token()}}'
                    },
                    success: function(){
                        location.reload();
                    }
                });
            });

            $('button[name="deleteTransaction"]').on('click',function(e){
                $.ajax({
                    method:'DELETE',
                    url: '/home/transactions/'+$(e.currentTarget).val(),
                    data: {
                        '_token': '{{csrf_token()}}'
                    },
                    success: function(){
                        location.reload();
                    }
                });
            });

            $('button[name="multiDelete"]').on('click',function(){
                var checked = $('input[name="checkDelete"]:checked');
                var checkedArr = [];

                if(checked.length > 0){
                    $.each(checked,function(index, createdElement){
                        checkedArr.push($(createdElement).val());
                    });

                    $.ajax({
                        method:'PATCH',
                        url: '{{route('transactions.multipleDelete')}}',
                        data: {
                            '_token': '{{csrf_token()}}',
                            'delete': checkedArr
                        },
                        success: function(){
                            location.reload();
                        }
                    });
                }

            });

        });
    </script>
    <script>
        $(function () {
            specialUnitChecker();
            $('.select2').select2();

            function specialUnitChecker(){
                $.ajax({
                    method:'POST',
                    url: '{{route("vanqueue.specialUnitChecker")}}',
                    data: {
                        '_token': '{{csrf_token()}}'
                    },
                    success: function(response){
                        if(response[0]) {
                            $('#confirmBoxModal').load('/showConfirmationBox/' + response[0]);
                        }else{
                            if(response[1]){
                                $('#confirmBoxModal').load('/showConfirmationBoxOB/'+response[1]);
                            }
                        }
                    }

                });
            }

        });
    </script>
    <script>
        $(function(){
            var activeTab = document.location.hash;
            if(!activeTab){

                activeTab = @if($terminals->first()->terminal_id ?? null)
                    "{{'#terminal'.$terminals->first()->terminal_id}}";
                @else
                {{''}}
                @endif
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
                'autoWidth': true,
                "order": [[ 1, "desc" ]]
            })
        })
    </script>
@endsection