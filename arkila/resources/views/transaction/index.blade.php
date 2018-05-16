@extends('layouts.master')
@section('title', 'Ticket Sale')
@section('links')
    @parent
    {{ Html::style('/jquery/bootstrap3-editable/css/bootstrap-editable.css') }}
<style>
        .list-arrows button{
             width: 95px;
        }

        .well{
            margin-bottom: 0px;
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

.text-white{
    color: white;
}
.popover-title{
    color: black;
}
.fixed-table-header{
    margin-right: 10px;
}
.table-area{
    position: relative;
    height: 200px;
}
.table-dest{
    position: relative;
    height: 415px;
    background: #f8f8f6;
}

.nav-terminal{
    height: 510px;
    
}
.terminal-side{
    height: 610px;
    padding: 10px;
    background: white;
    border-radius: 5px
}

.ticket-dest-table tbody tr td {
    padding:5px;
    width: 50%;
}
.ticket-dest-table tbody tr .btn-dest{
    width: 85%;
}

.ticket-dest-table tbody tr .btn-dest .badge{
    margin-top: 4px;
}


    </style>
    @stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-body" style="background: #ebbea86e;">
                <div class="row">
                    <div class="col-md-9">
                        <div class="nav-tabs-custom">
                            <div class="tab-content">
                                @foreach($terminals as $terminal)

                                    <div class="tab-pane @if($terminal->first() == $terminal){{'active'}}@endif" id="terminal{{$terminal->destination_id}}">
                                        <div id="sellTickets{{$terminal->destination_id}}">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="well">
                                                        <div>
                                                            <label for="">Customer</label>
                                                            <select class="form-control select2">
                                                                <option value="">Walk-in Customer</option>
                                                                <option value=""> Reserved Cust 1</option>
                                                                <option value=""> Reserved Cust 2</option>
                                                                <option value=""> Reserved Cust 3</option>
                                                                <option value=""> Reserved Cust 4</option>
                                                                <option value=""> Reserved Cust 5</option>
                                                             </select>
                                                        </div>
                                                        <div class="" style="margin-top: 3%">
                                                            <div class="fixed-table-header">
                                                                <table class="table table-condensed table-striped"  style="margin-bottom: 0; margin-right:  2px;">
                                                                    <thead >
                                                                        <tr class="success">
                                                                            <th class="text-center" style="width: 150px;">Ticket Number</th>
                                                                            <th>Fare</th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                            <div class="table-area scrollbar scrollbar-info thin">
                                                            <table class="table table-condensed table-striped">
                                                                <tbody id="selectedList{{$terminal->destination_id}}">
                                                                    @foreach(App\Ticket::showAllSelectedTickets($terminal->routeFromDestination->pluck('destination_id'))->get() as $ticket)
                                                                            <tr>
                                                                                <td>
                                                                                    <button type="button" class="btn btn-block btn-xs edit btn-primary">{{$ticket->ticket_number}}</button>
                                                                                </td>
                                                                                <td class="text-right">
                                                                                    {{$ticket->fare}}
                                                                                </td>
                                                                                <td class="text-right">
                                                                                    <button name="deleteSpecificSelectedTicket" class="btn btn-xs" data-val="{{$ticket->selectedTicket->selected_ticket_id}}" class="text-red"><i class="fa fa-trash"></i></button>
                                                                                </td>
                                                                            </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <table class="table table-condensed responsive-table table-striped">
                                                                <tbody>
                                                                    <tr class="info">
                                                                        <td>Regular</td>
                                                                        <td id="totalRegularTicket{{$terminal->destination_id}}" class="text-right">{{App\Ticket::showAllSelectedTickets($terminal->routeFromDestination->pluck('destination_id'))->where('type','Regular')->get()->count()}} <i class="fa fa-ticket"></i></td>
                                                                        <td id="regularTotalPayment{{$terminal->destination_id}}" class="text-right">₱ {{App\Ticket::showAllSelectedTickets($terminal->routeFromDestination->pluck('destination_id'))->where('type','Regular')->get()->pluck('fare')->sum()}}</td>
                                                                    </tr>
                                                                    <tr class="info">
                                                                        <td>Discounted</td>
                                                                        <td id="totalDiscountedTicket{{$terminal->destination_id}}" class="text-right">{{App\Ticket::showAllSelectedTickets($terminal->routeFromDestination->pluck('destination_id'))->where('type','Discount')->get()->count()}} <i class="fa fa-ticket"></i></td>
                                                                        <td id="discountedTotalPayment{{$terminal->destination_id}}" class="text-right">₱ {{App\Ticket::showAllSelectedTickets($terminal->routeFromDestination->pluck('destination_id'))->where('type','Discount')->get()->pluck('fare')->sum()}}</td>
                                                                    </tr>
                                                                    <tr class="success">
                                                                        <td><strong>Total</strong></td>
                                                                        <td id="totalTickets{{$terminal->destination_id}}" class="text-right">{{App\Ticket::showAllSelectedTickets($terminal->routeFromDestination->pluck('destination_id'))->get()->count()}} <i class="fa fa-ticket"></i></td>
                                                                        <td id="totalPayment{{$terminal->destination_id}}" class="text-right"><strong>₱ {{App\Ticket::showAllSelectedTickets($terminal->routeFromDestination->pluck('destination_id'))->get()->pluck('fare')->sum()}}</strong></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="pull-right">
                                                            <form method="POST" action="{{route('transactions.store',[$terminal->destination_id])}}">
                                                                {{csrf_field()}}
                                                                <button type="submit" class="btn btn-success btn-flat" data-toggle="modal" data-target="#modal-default">SELL</button>
                                                            </form>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                                                <input type="text" class="form-control" placeholder="Search Destination" id="myInput" onkeyup="myFunction()">
                                                                </div>
                                                            </div>
                                                            <div class="fixed-table-header">
                                                                <table class="table table-condensed table-striped"  style="margin-bottom: 0; margin-right:  2px;">
                                                                    <thead >
                                                                        <tr class="info">
                                                                            <th class="text-center">REGULAR TICKETS</th>
                                                                            <th class="text-center">DISCOUNT TICKETS</th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                            <div class="table-dest scrollbar scrollbar-info thin" style="margin-bottom: 0;">
                                                                <table id="destination-table" class="table table-striped ticket-dest-table" style="margin-bottom: 0;">
                                                                    <tbody>
                                                                    @foreach($terminal->routeFromDestination as $destination)
                                                                        <tr>
                                                                            <td id="row{{$destination->destination_id}}">
                                                                                <button name="ticketButton" data-terminal="{{$terminal->destination_id}}" data-route="{{$destination->destination_id}}" data-type="Regular" class="btn btn-primary btn-flat btn-dest">
                                                                                    {{$destination->destination_name}}
                                                                                    @if($regTicketNum =  $destination->tickets->where('type','Regular')->whereIn('ticket_id',$destination->selectedTickets->pluck('ticket_id'))->count())
                                                                                        <span id="regularTicketPerDest{{$destination->destination_id}}" class="badge bg-yellow pull-right">
                                                                                            {{$regTicketNum}}
                                                                                        </span>
                                                                                    @endif
                                                                                </button>
                                                                                <button name="deleteLastSelectedTicket" data-type="Regular" data-terminal="{{$terminal->destination_id}}" data-route="{{$destination->destination_id}}"  @if($destination->tickets->where('type','Regular')->whereIn('ticket_id',$destination->selectedTickets->pluck('ticket_id'))->count() == 0 ) class="btn btn-flat" disabled @else class="btn btn-danger btn-flat" @endif><i class="fa fa-minus"> </i></button>
                                                                            </td>
                                                                            <td>
                                                                                <button name="ticketButton" data-terminal="{{$terminal->destination_id}}" data-route="{{$destination->destination_id}}" data-type="Discount" class="btn btn-warning btn-flat btn-dest">
                                                                                    {{$destination->destination_name}}
                                                                                    @if($discountedTicketNum = $destination->tickets->where('type','Discount')->whereIn('ticket_id',$destination->selectedTickets->pluck('ticket_id'))->count())
                                                                                        <span id="discountTicketPerDest{{$destination->destination_id}}" class="badge bg-yellow pull-right">
                                                                                            {{$discountedTicketNum}}
                                                                                        </span>
                                                                                    @endif
                                                                                </button>
                                                                                <button name="deleteLastSelectedTicket" data-type="Discount" data-terminal="{{$terminal->destination_id}}" data-route="{{$destination->destination_id}}" @if($destination->tickets->where('type','Discount')->whereIn('ticket_id',$destination->selectedTickets->pluck('ticket_id'))->count() == 0 ) class="btn btn-flat" disabled @else class="btn btn-danger btn-flat" @endif><i class="fa fa-minus"> </i></button>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <hr>
                                                
                                                <div class="pull-right">   
                                                <a href="{{route('transactions.manageTickets')}}" type="button" class="btn bg-maroon btn-flat" style="height: 50px;">SOLD TICKETS</a>
                                                @if($terminal->vanQueue()->whereNotNull('queue_number')->orderBy('queue_number')->first() ?? null)
                                                    <button id="boardPageBtn{{$terminal->destination_id}}" type="button" class="btn bg-navy btn-flat" style="height: 50px;">BOARD PASSENGERS</button>
                                                @else
                                                    <button type="button" class="btn bg-navy btn-flat" style="height: 50px;" data-toggle="modal" data-target="#novan-modal">BOARD PASSENGERS</button>
                                                @endif
                                                </div>

                                                <div class="clearfix">  </div>

                                                <div class="modal" id="novan-modal">
                                                  <div class="modal-dialog" style="margin-top: 10%;">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">×</span></button>
                                                        <h4 class="modal-title"></h4>
                                                      </div>
                                                      <div class="modal-body">
                                                        <h1 class="text-center"><i class="fa fa-warning"></i> OOPS!</h1>
                                                        <p class="text-center"><strong>UNABLE TO BOARD PASSENGERS. THERE'S NO VAN UNIT AVAILABLE IN THE QUEUE.</strong></p>
                                                      </div>
                                                      <div class="modal-footer">
                                                        <div class="text-center">
                                                            <a href="{{route('vanqueue.index')}}" type="button" class="btn btn-success">GO TO VAN QUEUE</a>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                  </div>
                                                  <!-- /.modal-dialog -->
                                                </div>
                                            </div>
                                        </div>
                                        @if($terminal->vanQueue->where('queue_number',1)->first() ?? null)
                                            <div id="boardTickets{{$terminal->destination_id}}">
                                            <div class="row">
                                                <div id="list-left1" class="dual-list list-left col-md-5">
                                                    <div class="box box-solid ticket-box">
                                                        <div id="ondeck-header{{$terminal->destination_id}}" class="box-header bg-blue">
                                                            <span class="col-md-6">
                                                                <h6>On Deck:</h6>
                                                                 <h4>{{$terminal->vanQueue->where('queue_number',1)->first()->plate_number}}</h4>
                                                            </span>
                                                             <span class="pull-right btn-group">
                                                                <button type="button" id="changeDriverBtn{{$terminal->destination_id}}" class="btn btn-sm btn-primary" style="border-radius: 100%">
                                                                    <i class="fa fa-user"></i>
                                                                </button>
                                                                <button type="button" id="deleteDriverBtn{{$terminal->destination_id}}" class="btn btn-sm btn-primary" style="border-radius: 100%">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                        <div id="changedriver-header{{$terminal->destination_id}}" class="box-header bg-blue hidden">
                                                            <span class="col-md-8">
                                                                <h6>Driver:</h6>
                                                                 <h4>
                                                                    <a href="#" class="text-white" id="driverChange{{$terminal->destination_id}}"></a>
                                                                    <i class='fa fa-pencil'></i>
                                                                </h4>
                                                            </span>
                                                             <span class="pull-right btn-group">
                                                                <button type="button" id="onDeckBtn1-{{$terminal->destination_id}}" class="btn btn-sm btn-primary" style="border-radius: 100%">
                                                                    <i class="fa fa-chevron-left"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                        <div id="deletedriver-header{{$terminal->destination_id}}" class="box-header bg-blue hidden">
                                                            <span class="col-md-12">
                                                                 <p>
                                                                     Are you sure you want to remove <strong>{{$terminal->vanQueue->where('queue_number',1)->first()->plate_number}}</strong> on deck?
                                                                 </p>
                                                            </span>
                                                             <span class="pull-right">
                                                                 <form method="POST" action="{{route('trips.destroy',[$terminal->vanQueue->where('queue_number',1)->first()->van_queue_id])}}">
                                                                     {{method_field('DELETE')}}
                                                                     {{csrf_field()}}
                                                                    <button type="button" id="onDeckBtn2-{{$terminal->destination_id}}" class="btn btn-sm btn-primary">
                                                                        NO
                                                                    </button>
                                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                                        YES
                                                                    </button>
                                                                 </form>
                                                            </span>
                                                        </div>

                                                        <div class="box-body well">
                                                            <div class="text-right">
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <div class="btn-group">
                                                                            <a name="checkBox{{$terminal->destination_id}}" class="checkBox btn btn-default selector" title="select all"><i class="glyphicon glyphicon-unchecked"></i></a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-10">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class=" glyphicon glyphicon-search"></i>
                                                                            </span>
                                                                            <input type="text" name="SearchDualList" class="form-control" placeholder="search" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="">
                                                                <ul id="onBoardList{{$terminal->destination_id}}" class="list-group scrollbar scrollbar-info thin ticket-overflow">
                                                                    @foreach($transactions->where('destination',$terminal->destination_name)->where('status','OnBoard') as $transaction)
                                                                        <li data-val="{{$transaction->transaction_id}}" class="list-group-item">{{$transaction->ticket->ticket_number}}</li>
                                                                    @endforeach
                                                                </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="list-arrows col-md-2 text-center">
                                                    <button data-terminal="{{$terminal->destination_id}}" name="board" class="btn btn-outline-primary btn-sm btn-flat move-left1">
                                                        <i class="glyphicon glyphicon-chevron-left"></i>  BOARD
                                                    </button>
                                                    <br>
                                                    <button data-terminal="{{$terminal->destination_id}}" name="unboard" class="btn btn-outline-warning btn-sm btn-flat move-right1">
                                                         UNBOARD <i class="glyphicon glyphicon-chevron-right"></i>
                                                    </button>
                                                </div>

                                                <div id="list-right1" class="dual-list list-right col-md-5">
                                                    <div class="box box-solid ticket-box">
                                                        <div class="box-header bg-yellow bg-gray">
                                                            <span class="">
                                                                <h6>Sold Tickets for</h6>
                                                                 <h4>{{$terminal->description}}</h4>
                                                            </span>
                                                        </div>
                                                        <div class="box-body well">
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <div class="btn-group">
                                                                            <a name="checkBox{{$terminal->destination_id}}" class="checkBox btn btn-default selector" title="select all"><i class="glyphicon glyphicon-unchecked"></i></a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-10">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <i class="glyphicon glyphicon-search"></i>
                                                                            </span>
                                                                            <input type="text" name="SearchDualList" class="form-control" placeholder="search" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <ul id="pendingList{{$terminal->destination_id}}" class="list-group scrollbar scrollbar-info thin ticket-overflow">
                                                                    @foreach($transactions->whereIn('destination',$terminal->routeFromDestination->pluck('destination_name'))->where('status','Pending') as $transaction)
                                                                        <li data-val='{{$transaction->transaction_id}}' class="list-group-item">{{$transaction->ticket->ticket_number}}</li>
                                                                    @endforeach
                                                                </ul>
                                                                
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <hr>
                                                <button id="sellPageBtn{{$terminal->destination_id}}" class="btn btn-default btn-flat" style="height: 50px;"><i class="fa fa-angle-double-left"></i> BACK</button>
                                                <button name="depart" class="btn bg-navy btn-flat pull-right"  data-val="{{$terminal->destination_id}}" style="height: 50px;"><i class="fa fa-automobile"></i> DEPART</button>
                                            </div>

                                            <div class="modal" id="ob-modal">
                                                  <div class="modal-dialog" style="margin-top: 10%;">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">×</span></button>
                                                        <h4 class="modal-title"></h4>
                                                      </div>
                                                      <div class="modal-body">
                                                        <h1 class="text-center text-aqua"><i class="fa fa-exclamation-circle"></i> CONFIRMATION</h1>
                                                        <p class="text-center">THE VAN UNIT HAS <strong class="text-red">LESS THAN 10</strong> PASSENGERS, UPON DEPARTURE THE VAN UNIT WILL BE MARKED AS <strong class="text-green">OB</strong> AND WILL BE LISTED IN THE QUEUE IMMEDIATELY. <strong>DO YOU STILL WANT TO DEPART?</strong></p>
                                                      </div>
                                                      <div class="modal-footer">
                                                        <div class="text-center">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                                                            <button name="departOb" data-val="{{$terminal->destination_id}}" type="submit" class="btn bg-navy">DEPART</button>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                  </div>
                                                  <!-- /.modal-dialog -->
                                                </div>
                                        </div>
                                        @endif
                                    </div>

                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="terminal-side">
                            <h4><i class="fa fa-map-marker text-red"></i> TERMINAL</h4>
                            <div class="nav-terminal  scrollbar scrollbar-info thin">
                            <ul class="nav nav-stacked ">
                                @foreach($terminals as $terminal)
                                    @if($terminal->vanQueue->where('queue_number',1)->first() ?? null)
                                        <li class="@if($terminals->first() == $terminal){{'active'}}@endif"><a href="#terminal{{$terminal->destination_id}}" data-toggle="tab">{{$terminal->destination_name}}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-7">
        <div class="box box-solid">
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">

                        @foreach($terminals as $terminal)
                            @if($terminal->vanQueue->where('queue_number',1)->first()->plate_number ?? null)
                                <li class="@if($terminals->first() == $terminal){{'active'}}@endif"><a href="#terminal{{$terminal->destination_id}}" data-toggle="tab">{{$terminal->description}}</a></li>
                            @endif
                        @endforeach

                    </ul>

                    <div class="tab-content">
                        @foreach($terminals as $terminal)
                            @if($terminal->vanQueue->where('queue_number',1)->first()->plate_number ?? null)
                        <div class="tab-pane @if($terminals->first() == $terminal){{'active'}}@endif" id="terminal{{$terminal->destination_id}}">
                            <div id="sellTicketss{{$terminal->destination_id}}" class="row">
                                <div id="list-left1" class="dual-list list-left col-md-5">
                                    <div class="box box-solid ticket-box">
                                        <div id="ondeck-header{{$terminal->destination_id}}" class="box-header bg-blue">
                                            <span class="col-md-6">
                                                <h6>On Deck:</h6>
                                                 <h4>{{$terminal->vanQueue->where('queue_number',1)->first()->plate_number}}</h4>
                                            </span>
                                             <span class="pull-right btn-group">
                                                <button type="button" id="changeDriverBtn{{$terminal->destination_id}}" class="btn btn-sm btn-primary" style="border-radius: 100%">
                                                    <i class="fa fa-user"></i>
                                                </button>
                                                <button type="button" id="deleteDriverBtn{{$terminal->destination_id}}" class="btn btn-sm btn-primary" style="border-radius: 100%">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </span>
                                        </div>
                                        <div id="changedriver-header{{$terminal->destination_id}}" class="box-header bg-blue hidden">
                                            <span class="col-md-8">
                                                <h6>Driver:</h6>
                                                 <h4>
                                                    <a href="#" class="text-white" id="driverChange{{$terminal->destination_id}}"></a>
                                                    <i class='fa fa-pencil'></i>
                                                </h4>
                                            </span>
                                             <span class="pull-right btn-group">
                                                <button type="button" id="onDeckBtn1-{{$terminal->destination_id}}" class="btn btn-sm btn-primary" style="border-radius: 100%">
                                                    <i class="fa fa-chevron-left"></i>
                                                </button>
                                            </span>
                                        </div>
                                        <div id="deletedriver-header{{$terminal->destination_id}}" class="box-header bg-blue hidden">
                                            <span class="col-md-12">
                                                 <p>
                                                     Are you sure you want to remove <strong>{{$terminal->vanQueue->where('queue_number',1)->first()->plate_number}}</strong> on deck?
                                                 </p>
                                            </span>
                                             <span class="pull-right">
                                                 <form method="POST" action="{{route('trips.destroy',[$terminal->vanQueue->where('queue_number',1)->first()->van_queue_id])}}">
                                                     {{method_field('DELETE')}}
                                                     {{csrf_field()}}
                                                    <button type="button" id="onDeckBtn2-{{$terminal->destination_id}}" class="btn btn-sm btn-primary">
                                                        NO
                                                    </button>
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        YES
                                                    </button>
                                                 </form>
                                            </span>
                                        </div>

                                        <div class="box-body well">
                                            <div class="text-right">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="btn-group">
                                                            <a name ="checkBox{{$terminal->destination_id}}" class="checkBox btn btn-default selector" title="select all"><i class="glyphicon glyphicon-unchecked"></i></a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class=" glyphicon glyphicon-search"></i>
                                                            </span>
                                                            <input type="text" name="SearchDualList" class="form-control" placeholder="search" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="">
                                                <ul id="onBoardList{{$terminal->destination_id}}" class="list-group scrollbar scrollbar-info thin ticket-overflow">
                                                    @foreach($terminal->transactions->where('status','OnBoard') as $transaction)
                                                        <li data-val="{{$transaction->transaction_id}}" class="list-group-item">{{$transaction->ticket->ticket_number}}</li>
                                                    @endforeach
                                                </ul>
                                                </div>
                                            </div>
                                            <div class="text-center ">
                                                <button name="depart" value="{{$terminal->destination_id}}" href="" class="btn btn-primary btn-flat">Depart <i class="fa fa-automobile"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="list-arrows col-md-2 text-center">
                                    <button id="board{{$terminal->destination_id}}" class="btn btn-outline-primary btn-sm btn-flat move-left1">
                                        <i class="glyphicon glyphicon-chevron-left"></i>  BOARD
                                    </button>
                                    <br>
                                    <button id="unboard{{$terminal->destination_id}}" class="btn btn-outline-warning btn-sm btn-flat move-right1">
                                         UNBOARD <i class="glyphicon glyphicon-chevron-right"></i>
                                    </button>
                                </div>

                                <div id="list-right1" class="dual-list list-right col-md-5">
                                    <div class="box box-solid ticket-box">
                                        <div class="box-header bg-yellow bg-gray">
                                            <span class="">
                                                <h6>Sold Tickets for</h6>
                                                 <h4>{{$terminal->description}}</h4>
                                            </span>
                                        </div>
                                        <div class="box-body well">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="btn-group">
                                                            <a name="checkBox{{$terminal->destination_id}}" class="checkBox btn btn-default selector" title="select all"><i class="glyphicon glyphicon-unchecked"></i></a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="glyphicon glyphicon-search"></i>
                                                            </span>
                                                            <input type="text" name="SearchDualList" class="form-control" placeholder="search" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <ul id="pendingList{{$terminal->destination_id}}" class="list-group scrollbar scrollbar-info thin ticket-overflow">
                                                    @foreach($terminal->transactions->where('status','Pending') as $transaction)
                                                        <li data-val='{{$transaction->transaction_id}}' class="list-group-item">{{$transaction->ticket->ticket_number}}</li>
                                                    @endforeach
                                                </ul>
                                                
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                            @endif
                            @endforeach
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
    $(function(){
        $('.select2').select2();
     var activeTab = document.location.hash;
    if(!activeTab){

            activeTab = @if($terminals->first()->destination_id ?? null)
                "{{'#terminal'.$terminals->first()->destination_id}}";
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

</script>

{{--Selecting and Unselecting Tickets--}}
<script>
    $(function(){
        //Select Tickets
        $('button[name="ticketButton"]').on('click',function(){
            var destinationId = $(this).data('route');
            var terminalId = $(this).data('terminal');
            var ticketType = $(this).data('type');
            var buttonElement = $(this);
            $.ajax({
                method:'POST',
                url: '/selectTicket/'+destinationId,
                data: {
                    '_token': '{{csrf_token()}}',
                    'ticketType': ticketType
                },
                success: function(element){

                    var ticketNumber = '<tr><td><button type="button" class="btn btn-block btn-xs edit btn-primary">'+element.ticketNumber+'</button></td>';
                    var fare = '<td class="pull-right">'+element.fare+'</td>';
                    var deleteButt = '<td class="text-right"><button name="deleteSpecificSelectedTicket" class="btn btn-xs" data-val="'+element.selectedId+'"><i class="fa fa-trash"></i></button></td></tr>';
                    $('#selectedList'+terminalId).append(ticketNumber+fare+deleteButt);

                    //Update the necessary information
                    if(ticketType == 'Regular') {
                        //Change The number of clicks (Regular)
                        if($('#regularTicketPerDest'+destinationId).text()) {
                            $('#regularTicketPerDest'+destinationId).text(parseFloat($('#regularTicketPerDest'+destinationId).text())+1);

                        } else {
                            buttonElement.append('<span id="regularTicketPerDest'+destinationId+'" class="badge bg-yellow pull-right">1</span>');
                            buttonElement.parents('td').children('button[name="deleteLastSelectedTicket"]').prop('disabled',false).addClass('btn-danger');
                        }

                        //Change the total payment (Regular)
                        var total = parseFloat($('#regularTotalPayment'+terminalId).text().substring(2))+parseFloat(element.fare);
                        $('#regularTotalPayment'+terminalId).text("₱ "+total.toFixed(2));

                        //Change the total number of regular tickets
                        $('#totalRegularTicket'+terminalId).text(parseFloat($('#totalRegularTicket'+terminalId).text())+1);
                        $('#totalRegularTicket'+terminalId).append(' <i class="fa fa-ticket"></i>');

                    } else {
                        //Change The number of clicks (Discounted)
                        if($('#discountTicketPerDest'+destinationId).text()) {
                            $('#discountTicketPerDest'+destinationId).text(parseFloat($('#discountTicketPerDest'+destinationId).text())+1);

                        } else {
                            buttonElement.append('<span id="discountTicketPerDest'+destinationId+'" class="badge bg-blue pull-right">1</span>');
                            buttonElement.parents('td').children('button[name="deleteLastSelectedTicket"]').prop('disabled',false).addClass('btn-danger');
                        }

                        //Change the total payment (Discount)
                        var total = parseFloat($('#discountedTotalPayment'+terminalId).text().substring(2))+parseFloat(element.fare);
                        $('#discountedTotalPayment'+terminalId).text("₱ "+total.toFixed(2));

                        //Change the number of discount tickets
                        $('#totalDiscountedTicket'+terminalId).text(parseFloat($('#totalDiscountedTicket'+terminalId).text())+1);
                        $('#totalDiscountedTicket'+terminalId).append(' <i class="fa fa-ticket"></i>');
                    }

                    //Change the total number of overall tickets
                    $('#totalTickets'+terminalId).text(parseFloat($('#totalTickets'+terminalId).text())+1);
                    $('#totalTickets'+terminalId).append(' <i class="fa fa-ticket"></i>');

                    //Change the overall payment
                    var overall = parseFloat($('#totalPayment'+terminalId).text().substring(2))+parseFloat(element.fare);
                    $('#totalPayment'+terminalId).empty();
                    $('#totalPayment'+terminalId).append('<strong></strong>');
                    $('#totalPayment'+terminalId).children('strong').text("₱ "+overall.toFixed(2));

                }

            });
        });

        //Delete a Specific Selected Ticket
        $(document).on('click','button[name="deleteSpecificSelectedTicket"]',function(){
            var element = $(this);
            var selectedTicketId = $(this).data('val');

            $.ajax({
                method:'DELETE',
                url: '/selectTicket/'+selectedTicketId,
                data: {
                    '_token': '{{csrf_token()}}'
                },
                success: function(response){
                    element.closest('tr').remove();
                    updateDataOfDeletedTicket(response.destinationId,response.terminalId,response.ticketType,response.fare);
                }

            });
        });

        //Delete the Last Ticket of a Destination
        $('button[name="deleteLastSelectedTicket"]').on('click',function(){
            var destinationId = $(this).data('route');
            var terminalId = $(this).data('terminal');
            var ticketType = $(this).data('type');

            $.ajax({
                method:'DELETE',
                url: '/selectedLastTicket/'+destinationId,
                data: {
                    '_token': '{{csrf_token()}}',
                    'ticketType': ticketType
                },
                success: function(response){
                    $('#selectedList'+terminalId).find('[data-val="' + response.lastSelected + '"]').closest('tr').remove();
                    updateDataOfDeletedTicket(destinationId,terminalId,ticketType,response.fare);
                }

            });
        });

        function updateDataOfDeletedTicket(destinationId,terminalId,ticketType,fare) {
            var error = true;
            //Update the necessary information
            if(ticketType == 'Regular') {
                //Change The number of clicks (Regular)
                if(parseFloat($('#regularTicketPerDest'+destinationId).text()) > 0) {
                    if(parseFloat($('#regularTicketPerDest'+destinationId).text()) === 1) {
                        $('#regularTicketPerDest'+destinationId).parents('td').children().closest('button[name="deleteLastSelectedTicket"]').removeClass('btn-danger').prop('disabled',true);
                        $('#regularTicketPerDest'+destinationId).remove();
                    } else {
                        $('#regularTicketPerDest'+destinationId).text(parseFloat($('#regularTicketPerDest'+destinationId).text())-1);
                    }


                    //Change the total payment (Regular)
                    var total = parseFloat($('#regularTotalPayment'+terminalId).text().substring(2))-parseFloat(fare);
                    $('#regularTotalPayment'+terminalId).text("₱ "+total.toFixed(2));

                    //Change the total number of regular tickets
                    $('#totalRegularTicket'+terminalId).text(parseFloat($('#totalRegularTicket'+terminalId).text())-1);
                    $('#totalRegularTicket'+terminalId).append(' <i class="fa fa-ticket"></i>');
                }

                error = false;
            } else {
                //Change The number of clicks (Discounted)
                if(parseFloat($('#discountTicketPerDest'+destinationId).text()) > 0) {

                    if(parseFloat($('#discountTicketPerDest'+destinationId).text()) === 1) {
                        $('#discountTicketPerDest'+destinationId).parents('td').children().closest('button[name="deleteLastSelectedTicket"]').removeClass('btn-danger').prop('disabled',true);
                        $('#discountTicketPerDest'+destinationId).remove();
                    } else {
                        $('#discountTicketPerDest'+destinationId).text(parseFloat($('#discountTicketPerDest'+destinationId).text())-1);
                    }


                    //Change the total payment (Discount)
                    var total = parseFloat($('#discountedTotalPayment'+terminalId).text().substring(2))-parseFloat(fare);
                    $('#discountedTotalPayment'+terminalId).text("₱ "+total.toFixed(2));

                    //Change the number of discount tickets
                    $('#totalDiscountedTicket'+terminalId).text(parseFloat($('#totalDiscountedTicket'+terminalId).text())-1);
                    $('#totalDiscountedTicket'+terminalId).append(' <i class="fa fa-ticket"></i>');

                    error = false;
                }
            }

            if(error === false) {
                //Change the total number of overall tickets
                $('#totalTickets'+terminalId).text(parseFloat($('#totalTickets'+terminalId).text())-1);
                $('#totalTickets'+terminalId).append(' <i class="fa fa-ticket"></i>');

                //Change the overall payment
                var overall = parseFloat($('#totalPayment'+terminalId).text().substring(2))-parseFloat(fare);
                $('#totalPayment'+terminalId).empty();
                $('#totalPayment'+terminalId).append('<strong></strong>');
                $('#totalPayment'+terminalId).children('strong').text("₱ "+overall.toFixed(2));
            }

        }
    });

    //Remove a ticket by Destination
</script>

{{--Boarding, Unboarding, and Departure--}}
<script type="text/javascript">
        $(function () {
            //Depart the ticket
            $('button[name="depart"]').on('click', function(){
                var terminalId = $(this).data('val');

                if($('#onBoardList'+terminalId).children().length > 0){
                    var transactions = [];
                    $('#onBoardList'+terminalId+' li').each(function(){
                        transactions.push($(this).data('val'));
                    });
                    if(transactions.length >= 10) {
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
                    } else {
                        $('#ob-modal').modal('show');
                    }

                }
            });

            //Depart the ticket/s and add the van to the queue and mark it as OB
            $('button[name="departOb"]').on('click',function(){
               var terminalId  = $(this).data('val');
               var transactions = [];

                $('#onBoardList'+terminalId+' li').each(function(){
                    transactions.push($(this).data('val'));
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
            });

            $('body').on('click', '.list-group .list-group-item', function () {
                $(this).toggleClass('active');
            });

            $('button[name="board"]').on('click', function () {
                var terminalId = $(this).data('terminal');

                var actives = $('#pendingList'+terminalId).children('.active');
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

                    actives.clone().appendTo('#onBoardList'+terminalId).removeClass('active');
                    actives.remove();

                    var checkBox = $('a[name="checkBox'+terminalId+'"]');

                    if (checkBox.hasClass('selected') && checkBox.children('i').hasClass('glyphicon-check')) {
                        checkBox.removeClass('selected');
                        checkBox.children('i').removeClass('glyphicon-check').addClass('glyphicon-unchecked');
                    }

                }
            });

            $('button[name="unboard"]').on('click',function() {
                var terminalId = $(this).data('terminal');
                var actives = $('#onBoardList'+terminalId).children('.active');

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


                    actives.clone().appendTo('#pendingList'+terminalId).removeClass('active');
                    actives.remove();

                    var checkBox = $('a[name="checkBox'+terminalId+'"]');

                    if (checkBox.hasClass('selected') && checkBox.children('i').hasClass('glyphicon-check')) {
                        checkBox.removeClass('selected');
                        checkBox.children('i').removeClass('glyphicon-check').addClass('glyphicon-unchecked');
                    }
                }
            });

            $('.checkBox').on('click',function() {
                var checkBox = $(this);
                if (!checkBox.hasClass('selected')) {
                    checkBox.addClass('selected').closest('.well').find('ul li:not(.active)').addClass('active');
                    checkBox.children('i').removeClass('glyphicon-unchecked').addClass('glyphicon-check');
                } else {
                    checkBox.removeClass('selected').closest('.well').find('ul li.active').removeClass('active');
                    checkBox.children('i').removeClass('glyphicon-check').addClass('glyphicon-unchecked');
                }
            });

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


{{--hide and showing--}}
@foreach($terminals as $terminal)
<script>
     $(function(){
        $("#changedriver-header{{$terminal->destination_id}}").hide();
        $("#deletedriver-header{{$terminal->destination_id}}").hide();
        $("#changeDriverBtn{{$terminal->destination_id}}").click(function(){
            $("#ondeck-header{{$terminal->destination_id}}").hide();
            $("#changedriver-header{{$terminal->destination_id}}").show()
            $("#changedriver-header{{$terminal->destination_id}}").removeClass("hidden");
        });
        $("#deleteDriverBtn{{$terminal->destination_id}}").click(function(){
            $("#ondeck-header{{$terminal->destination_id}}").hide();
            $("#deletedriver-header{{$terminal->destination_id}}").show()
            $("#deletedriver-header{{$terminal->destination_id}}").removeClass("hidden");
        });
        $("#onDeckBtn1-{{$terminal->destination_id}}").click(function(){
            $("#changedriver-header{{$terminal->destination_id}}").hide();
            $("#ondeck-header{{$terminal->destination_id}}").show();
        });
        $("#onDeckBtn2-{{$terminal->destination_id}}").click(function(){
            $("#deletedriver-header{{$terminal->destination_id}}").hide();
            $("#ondeck-header{{$terminal->destination_id}}").show();
        });
      });
</script>
<script>
    $(function(){
        $("#boardTickets{{$terminal->destination_id}}").hide();
        $("#boardPageBtn{{$terminal->destination_id}}").click(function(){
            $("#sellTickets{{$terminal->destination_id}}").hide();
            $("#boardTickets{{$terminal->destination_id}}").show();
        });
        $("#sellPageBtn{{$terminal->destination_id}}").click(function(){
            $("#sellTickets{{$terminal->destination_id}}").show();
            $("#boardTickets{{$terminal->destination_id}}").hide();
        });
    });
</script>
@endforeach



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
        @if($trip = $terminal->vanQueue->where('queue_number',1)->first())
            $('#driverChange{{$terminal->destination_id}}').editable({
                type: 'select',
                title: 'Change Driver',
                value: "{{$terminal->vanQueue->where('queue_number',1)->first()->driver_id}}",
                source: "{{route('transactions.listSourceDrivers')}}",
                sourceCache: true,
                pk: '{{$terminal->vanQueue->where('queue_number',1)->first()->van_queue_id}}',
                url: '{{route('transactions.changeDriver',[$trip->van_queue_id])}}',
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
    });
</script>

<script>
function myFunction() {
    // Declare variables
    var input, filter, ul, li, a, i;
    input = document.getElementById('myInput');
    filter = input.value.toUpperCase();
    table = document.getElementById("destination-table");
    tr = table.getElementsByTagName('tr');

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        btn = tr[i].getElementsByTagName("button")[0];
        if (btn.innerHTML.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
}
</script>
@endsection
