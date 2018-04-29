@extends('layouts.master')
@section('title', 'Daily Ledger')
@section('links')
@parent
  <link rel="stylesheet" href="public\css\myOwnStyle.css">
@stop
@section('content')

<div class="box">
    <div class="box-body">

        <h2 class="text-center">{{ $date->formatLocalized('%A %d %B %Y') }}</h2>
        <div class="table-responsive">
            <div class="col col-md-6">
                <a href="{{route('ledger.create')}}" class="btn btn-success btn-flat btn-sm"><i class="fa fa-plus"></i>
            Add Revenue/Expense 
        </a>
                <button onclick="window.open('{{route('pdf.ledger')}}')" class="btn btn-default btn-sm btn-flat"> <i class="fa fa-print"></i>PRINT</button>
            </div>
            <table class="table table-bordered table-striped dailyLedgerTable">
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
                    <!-- Modal for Delete-->
                    <div class="modal fade" id="{{'deleteLedger'. $ledger->ledger_id}}">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header bg-red">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                    <h4 class="modal-title"> Confirm</h4>
                                </div>
                                <div class="modal-body">
                                    <h1>
                                        <i class="fa fa-exclamation-triangle pull-left text-yellow"></i>
                                    </h1>
                                    <p>Are you sure you want to delete "{{$ledger->description}}"?</p>
                                </div>
                                <div class="modal-footer">
                                    <form action="{{route('ledger.destroy', $ledger->ledger_id)}}" method="POST">
                                        {{csrf_field()}} {{method_field('DELETE')}}

                                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button> <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                            <!-- /.col -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>

                    @endforeach 
                    
                    @if ($ledgers->count() > 0)

                        <tr>
                            <td></td>
                            <td>Booking Fee(Baguio)</td>
                            <td></td>
                            <td class="text-right">{{ number_format($ledger->booking_fee, 2) }}</td>
                            <td></td>
                            <td class="text-right">{{ number_format($ledger->booking_fee, 2) }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>SOP</td>
                            <td></td>
                            <td class="text-right">{{ number_format($ledger->sop, 2) }}</td>
                            <td></td>
                            <td class="text-right">{{ number_format($ledger->sop, 2) }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Expired Ticket</td>
                            <td></td>
                            <td class="text-right">{{ number_format($ledger->expired_ticket, 2) }}</td>
                            <td></td>
                            <td class="text-right">{{ number_format($ledger->expired_ticket, 2) }}</td>
                            <td></td>
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
@stop

@section('scripts')
@parent
    <script>
        $(function() {
            $('.dailyLedgerTable').DataTable({
                'paging': false,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': false,
                'aoColumnDefs': [{
                    'bSortable': false,
                    'aTargets': [-1] /* 1st one, start by the right */
                }]
            })
        })
    </script>
@stop