@extends('layouts.master')
@section('title', 'Daily Ledger')
@section('links')
@parent
  <link rel="stylesheet" href="public\css\myOwnStyle.css">
@stop
@section('content')
<div class="padding-side-5">
    <div>
        <h2 class="text-white">DAILY LEDGER</h2>
    </div>
    <div class="box">
        <div class="box-body">
            <div class="time-header">
                <h3 class="text-right" style="padding: 10px 0px 10px 0px; border-bottom: 2px solid gray; margin-bottom: 30px;"><i class="fa fa-calendar"></i> {{ $date->formatLocalized('%A %d %B %Y') }}</h3>
            </div>
            
            <div class="table-responsive">
                <div class="col col-md-6">
                    <a href="{{route('ledger.create')}}" class="btn btn-success btn-flat btn-sm"><i class="fa fa-plus"></i>
                        ADD REVENUE/EXPENSE
                    </a> 
                    <a href="" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-book"></i>
                        SHOW BREAKDOWN
                    </a>
                    <button onclick="window.open('{{route('pdf.ledger')}}')" class="btn btn-default btn-sm btn-flat"> <i class="fa fa-print"></i>PRINT DAILY LEDGER</button>
                </div>
                <table id="dailyLedgerTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Payee/Payor</th>
                            <th>Particulars</th>
                            <th>OR#</th>
                            <th>IN</th>
                            <th>OUT</th>
                            <th>Balance</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ledgers->sortByDesc('ledger_id') as $ledger) 
                        @if($ledger->created_at != null)
                        @if ($ledger->created_at->format('m-d-Y') == $date->format('m-d-Y'))
                        <tr>
                            @if ($ledger->description !== 'Booking Fee' && $ledger->description !== 'SOP' && $ledger->description !== 'Expired Ticket')
                            <td>{{$ledger->payee}}</td>
                            <td>{{$ledger->description}}</td>
                            <td>{{$ledger->or_number}}</td>
                            @if ($ledger->type == 'Revenue')

                            <td class="text-right">{{$ledger->amount}}</td>
                            <td></td>
                            <td class="text-right">{{$ledger->amount}}</td>

                            @else
                            <td></td>
                            <td class="text-right">{{number_format($ledger->amount * -1, 2)}}</td>
                            <td class="text-right">{{number_format($ledger->amount * -1, 2)}}</td>

                            @endif

                            <td class="center-block">
                                <div class="text-center">
                                    <a href="{{route('ledger.edit', $ledger->ledger_id)}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"></i>EDIT</a>
                                    <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#{{'deleteLedger'. $ledger->ledger_id}}"><i class="fa fa-trash"></i> DELETE</button>
                                </div>
                            </td>
                        </tr>
                        @endif 
                        @endif
                        @endif

                        <div class="modal" id="{{'deleteLedger'. $ledger->ledger_id}}">
                            <div class="modal-dialog" style="margin-top: 10%;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span></button>
                                        <h4 class="modal-title"></h4>
                                    </div>
                                    <div class="modal-body">
                                        <h1 class="text-center text-red"><i class="fa fa-trash"></i> DELETE</h1>
                                        <p class="text-center">ARE YOU SURE YOU WANT TO DELETE</p>             
                                        <h4 class="text-center "><strong class="text-red">{{$ledger->description}}</strong>?</h4>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{route('ledger.destroy', $ledger->ledger_id)}}" method="POST">
                                            {{csrf_field()}} 
                                            {{method_field('DELETE')}}
                                            <div class="text-center">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                                                <button type="submit" class="btn btn-danger">DELETE</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endforeach 
                        
                        @if ($ledgers->count() > 0)

                            <tr>
                                <td></td>
                                <td>Booking Fee({{$mainTerminal->destination_name}})</td>
                                <td></td>
                                <td class="text-right">{{ number_format($ledger->booking_fee, 2) }}</td>
                                <td></td>
                                <td class="text-right">{{ number_format($ledger->booking_fee, 2) }}</td>
                                <td class="text-center">No Action</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>SOP</td>
                                <td></td>
                                <td class="text-right">{{ number_format($ledger->sop, 2) }}</td>
                                <td></td>
                                <td class="text-right">{{ number_format($ledger->sop, 2) }}</td>
                                <td class="text-center">No Action</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Lost/Expired Ticket</td>
                                <td></td>
                                <td class="text-right">{{ number_format($ledger->expired_ticket, 2) }}</td>
                                <td></td>
                                <td class="text-right">{{ number_format($ledger->expired_ticket, 2) }}</td>
                                <td class="text-center">No Action</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>TOTAL:</th>
                                <th class="text-right">{{ number_format($ledger->total_revenue, 2)}}</th>
                                <th class="text-right">{{ number_format($ledger->total_expense, 2) }}</th>
                                <th class="text-right">{{ number_format($ledger->balance, 2) }}</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
@parent
    <script>
        $(function() {
            $('#dailyLedgerTable').DataTable({
                'paging': false,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': false,
                'order': [[ 6, "desc" ]]
            })
        });

                    
                    "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };


                // Total rev
                revPageTotal = api
                    .column( 3, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );


            }, 

        });
    </script>
@stop