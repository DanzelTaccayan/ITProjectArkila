@extends('layouts.master')
@section('title', 'General Ledger')
@section('links')
@parent
  <link rel="stylesheet" href="public\css\myOwnStyle.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
@stop
@section('content')


<div class="box">
<div class="box-body">

   <h2 style="margin-left:37%">General Ledger</h2>
   @if ($start !== null && $end !==null)
   <h4 style="margin-left:31%">Showing results from {{ $start }} to {{ $end }}.</h4>
   @endif

   <div class="table-responsive">
    <div style="margin-left:28%">
      <form method="POST" action="{{route('ledger.filter')}}">
      {{csrf_field()}}
        From: <input type="date" name="start">
        To: <input type="date" name="end">
        <button type="submit" class="btn btn-default btn-sm" name"search">SEARCH</button>
      </form>
    </div>

        <table class="table table-bordered table-striped generalLedgerTable">
            <thead>
                <tr>
                    <th>Payee/Payor</th>
                    <th>Particulars</th>
                    <th>OR#</th>
                    <th>IN</th>
                    <th>OUT</th>
                    <th>Balance</th>
                    <th>Date</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $booking)
                <tr>
                    <td></td>
                    <td>{{$booking->description}}</td>
                    <td></td>
                    <td class="text-right">{{ $booking->total_amount }}</td>
                    <td></td>
                    <td class="text-right">{{ $booking->total_amount }}</td>
                    <td>{{$booking->created_at->formatLocalized('%B %d, %Y')}}</td>
                    <td></td>
                </tr>
                @endforeach
                @foreach ($sops as $sop)
                <tr>
                    <td></td>
                    <td>{{$sop->description}}</td>
                    <td></td>
                    <td class="text-right">{{ $sop->total_amount }}</td>
                    <td></td>
                    <td class="text-right">{{ $sop->total_amount }}</td>
                    <td>{{$sop->created_at->formatLocalized('%B %d, %Y')}}</td>
                    <td></td>
                </tr>
                @endforeach
                @foreach ($expired as $expire)
                <tr>
                    <td></td>
                    <td>{{$expire->description}}</td>
                    <td></td>
                    <td class="text-right">{{ $expire->total_amount }}</td>
                    <td></td>
                    <td class="text-right">{{ $expire->total_amount }}</td>
                    <td>{{$expire->created_at->formatLocalized('%B %d, %Y')}}</td>
                    <td></td>
                </tr>
                @endforeach

            @foreach ($ledgers->sortByDesc('ledger_id') as $ledger)
                @if ($ledger->description !== 'Booking Fee' && $ledger->description !== 'SOP' && $ledger->description !== 'Expired Ticket')

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

                    <td>{{$ledger->created_at->formatLocalized('%B %d, %Y')}}</td>

                    <td class="center-block">
                        <div class="text-center">
                            <a href="{{route('ledger.edit', $ledger->ledger_id)}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"></i>EDIT</a>
                            <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#{{'deleteLedger'. $ledger->ledger_id}}"><i class="fa fa-trash"></i> DELETE</button>
                        </div>
                    </td>
                </tr>

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
                                            <i class="fa fa-exclamation-triangle pull-left text-yellow" ></i>
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
                @endif
                @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th>TOTAL:</th>
                <th style="text-align:right"></th>
                <th style="text-align:right"></th>
                <th colspan="2" style="text-align:left"></th>
                <th></th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
</div>

@stop

@section('scripts')
@parent

<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"> </script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"> </script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"> </script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"> </script>
<script src="//cdn.datatables.net/plug-ins/1.10.16/api/sum().js"> </script>

<script>

    $(document).ready(function() {
        $('.generalLedgerTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'pdfHtml5',
                    text: 'PRINT',
                    title: 'Ban Trans General Ledger',
                    extend: 'print',
                    autoPrint: false,
                    footer: true,
                    download: 'open',
                    exportOptions : {
                        columns: ':not(:last-child)',
                    },
                    customize: function ( win ) {
                        $(win.document.body)
                            .css( 'font-size', '10pt' );

                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' );
                    }

                }
            ],
            'paging': false,
            'lengthChange': true,
            'searching': true,
            'ordering': false,
            'info': true,
            'autoWidth': true,
            'order': [[ 6, "asc" ]],
            'aoColumnDefs': [{
                'bSortable': false,
                'aTargets': [-1] /* 1st one, start by the right */
            }],


            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // total balnce
                total = api
                    .column( 5 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                // searched balance
                pageTotal = api
                    .column( 5, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                // balance
                $( api.column( 5 ).footer() ).html(
                    pageTotal +' ('+ total +' total)'
                );

                // Total exp
                expPageTotal = api
                    .column( 4, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                // show exp
                $( api.column( 4 ).footer() ).html(
                    expPageTotal
                );

                // Total rev
                revPageTotal = api
                    .column( 3, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                // show rev
                $( api.column( 3 ).footer() ).html(
                    revPageTotal
                );

            }, 

        });

        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
               'Today': [moment(), moment()],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

    });

    $(document).ready(function() {
        var table = $('.generalLedgerTable').DataTable();

        // Event listener to the two range filtering inputs to redraw on input
        $('#reportrange').keyup( function() {
            table.draw();
        } );
    } );

</script>

@stop
