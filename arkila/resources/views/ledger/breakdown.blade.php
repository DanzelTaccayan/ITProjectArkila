@extends('layouts.master')
@section('title', 'Daily Ledger')
@section('links')
@parent
  <link rel="stylesheet" href="public\css\myOwnStyle.css">
@stop
@section('content')
<div class="padding-side-5">
    <div>
        <h2 class="text-white">DAILY LEDGER BREAKDOWN</h2>
    </div>
    <div class="box">
        <div class="box-body">
            <div class="time-header">
                <h3 class="text-right" style="padding: 10px 0px 10px 0px; border-bottom: 2px solid gray; margin-bottom: 30px;"><i class="fa fa-calendar"></i> {{ $date->formatLocalized('%A %d %B %Y') }}</h3>
            </div>
            
            <div class="table-responsive">
                <div class="col col-md-6">
                    <a href="{{route('ledger.create')}}" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-back"></i>
                        GO BACK
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
                            <th class="text-center">TIME</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ledgers as $ledger) 
                        @if($ledger->created_at != null)
                        @if ($ledger->created_at->format('m-d-Y') == $date->format('m-d-Y'))
                        <tr>
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
                                    {{date('g:i A', strtotime($ledger->created_at, 2))}}
                                </div>
                            </td>
                        </tr>
                        @endif
                        @endif

                
                        @endforeach 
                             
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