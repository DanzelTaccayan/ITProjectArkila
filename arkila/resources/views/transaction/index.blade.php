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

    @if(count($terminals) === 0)
        <div class="padding-side-10">
            <div class="box box-solid" style="height: 300px; padding: 50px;">
                <div class="box-body">
                    <div class="text-center">
                    <h1><i class="fa fa-warning text-red"></i> NO TERMINAL/DESTINATION FOUND</h1>
                    <h4>CREATE A TERMINAL/DESTINATION FIRST BEFORE YOU CAN SELL TICKETS</h4>
                    <a href="{{route('terminalCreate.create')}}" type="button" class="btn btn-success btn-flat btn-lg">CREATE TERMINAL</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="box box-solid">
            <div class="box-body" style="background: #ebbea86e;">
                <div class="row">
                    <div class="col-md-9">
                        <div class="nav-tabs-custom">
                            <div class="tab-content">
                                @foreach($terminals as $terminal)

                                    <div data-terminal="{{$terminal->destination_id}}" class="tab-pane" id="terminal{{$terminal->destination_id}}">
                                        <div id="sellTickets{{$terminal->destination_id}}">

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="well">
                                                        <div>
                                                            <label for="">Customer</label>
                                                            <select class="form-control select2" data-terminal="{{$terminal->destination_id}}" name="customer">
                                                                <option value="walkIn">Walk-in Customer</option>
                                                                @foreach($reservations as $reservation)
                                                                <option value="{{$reservation->id}}">{{$reservation->rsrv_code}}</option>
                                                                @endforeach
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
                                                                                @if($ticket->type == "Regular")
                                                                                    <button type="button" class="btn btn-block btn-xs edit btn-primary">{{$ticket->ticket_number}}</button>
                                                                                @elseif($ticket->type == "Discount")
                                                                                    <button type="button" class="btn btn-block btn-xs edit btn-warning">{{$ticket->ticket_number}}</button>
                                                                                @endif
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
                                                            <button name="buttonSell" class="btn btn-success btn-flat" data-toggle="modal" data-terminal="{{$terminal->destination_id}}">SELL</button>                    
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
                                                                                        <span id="regularTicketPerDest{{$destination->destination_id}}" class="badge pull-right">
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
                                                                                        <span id="discountTicketPerDest{{$destination->destination_id}}" class="badge  pull-right">
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
                                                <a href="{{route('transactions.manageTickets')}}" type="button" class="btn bg-maroon btn-flat" style="height: 50px; padding-top: 13px;">SOLD TICKETS</a>
                                                @if($terminal->vanQueue()->whereNotNull('queue_number')->whereNull('remarks')->where('queue_number',1)->first() ?? null)
                                                    <button name="boardPageBtn" data-terminal="{{$terminal->destination_id}}" type="button" class="btn bg-navy btn-flat" style="height: 50px;">BOARD PASSENGERS</button>
                                                @elseif ($vanOnQueue = $terminal->vanQueue()->where('queue_number',1)->where('remarks','OB')->orderBy('queue_number')->first() ?? null)
                                                        <button type="button" class="btn bg-navy btn-flat" style="height: 50px;" data-toggle="modal" data-target="#ondeckOB-modal{{$vanOnQueue->van_queue_id}}">BOARD PASSENGERS</button>

                                                        <div class="modal" id="ondeckOB-modal{{$vanOnQueue->van_queue_id}}">
                                                            <div class="modal-dialog" style="margin-top: 10%;">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">×</span></button>
                                                                        <h4 class="modal-title"></h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <h1 class="text-center text-aqua"><i class="fa fa-exclamation-circle"></i> CONFIRMATION</h1>
                                                                        <p class="text-center"><strong class="text-blue" style="font-size: 20px">{{$vanOnQueue->van->plate_number}}</strong> IS ON DECK AND HAS A REMARK OF <strong class="text-green" style="font-size: 20px">OB</strong>. WILL IT REMAIN ON DECK?</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <div class="text-center">
                                                                            <button data-van="{{$vanOnQueue->van_queue_id}}" name="moveToSpecialUnits" type="button" class="btn btn-default"><i class="text-yellow fa fa-star"></i> MOVE TO SPECIAL UNITS</button>
                                                                            <button data-van="{{$vanOnQueue->van_queue_id}}" name="remainOnDeck" type="button" class="btn btn-primary ">REMAIN ON DECK</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- /.modal-content -->
                                                            </div>
                                                            <!-- /.modal-dialog -->
                                                        </div>
                                                @elseif($vanOnQueue = $terminal->vanQueue()->where('queue_number',1)->where('remarks','ER')->orWhere('remarks','CC')->orderBy('queue_number')->first() ?? null)
                                                        <button type="button" class="btn bg-navy btn-flat" style="height: 50px;" data-toggle="modal" data-target="#ondeckERCC-modal{{$vanOnQueue->van_queue_id}}">BOARD PASSENGERS</button>

                                                        <div class="modal" id="ondeckERCC-modal{{$vanOnQueue->van_queue_id}}">
                                                            <div class="modal-dialog" style="margin-top: 10%;">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">×</span></button>
                                                                        <h4 class="modal-title"></h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <h1 class="text-center text-aqua"><i class="fa fa-exclamation-circle"></i> CONFIRMATION</h1>
                                                                        <p class="text-center"><strong class="text-blue" style="font-size: 20px">{{$vanOnQueue->van->plate_number}}</strong> IS ON DECK AND HAS A REMARK OF <strong class="text-green" style="font-size: 20px">{{$vanOnQueue->remarks}}</strong>. THEREFORE IT CANNOT DEPART AND MUST BE MOVED TO THE SPECIAL UNITS</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <div class="text-center">
                                                                            <button data-van="{{$vanOnQueue->van_queue_id}}" name="moveToSpecialUnits" type="button" class="btn btn-default"><i class="text-yellow fa fa-star"></i> MOVE TO SPECIAL UNITS</button>
                                                                            <button data-van="{{$vanOnQueue->van_queue_id}}" name="remainOnDeck" type="button" class="btn btn-primary ">REMAIN ON DECK</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- /.modal-content -->
                                                            </div>
                                                            <!-- /.modal-dialog -->
                                                        </div>
                                                @else
                                                        <button type="button" class="btn bg-navy btn-flat" style="height: 50px;" data-toggle="modal" data-target="#novan-modal">BOARD PASSENGERS</button>
                                                @endif
                                                </div>

                                                <div class="clearfix"></div>


                                            </div>
                                        </div>
                                        @if($vanOnDeck = $terminal->vanQueue->where('queue_number',1)->first() ?? null)
                                            <div id="boardTickets{{$terminal->destination_id}}" name="boardTickets">
                                            <div class="row">
                                                <div id="list-right" class="dual-list list-right col-md-5">
                                                    <div class="box box-solid ticket-box">
                                                        <div class="box-header bg-yellow bg-gray">
                                                            <span class="">
                                                                <h6>Sold Tickets for</h6>
                                                                 <h4>{{$terminal->destination_name}}</h4>
                                                            </span>
                                                        </div>
                                                        <div class="box-body well">
                                                            <div  class="text-right">
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
                                                                <ul id="pendingList{{$terminal->destination_id}}" class="pendingList list-group scrollbar scrollbar-info thin ticket-overflow">
                                                                    @foreach($soldTickets->whereIn('destination_id',$terminal->routeFromDestination->pluck('destination_id'))->where('status','Pending') as $soldTicket)
                                                                        <li data-val='{{$soldTicket->sold_ticket_id}}' class="list-group-item">{{$soldTicket->ticket_number}}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>   
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="list-arrows col-md-2 text-center">
                                                    <button data-terminal="{{$terminal->destination_id}}" name="board" class="btn btn-outline-primary btn-sm btn-flat move-right">
                                                        BOARD <i class="glyphicon glyphicon-chevron-right"></i>
                                                    </button>
                                                    <br>
                                                    <button data-terminal="{{$terminal->destination_id}}" name="unboard" class="btn btn-outline-warning btn-sm btn-flat move-left">
                                                        <i class="glyphicon glyphicon-chevron-left"></i> UNBOARD 
                                                    </button>
                                                </div>

                                                <div id="list-left" class="dual-list list-left col-md-5">
                                                    <div class="box box-solid ticket-box">
                                                        <div id="ondeck-header{{$terminal->destination_id}}" class="box-header bg-blue">
                                                            <span class="col-md-6">
                                                                <h6>On Deck:</h6>
                                                                 <h4>{{$vanOnDeck->van->plate_number}}</h4>
                                                            </span>
                                                             <span class="pull-right btn-group">
                                                                <button type="button" name="changeDriverBtn" data-terminal="{{$terminal->destination_id}}" class="btn btn-sm btn-primary" style="border-radius: 100%">
                                                                    <i class="fa fa-user"></i>
                                                                </button>
                                                                <button type="button" name="deleteDriverBtn" data-terminal="{{$terminal->destination_id}}" class="btn btn-sm btn-primary" style="border-radius: 100%">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                        <div data-terminal="{{$terminal->destination_id}}" name="changedriver-header" class="box-header bg-blue hidden">
                                                            <span class="col-md-8">
                                                                <h6>Driver:</h6>
                                                                 <h4>
                                                                    <a href="#" class="text-white" name="driverChange" data-terminal="{{$terminal->destination_id}}" data-driver="{{$vanOnDeck->driver_id}}" data-van="{{$vanOnDeck->van_queue_id}}"></a>
                                                                    <i class='fa fa-pencil'></i>
                                                                </h4>
                                                            </span>
                                                             <span class="pull-right btn-group">
                                                                <button type="button" data-terminal="{{$terminal->destination_id}}" name="onDeckBtn1" class="btn btn-sm btn-primary" style="border-radius: 100%">
                                                                    <i class="fa fa-chevron-left"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                        <div name="deletedriver-header" data-terminal="{{$terminal->destination_id}}" class="box-header bg-blue hidden">
                                                            <span class="col-md-12">
                                                                 <p>
                                                                     Are you sure you want to remove <strong>{{$vanOnDeck->van->plate_number}}</strong> on deck?
                                                                 </p>
                                                            </span>
                                                             <span class="pull-right">
                                                                 <form method="POST" action="{{route('vanqueue.destroy',[$vanOnDeck->van_queue_id])}}">
                                                                     {{method_field('DELETE')}}
                                                                     {{csrf_field()}}
                                                                    <button type="button" data-terminal="{{$terminal->destination_id}}" name="onDeckBtn2" class="btn btn-sm btn-primary">
                                                                        NO
                                                                    </button>
                                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                                        YES
                                                                    </button>
                                                                 </form>
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
                                                                            <i class=" glyphicon glyphicon-search"></i>
                                                                        </span>
                                                                        <input type="text" name="SearchDualList" class="form-control" placeholder="search" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="">
                                                            <ul id="onBoardList{{$terminal->destination_id}}" class="list-group scrollbar scrollbar-info thin ticket-overflow">
                                                                @foreach($soldTickets->whereIn('destination_id',$terminal->routeFromDestination->pluck('destination_id'))->where('status','OnBoard') as $soldTicket)
                                                                    <li data-val="{{$soldTicket->sold_ticket_id}}" class="list-group-item">{{$soldTicket->ticket_number}}</li>
                                                                @endforeach
                                                            </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div>
                                                <hr>
                                                <button name="sellPageBtn" data-terminal="{{$terminal->destination_id}}" class="btn btn-default btn-flat" style="height: 50px;"><i class="fa fa-angle-double-left"></i> BACK</button>
                                                <button name="depart" class="btn bg-navy btn-flat pull-right"  data-val="{{$terminal->destination_id}}" style="height: 50px;"><i class="fa fa-automobile"></i> DEPART</button>
                                            </div>

                                            <div class="modal" id="ob-modal{{$terminal->destination_id}}">
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
                                        <li id="navTerminal{{$terminal->destination_id}}" class="@if($terminals->first() == $terminal){{'active'}}@endif navItem"><a href="#terminal{{$terminal->destination_id}}" data-toggle="tab">{{$terminal->destination_name}}</a></li>
                                @endforeach
                            </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
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



@endsection
@section('scripts')
@parent
{{ Html::script('/jquery/bootstrap3-editable/js/bootstrap-editable.min.js') }}

<script>
    $(function(){
        $('.select2').select2();
     var activeTab = document.location.hash;

     var element = $(".tab-content :first");
    element.removeClass('active');

     if(!activeTab) {

            activeTab = element.attr('id');

            $('li[class="active navItem"]').removeClass('active');
            $('#navTerminal'+$(activeTab).data('terminal')).addClass('active');

     } else {
         $('li[class="active navItem"]').removeClass('active');
         $('#navTerminal'+$(activeTab).data('terminal')).addClass("active in");
     }

     $(activeTab).addClass("active");

     $('a[href="#'+ activeTab +'"]').tab('show');
     window.location.hash = activeTab;

        $('.nav-stacked a').click(function () {
            $(this).tab('show');
            var scrollmem = $('body').scrollTop() || $('html').scrollTop();
            window.location.hash = this.hash;
            $('html,body').scrollTop(scrollmem);
        });

        $('a[data-toggle="tab"]').on('click',function(){
            $('.tab-pane').removeClass('hidden');
        });

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

                    if(ticketType == 'Regular') {
                        var ticketNumber = '<tr><td><button type="button" class="btn btn-block btn-xs edit btn-primary">'+element.ticketNumber+'</button></td>';     
                    } else if (ticketType = 'Discount') {
                        var ticketNumber = '<tr><td><button type="button" class="btn btn-block btn-xs edit btn-warning">'+element.ticketNumber+'</button></td>';
                    }
                   

                    var fare = '<td class="pull-right">'+element.fare+'</td>';
                    var deleteButt = '<td class="text-right"><button name="deleteSpecificSelectedTicket" class="btn btn-xs" data-val="'+element.selectedId+'"><i class="fa fa-trash"></i></button></td></tr>';
                    $('#selectedList'+terminalId).prepend(ticketNumber+fare+deleteButt);

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

                },
                error:function(response) {
                    $('div[data-notify="container"]').remove();
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

        //Delete a Specific Selected Ticket
        $(document).on('click','button[name="deleteSpecificSelectedTicket"]',function(){
            var element = $(this);
            var selectedTicketId = $(this).data('val');
            element.prop('disabled',true);
            $.ajax({
                method:'DELETE',
                url: '/selectTicket/'+selectedTicketId,
                data: {
                    '_token': '{{csrf_token()}}'
                },
                success: function(response){
                    element.closest('tr').remove();
                    updateDataOfDeletedTicket(response.destinationId,response.terminalId,response.ticketType,response.fare);
                },
                error:function(response) {
                    $('div[data-notify="container"]').remove();
                    element.prop('disabled',false);
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
                },
                error:function(response) {
                    $('div[data-notify="container"]').remove();
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
                    var tickets = [];
                    $('#onBoardList'+terminalId+' li').each(function(){
                        tickets.push($(this).data('val'));
                    });
                    if(tickets.length >= 10) {
                        $.ajax({
                            method:'PATCH',
                            url: '/home/transactions/'+terminalId,
                            data: {
                                '_token': '{{csrf_token()}}'
                            },
                            success: function(response){
                                window.location.replace('/home/trip-log/'+response)
                            },
                            error:function(response) {
                                $('div[data-notify="container"]').remove();
                                $('.notifyjs-corner').empty();
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
                        $('#ob-modal'+terminalId).modal('show');
                    }
                } else {
                    $('div[data-notify="container"]').remove();

                    $.notify({
                        // options
                        icon: 'fa fa-warning',
                        message: 'Unable to depart, there are no boarded tickets in the van'
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

            //Depart the ticket/s and add the van to the queue and mark it as OB
            $('button[name="departOb"]').on('click',function() {
               var terminalId  = $(this).data('val');

                $.ajax({
                    method:'PATCH',
                    url: '/home/transactions/'+terminalId,
                    data: {
                        '_token': '{{csrf_token()}}'
                    },
                    success: function(response){
                        window.location.replace('/home/trip-log/'+response)
                    },
                    error:function(response) {
                        $('div[data-notify="container"]').remove();
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

            $('body').on('click', '.list-group .list-group-item', function () {
                $(this).toggleClass('active');
            });

            $('button[name="board"]').on('click', function () {
                var terminalId = $(this).data('terminal');
                var actives = $('#pendingList'+terminalId).children('.active');

                if (actives.length > 0) {
                    var soldTickets = [];

                    actives.each(function () {
                        soldTickets.push($(this).data('val'));
                    });

                    $.ajax({
                        method:'PATCH',
                        url: '{{route("transactions.updatePendingTransactions")}}',
                        data: {
                            '_token': '{{csrf_token()}}',
                            'soldTickets': soldTickets,
                            'destination' : terminalId
                        },
                        success: function(){
                            soldTickets.forEach(function(element){
                                $('.pendingList').find('li[data-val="'+element+'"]').remove();
                            });

                            actives.clone().appendTo('#onBoardList'+terminalId).removeClass('active');
                            actives.remove();


                            var checkBox = $('a[name="checkBox'+terminalId+'"]');

                            if (checkBox.hasClass('selected') && checkBox.children('i').hasClass('glyphicon-check')) {
                                checkBox.removeClass('selected');
                                checkBox.children('i').removeClass('glyphicon-check').addClass('glyphicon-unchecked');
                            }
                        },
                        error:function(response) {
                            $('div[data-notify="container"]').remove();
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

            $('button[name="unboard"]').on('click',function() {
                var terminalId = $(this).data('terminal');
                var actives = $('#onBoardList'+terminalId).children('.active');

                if (actives.length > 0) {
                    var soldTickets = [];
                    actives.each(function () {
                        soldTickets.push($(this).data('val'));
                    });

                    $.ajax({
                        method: 'PATCH',
                        url: '{{route("transactions.updateOnBoardTransactions")}}',
                        data: {
                            '_token': '{{csrf_token()}}',
                            'soldTickets': soldTickets
                        },
                        success: function () {

                            actives.clone().appendTo('#pendingList'+terminalId).removeClass('active');
                            actives.remove();

                            var checkBox = $('a[name="checkBox'+terminalId+'"]');

                            if (checkBox.hasClass('selected') && checkBox.children('i').hasClass('glyphicon-check')) {
                                checkBox.removeClass('selected');
                                checkBox.children('i').removeClass('glyphicon-check').addClass('glyphicon-unchecked');
                            }
                        },
                        error:function(response) {
                            $('div[data-notify="container"]').remove();
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
                    $('div[data-notify="container"]').remove();
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
<script>
     $(function(){

        //change sell ticket form
        $('button[name="buttonSell"]').on('click',function(){
            var terminalId = $(this).data('terminal');
            var form = $(this);
        

            var type = $('select[name="customer"][data-terminal="'+terminalId+'"]').val();

            if(type == 'walkIn') { 
               $.ajax({
                     method:'POST',
                     url: '/home/transactions/'+terminalId,
                     data: {
                         '_token': '{{csrf_token()}}'
                     },
                     success: function(){
                         location.reload();
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
            
            } else {

                $.ajax({
                     method:'POST',
                     url: '/home/transactions/'+terminalId,
                     data: {
                         '_token': '{{csrf_token()}}',
                         'customer' : type
                     },
                     success: function(){
                         location.reload();
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


        $('div[name="changedriver-header"]').hide();
        $('div[name="deletedriver-header"]').hide();

        $('button[name="changeDriverBtn"]').click(function(){
            var terminalId = $(this).data('terminal');

            $('#ondeck-header'+terminalId).hide();
            $('div[name="changedriver-header"][data-terminal="'+terminalId+'"]').show();
            $('div[name="changedriver-header"][data-terminal="'+terminalId+'"]').removeClass("hidden");

        });

        $('button[name="deleteDriverBtn"]').click(function(){
            var terminalId = $(this).data('terminal');

            $("#ondeck-header"+terminalId).hide();
            $('div[name="deletedriver-header"][data-terminal="'+terminalId+'"]').show();
            $('div[name="deletedriver-header"][data-terminal="'+terminalId+'"]').removeClass("hidden");
        });

        $('button[name="onDeckBtn1"]').click(function(){
            var terminalId = $(this).data('terminal');

            $("#ondeck-header"+terminalId).show();
            $('div[name="changedriver-header"][data-terminal="'+terminalId+'"]').hide();
        });

        $('button[name="onDeckBtn2"]').click(function(){
            var terminalId = $(this).data('terminal');

            $("#ondeck-header"+terminalId).show();
            $('div[name="deletedriver-header"][data-terminal="'+terminalId+'"]').hide();
        });

      });

     $('button[name="moveToSpecialUnits"]').on('click',function(){
         var vanOnQueue = $(this).data('van');
         $.ajax({
             method:'PATCH',
             url: '/moveToSpecialUnit/'+vanOnQueue,
             data: {
                 '_token': '{{csrf_token()}}',
                 'fromDepart' : true
             },
             success: function(){
                 location.reload();
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
     });

     $('button[name="remainOnDeck"]').on('click',function(){
         var vanOnQueue = $(this).data('van');

         $.ajax({
             method:'PATCH',
             url: '/home/vanqueue/'+vanOnQueue+'/updateRemarks',
             data: {
                 '_token': '{{csrf_token()}}',
                 'remarks' : 'NULL',
                 'fromDepart' : true
             },
             success: function(){
                 location.reload();
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
     });
</script>

<script>
    $(function(){
        $('div[name="boardTickets"]').hide();

        $('button[name="boardPageBtn"]').click(function(){
            var terminalId = $(this).data('terminal');

            $("#sellTickets"+terminalId).hide();
            $("#boardTickets"+terminalId).show();
        });

        $('button[name="sellPageBtn"]').click(function(){
            var terminalId = $(this).data('terminal');

            $("#sellTickets"+terminalId).show();
            $("#boardTickets"+terminalId).hide();
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
<script>
    $(function() {
        $('a[name="driverChange"]').each(function(){
            $(this).editable({
                type: 'select',
                title: 'Change Driver',
                value: $(this).data('driver'),
                source: "/listSourceDrivers/"+$(this).data('driver'),
                sourceCache: true,
                pk: $(this).data('van'),
                url: '/changeDriver/'+$(this).data('van'),
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
                        return response.responseJSON.error;
                    }
                },
                success: function(response){
                }
            });
        });

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
