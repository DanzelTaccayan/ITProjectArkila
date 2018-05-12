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
                                    @if($terminal->vanQueue->where('queue_number',1)->first() ?? null)
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
                                                                        <td id="totalRegTicket{{$terminal->destination_id}}" class="text-right">{{App\Ticket::showAllSelectedTickets($terminal->routeFromDestination->pluck('destination_id'))->where('type','Regular')->get()->count()}} <i class="fa fa-ticket"></i></td>
                                                                        <td class="text-right">₱ {{App\Ticket::showAllSelectedTickets($terminal->routeFromDestination->pluck('destination_id'))->where('type','Regular')->get()->pluck('fare')->sum()}}</td>
                                                                    </tr>
                                                                    <tr class="info">
                                                                        <td>Discounted</td>
                                                                        <td class="text-right">{{App\Ticket::showAllSelectedTickets($terminal->routeFromDestination->pluck('destination_id'))->where('type','Discount')->get()->count()}} <i class="fa fa-ticket"></i></td>
                                                                        <td class="text-right">₱ {{App\Ticket::showAllSelectedTickets($terminal->routeFromDestination->pluck('destination_id'))->where('type','Discount')->get()->pluck('fare')->sum()}}</td>
                                                                    </tr>
                                                                    <tr class="success">
                                                                        <td><strong>Total</strong></td>
                                                                        <td class="text-right">{{App\Ticket::showAllSelectedTickets($terminal->routeFromDestination->pluck('destination_id'))->get()->count()}} <i class="fa fa-ticket"></i></td>
                                                                        <td class="text-right"><strong>₱ {{App\Ticket::showAllSelectedTickets($terminal->routeFromDestination->pluck('destination_id'))->get()->pluck('fare')->sum()}}</strong></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="pull-right">
                                                            <button type="button" class="btn btn-success btn-flat" data-toggle="modal" data-target="#modal-default">SELL</button>
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
                                                                            <td>
                                                                                <button name="ticketButton" data-terminal="{{$terminal->destination_id}}" data-route="{{$destination->destination_id}}" data-type="Regular" class="btn btn-primary btn-flat btn-dest">
                                                                                    {{$destination->destination_name}}
                                                                                    @if($regTicketNum =  $destination->selectedTickets->where('type','Regular')->count())
                                                                                        <span class="badge bg-yellow pull-right">
                                                                                            {{$regTicketNum}}
                                                                                        </span>
                                                                                    @endif
                                                                                </button>
                                                                                <button name="deleteLastSelectedTicket" data-type="Regular" data-terminal="{{$terminal->destination_id}}" data-route="{{$destination->destination_id}}" class="btn btn-flat" disabled><i class="fa fa-trash"> </i></button>
                                                                            </td>
                                                                            <td>
                                                                                <button name="ticketButton" data-terminal="{{$terminal->destination_id}}" data-route="{{$destination->destination_id}}" data-type="Discount" class="btn btn-warning btn-flat btn-dest">
                                                                                    {{$destination->destination_name}}
                                                                                    @if($discountedTicketNum = $destination->selectedTickets->where('type','Discount')->count())
                                                                                        <span class="badge bg-yellow pull-right">
                                                                                            {{$discountedTicketNum}}
                                                                                        </span>
                                                                                    @endif
                                                                                </button>
                                                                                <button name="deleteLastSelectedTicket" data-type="Discount" data-terminal="{{$terminal->destination_id}}" data-route="{{$destination->destination_id}}" class="btn btn-danger btn-flat"><i class="fa fa-trash"> </i></button>
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
                                                <button id="boardPageBtn{{$terminal->destination_id}}" type="button" class="btn bg-maroon btn-flat" style="height: 50px;">SOLD TICKETS</button> 
                                                <button id="boardPageBtn{{$terminal->destination_id}}" type="button" class="btn bg-navy btn-flat" style="height: 50px;">BOARD PASSENGERS</button>
                                                </div>
                                                <div class="clearfix">  </div>
                                            </div>
                                        </div>
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
                                                                            <a class="checkBox{{$terminal->destination_id}} btn btn-default selector" title="select all"><i class="glyphicon glyphicon-unchecked"></i></a>
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
                                                                            <a class="checkBox{{$terminal->destination_id}} btn btn-default selector" title="select all"><i class="glyphicon glyphicon-unchecked"></i></a>
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
                                                                    @foreach($transactions->where('destination',$terminal->destination_name)->where('status','Pending') as $transaction)
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
                                                <button class="btn bg-navy btn-flat pull-right"  value="{{$terminal->destination_id}}" style="height: 50px;"><i class="fa fa-automobile"></i> DEPART</button>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
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
                                                            <a class="checkBox{{$terminal->destination_id}} btn btn-default selector" title="select all"><i class="glyphicon glyphicon-unchecked"></i></a>
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
                                                            <a class="checkBox{{$terminal->destination_id}} btn btn-default selector" title="select all"><i class="glyphicon glyphicon-unchecked"></i></a>
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

{{--Selecting Tickets--}}
<script>
    $(function(){
        //Select Tickets
        $('button[name="ticketButton"]').on('click',function(){
            var destinationId = $(this).data('route');
            var terminalId = $(this).data('terminal');
            var ticketType = $(this).data('type');
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
                    var deleteButt = '<td class="text-center text-red"><i class="fa fa-trash"></i></td></tr>';
                    $('#selectedList'+terminalId).append(ticketNumber+fare+deleteButt);

                }

            });
        });

        //Delete a Specific Selected Ticket
        $('button[name="deleteSpecificSelectedTicket"]').on('click',function(){
            var element = $(this);
            var selectedTicketId = $(this).data('val');

            $.ajax({
                method:'DELETE',
                url: '/selectTicket/'+selectedTicketId,
                data: {
                    '_token': '{{csrf_token()}}'
                },
                success: function(){
                    element.closest('tr').remove();
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
                success: function(lastSelected){
                    $('#selectedList'+terminalId).find('[data-val="' + lastSelected + '"]').closest('tr').remove();

                }

            });
        });
    });
</script>

{{--Boarding and Unboarding and Departure--}}
<script type="text/javascript">
        $(function () {
            //Put Ticket into Pending

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
