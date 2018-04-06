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
    <div class="row">
        <div class="col-md-3">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Ticket</h3>
                </div>
                <form action="">
                    <div class="box-body">

                        <label for="">Terminal</label>
                        <select name="terminal" id="terminal" class="form-control">
                            @php $counter = 0; @endphp
                            @foreach($terminals as $terminal)
                                @if($terminal->trips->where('queue_number',1)->first()->plate_number ?? null)
                                    <option value="{{$terminal->terminal_id}}">{{$terminal->description}}</option>
                                @endif
                            @endforeach
                        </select>
                        <label for="">Destination</label>
                        <select name="destination" id="destination" class="form-control">
                        </select>
                        <label for="">Discount</label>
                        <div class="input-group">
                                                <span class="input-group-addon">
                                                  <input id="checkDiscount" type="checkbox">
                                                </span>
                            <select name="discount" id="discount" class="form-control">
                            </select>
                        </div>
                        <label for="">Ticket</label>
                        <select name="tickets" id="ticket" class="form-control select2" multiple="multiple" data-placeholder="Select Ticket" disabled>
                        </select>
                    </div>

                    <div class="box-footer">
                        <div id="sellButtContainer" class="pull-right">
                            <button type="button" class="btn btn-info btn-flat" @if($counter) title="Please add atleast one destination for the specified terminal on the terminal field" @else title="Please Add a van from the queue to start selling tickets" @endif disabled>Sell</button>
                        </div>
                    </div>
                </form>
            </div>

            <a href="{{route('transactions.index')}}" class="btn btn-primary btn-flat btn-block">Board Tickets</a>
        </div>

        <div class="col-md-9">
            <div class="box box-solid">
                <div class="box-body">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">

                            @foreach($terminals as $terminal)
                                @if($terminal->trips->where('queue_number',1)->first()->plate_number ?? null)
                                    <li class="@if($terminals->first() == $terminal){{'active'}}@endif"><a href="#terminal{{$terminal->terminal_id}}" data-toggle="tab">{{$terminal->description}}</a></li>
                                @endif
                            @endforeach

                        </ul>

                        <div class="tab-content">
                            @foreach($terminals as $terminal)
                                @if($terminal->trips->where('queue_number',1)->first()->plate_number ?? null)
                                    <div class="tab-pane @if($terminals->first() == $terminal){{'active'}}@endif" id="terminal{{$terminal->terminal_id}}">
                                        <div id="manageTickets{{$terminal->terminal_id}}">
                                            <div class="pull-left col-md-6">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-sm  btn-flat checkbox-toggle"><i class="fa fa-square-o"></i>
                                                    </button>
                                                    <button name="multiDelete" type="button" class="btn btn-default btn-sm btn-flat"><i class="fa fa-trash"></i></button>
                                                </div>
                                            </div>
                                            <table id="sold-tickets{{$terminal->terminal_id}}" class="table table-bordered sold-tickets">
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
                                                @foreach($terminal->transactions->where('status','Pending') as $transaction)
                                                    <tr>
                                                        <td><input value="{{$transaction->transaction_id}}" name="checkDelete" type="checkbox"></td>
                                                        <td>{{ $transaction->ticket->ticket_number }}</td>
                                                        <td>{{ $transaction->destination->description}}</td>
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
            @foreach($terminal->transactions->where('status','Pending') as $transaction)
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
        $(function () {
            specialUnitChecker();
            $('.select2').select2();

            function specialUnitChecker(){
                $.ajax({
                    method:'POST',
                    url: '{{route("trips.specialUnitChecker")}}',
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
            checkTerminals();
            listDestinations();
            listDiscounts();


            var hash = window.location.hash;
            hash && $('ul.nav a[href="' + hash + '"]').tab('show');

            $('.nav-tabs a').click(function (e) {
                $(this).tab('show');
                var scrollmem = $('body').scrollTop() || $('html').scrollTop();
                window.location.hash = this.hash;
                $('html,body').scrollTop(scrollmem);
            });


            checkDiscountBox();

            $('#checkDiscount').on('click',function(){
                checkDiscountBox();
            });

            $('#terminal').on('change',function(){
                listDestinations();
            });



            $('button[name="depart"]').on('click', function(e){
                var terminalId = $(e.currentTarget).val();

                if($('#onBoardList'+terminalId).children().length > 0){
                    var transactions = [];
                    $('#onBoardList'+terminalId+' li').each(function(){
                        transactions.push($(this).data('val'));
                        console.log(transactions);
                    });

                    $.ajax({
                        method:'PATCH',
                        url: '/home/transactions/'+terminalId,
                        data: {
                            '_token': '{{csrf_token()}}',
                            'transactions' : transactions
                        },
                        success: function(){
                            location.reload();
                        }

                    });
                }
            });

            $(document.body).on('click','#sellButt',function(){
                var terminal = $('#terminal').val();
                var destination = $('#destination').val();
                var discount = $('#discount').val();
                var ticket= $('#ticket').val();

                $.ajax({
                    method:'POST',
                    url: '{{route("transactions.store")}}',
                    data: {
                        '_token': '{{csrf_token()}}',
                        'terminal': terminal,
                        'destination': destination,
                        'discount': discount,
                        'ticket': ticket
                    },
                    success: function(){
                        location.reload();
                    }

                });

            });
            function checkTerminals(){
                if(!$('#terminal').val()){
                    $('#terminal').prop('disabled',true);
                    $('#terminal').append('<option value="">No Available Terminal</option>');
                }
            }

            function checkDiscountBox(){
                if($('#checkDiscount').is(':checked')){
                    $('#discount').prop('disabled',false);
                    listDiscounts();
                }else{
                    $('#discount').prop('disabled',true);
                    $('#discount').empty();
                }
            }

            function listDiscounts(){
                $('#discount').empty();

                if($('#terminal').val() && $('#destination').val()){
                    $.ajax({
                        method:'GET',
                        url: '{{route('transactions.listDiscounts')}}',
                        data: {
                            '_token': '{{csrf_token()}}'
                        },
                        success: function(discounts){
                            console.log(discounts);
                            if(discounts.length === 0){
                                $('#checkDiscount').prop('disabled',true);
                                $('#discount').prop('disabled',true);
                                $('#discount').append('<option value="">No Available Discounts</option>');
                            }
                            else{
                                $('#checkDiscount').prop('disabled',false);
                                discounts.forEach(function(discounts){
                                    $('#discount').append('<option value='+discounts.id+'> '+discounts.description+'</option>');
                                });
                            }

                        }
                    });
                }else{
                    $('#discount').append('<option value="">No Available Discounts</option>');
                    $('#discount').prop('disabled',true);
                }
            }

            function listDestinations() {
                $('#destination').empty();
                if ($('#terminal').val()) {
                    $.ajax({
                        method: 'GET',
                        url: '/listDestinations/' + $('#terminal').val(),
                        data: {
                            '_token': '{{csrf_token()}}'
                        },
                        success: function (destinations) {
                            if (destinations.length === 0) {
                                $('#destination').empty();
                                $('#destination').prop('disabled', true);
                                $('#destination').append('<option value="">No Available Destination</option>');
                            }
                            else {
                                destinations.forEach(function (destination) {
                                    $('#destination').append('<option value=' + destination.id + '> ' + destination.description + '</option>');
                                });
                                listTickets();
                            }

                        }
                    });
                }else{
                    $('#destination').prop('disabled', true);
                    $('#destination').append('<option value="">No Available Destination</option>');
                }
            }

            function listTickets() {
                $('#ticket').empty();
                    $.ajax({
                        method: 'GET',
                        url: '/listTickets/' + $('#terminal').val(),
                        data: {
                            '_token': '{{csrf_token()}}'
                        },
                        success: function (tickets) {
                            console.log(tickets);
                            if (tickets.length === 0) {
                                $('#ticket').prop('disabled', true);
                                $('#ticket').append('<option value =""> Tickets Not Available</option>');
                            }
                            else {
                                $('#ticket').prop('disabled', false);
                                tickets.forEach(function (ticket) {
                                    $('#ticket').append('<option value=' + ticket.id + '> ' + ticket.ticket_number + '</option>');
                                });
                                checkSellButton();
                            }

                        }
                    });

            }

            function checkSellButton(){
                var terminal = $('#terminal').val();
                var destination = $('#destination').val();
                var ticket = $('#ticket').val();

                if(terminal && destination && ticket ){
                    $('#sellButtContainer').empty();
                    $('#sellButtContainer').append('<button id="sellButt" type="button" class="btn btn-info btn-flat">Sell</button>');
                }
            }

        });
    </script>

    <script type="text/javascript">
        $(function () {
            $('body').on('click', '.list-group .list-group-item', function () {
                $(this).toggleClass('active');
            });

            @foreach($terminals as $terminal)
            $('#board{{$terminal->terminal_id}}').on('click', function () {

                var actives = $('#pendingList{{$terminal->terminal_id}}').children('.active');
                if (actives.length > 0) {
                    var transactions = [];

                    actives.each(function () {
                        transactions.push($(this).data('val'));
                    });

                    $.ajax({
                        method:'PATCH',
                        url: '{{route("transactions.updatePendingTransactions")}}',
                        data: {
                            '_token': '{{csrf_token()}}',
                            'transactions':transactions
                        },
                        success: function(){
                            console.log('success');
                        }
                    });

                    actives.clone().appendTo('#onBoardList{{$terminal->terminal_id}}').removeClass('active');
                    actives.remove();

                    var checkBox = $('.checkBox{{$terminal->terminal_id}}');

                    if (checkBox.hasClass('selected') && checkBox.children('i').hasClass('glyphicon-check')) {
                        checkBox.removeClass('selected');
                        checkBox.children('i').removeClass('glyphicon-check').addClass('glyphicon-unchecked');
                    }

                }
            });

            $('#unboard{{$terminal->terminal_id}}').on('click',function() {
                var actives = $('#onBoardList{{$terminal->terminal_id}}').children('.active');

                if (actives.length > 0) {
                    var transactions = [];
                    actives.each(function () {
                        transactions.push($(this).data('val'));
                    });

                    $.ajax({
                        method: 'PATCH',
                        url: '{{route("transactions.updateOnBoardTransactions")}}',
                        data: {
                            '_token': '{{csrf_token()}}',
                            'transactions': transactions
                        },
                        success: function () {
                            console.log('success');
                        }
                    });


                    actives.clone().appendTo('#pendingList{{$terminal->terminal_id}}').removeClass('active');
                    actives.remove();

                    var checkBox = $('.checkBox{{$terminal->terminal_id}}');

                    if (checkBox.hasClass('selected') && checkBox.children('i').hasClass('glyphicon-check')) {
                        checkBox.removeClass('selected');
                        checkBox.children('i').removeClass('glyphicon-check').addClass('glyphicon-unchecked');
                    }
                }
            });


            $('.checkBox{{$terminal->terminal_id}}').on('click',function(e) {
                var checkBox = $(e.currentTarget);
                if (!checkBox.hasClass('selected')) {
                    checkBox.addClass('selected').closest('.well').find('ul li:not(.active)').addClass('active');
                    checkBox.children('i').removeClass('glyphicon-unchecked').addClass('glyphicon-check');
                } else {
                    checkBox.removeClass('selected').closest('.well').find('ul li.active').removeClass('active');
                    checkBox.children('i').removeClass('glyphicon-check').addClass('glyphicon-unchecked');
                }
            });
            @endforeach

            $('[name="SearchDualList"]').keyup(function (e) {
                var code = e.keyCode || e.which;
                if (code == '9') return;
                if (code == '27') $(this).val(null);
                var $rows = $(this).closest('.dual-list').find('.list-group li');
                var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
                $rows.show().filter(function () {
                    var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                    return !~text.indexOf(val);
                }).hide();
            });

        });
    </script>

    <script>
        @foreach($terminals as $terminal)


        $(function(){
            $("#changedriver-header{{$terminal->terminal_id}}").hide();
            $("#deletedriver-header{{$terminal->terminal_id}}").hide();
            $("#changeDriverBtn{{$terminal->terminal_id}}").click(function(){
                $("#ondeck-header{{$terminal->terminal_id}}").hide();
                $("#changedriver-header{{$terminal->terminal_id}}").show()
                $("#changedriver-header{{$terminal->terminal_id}}").removeClass("hidden");
            })
            $("#deleteDriverBtn{{$terminal->terminal_id}}").click(function(){
                $("#ondeck-header{{$terminal->terminal_id}}").hide();
                $("#deletedriver-header{{$terminal->terminal_id}}").show()
                $("#deletedriver-header{{$terminal->terminal_id}}").removeClass("hidden");
            })
            $("#onDeckBtn1-{{$terminal->terminal_id}}").click(function(){
                $("#changedriver-header{{$terminal->terminal_id}}").hide();
                $("#ondeck-header{{$terminal->terminal_id}}").show();
            })
            $("#onDeckBtn2-{{$terminal->terminal_id}}").click(function(){
                $("#deletedriver-header{{$terminal->terminal_id}}").hide();
                $("#ondeck-header{{$terminal->terminal_id}}").show();
            })
        });


        @endforeach



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
    <script>
        $(function() {
            @foreach($terminals as $terminal)
            @if($trip = $terminal->trips->where('queue_number',1)->first())
            $('#driverChange{{$terminal->terminal_id}}').editable({
                type: 'select',
                title: 'Change Driver',
                value: "{{$terminal->trips->where('queue_number',1)->first()->driver_id}}",
                source: "{{route('transactions.listSourceDrivers')}}",
                sourceCache: true,
                pk: '{{$terminal->trips->where('queue_number',1)->first()->trip_id}}',
                url: '{{route('transactions.changeDriver',[$trip->trip_id])}}',
                validate: function(value){
                    if($.trim(value) == ""){
                        return "This field is required";
                    }
                },
                ajaxOptions: {
                    type: 'PATCH',
                    headers: { 'X-CSRF-TOKEN': '{{csrf_token()}}' }
                },
                error: function(response) {
                    if(response.status === 500) {
                        return 'Service unavailable. Please try later.';
                    } else {
                        console.log(response);
                        return response.responseJSON.message;
                    }
                },
                success: function(response){
                    console.log(response);
                }
            });
            @endif
            @endforeach

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
@endsection