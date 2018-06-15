@extends('layouts.master')
@section('title', 'List of Transactions')
@section('content')
<div class="padding-side-5">
    <div>
        <h2 class="text-white">LIST OF TRANSACTION</h2>
    </div>
    <div class="box">
        <div class="box-body with-shadow">
           <div class="table-responsive">
            
            <table id="tranList" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ticket Name</th>
                        <th>Destination</th>
                        <th>Origin</th>
                        <th>Ticket Type</th>
                        <th>Amount Paid</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($transactions as $transaction)   
                    <tr>
                        <td class="hidden-xs" name="opId">{{$transaction->transaction_id}}</td>
                        <td class="text-uppercase">{{$transaction->ticket_name ?? 'NONE'}}</td>
                        <td class="text-uppercase">{{$transaction->destination}}</td>
                        <td class="text-uppercase">{{$transaction->origin}}</td>
                        <td class="text-uppercase">{{$transaction->transaction_ticket_type}}</td>
                        <td class="text-right">{{$transaction->amount_paid}}</td>
                        <td>{{$transaction->created_at->formatLocalized('%d %B %Y')}}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th style="text-align:right">Total:</th>
                        <th colspan="2" style="text-align:left"></th>
                        
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
        @include('layouts.partials.preloader_div')
</div>
@endsection
@section('scripts') 
@parent

<!-- DataTables -->
<script src="//cdn.datatables.net/plug-ins/1.10.16/api/sum().js"> </script>

<script src="{{ URL::asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
    $(function() {
        $('form[name="archiveOperatorForm"]').on('submit',function () {
            $(this).find('button[type="submit"]').prop('disabled',true);
            $('#submit-loader').removeClass('hidden');
            $('#submit-loader').css("display","block");
            $('.modal').modal('hide');
        });

        $('#tranList').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            'order': [[ 0, "desc" ]],
            'aoColumnDefs': [
                { 'bSortable': false, 'aTargets': [-1]},
                { "width": "5%", "targets": 0 },
                { "width": "11%", "targets": 3 },
                { "width": "13%", "targets": 4 }
            ],

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
                amount = api
                    .column( 5, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                $( api.column( 5 ).footer() ).html(
                    'P'+amount.toFixed(2)+' (P{{$transaction->total_amount}} total)'
                );

                },
    })
});

                        


</script>

@endsection