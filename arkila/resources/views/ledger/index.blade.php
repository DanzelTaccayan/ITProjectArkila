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
                    <a href="{{route('ledger.create')}}" class="btn btn-primary btn-flat btn-sm"><i class="fa book-open"></i>
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
                            <tr>
                                <td></td>
                                <td><a href="">Booking Fee(Baguio)</a></td>
                                <td></td>
                                <td class="text-right">600</td>
                                <td></td>
                                <td class="text-right">600</td>
                                <td class="text-center">No Action</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><a href="">SOP</a></td>
                                <td></td>
                                <td class="text-right">200</td>
                                <td></td>
                                <td class="text-right">200</td>
                                <td class="text-center">No Action</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Electric Bill</td>
                                <td>CA236663</td>
                                <td></td>
                                <td class="text-right">2000</td>
                                <td class="text-right">2000</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary">VIEW</button>
                                    <button class="btn btn-sm btn-danger">DELETE</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Cardo Dalisay</td>
                                <td>Montly Due</td>
                                <td></td>
                                <td class="text-right">250</td>
                                <td></td>
                                <td class="text-right">250</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary">VIEW</button>
                                    <button class="btn btn-sm btn-danger">DELETE</button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>TOTAL:</th>
                                <th class="text-right">1050</th>
                                <th class="text-right">2000</th>
                                <th class="text-right">-950</th>
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
    </script>
@stop