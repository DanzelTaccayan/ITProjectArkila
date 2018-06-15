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
                        <th>Amount Paid</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>    
                    <tr>
                        <td class="hidden-xs" name="opId"></td>
                        <td class="text-uppercase"></td>
                        <td class="text-uppercase"></td>
                        <td class="text-right"></td>
                        <td></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Total:</td>
                        <td class="text-right"></td>
                        <td></td>  
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
            ]
        })
    })
</script>

@endsection