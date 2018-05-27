@extends('layouts.master')
@section('title', 'Driver Archive')
@section('content')
    {{session(['opLink'=> Request::url()])}} 
 <div class="padding-side-5"> 
    <div>
        <h2 class="text-white">ARCHIVE OF DRIVERS</h2>
    </div>
    <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
           <div class="table-responsive">
                <div class="col-md-6">
                    <a href="{{route('drivers.index')}}" class="btn btn-info btn-sm btn-flat"><i class="fa  fa-chevron-left"></i> GO BACK TO DRIVER LIST</a>
                    <button onclick="window.open('')"  class="btn btn-default btn-sm btn-flat"> <i class="fa fa-print"></i> PRINT DRIVER ARCHIVE</button>
                </div>
                <table id="archiveDriver" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Contact Number</th>
                        <th>Date Archived</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="text-center">
                                        <a href="" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> VIEW</a>
                                        <a href="" class="btn btn-success btn-sm"><i class="fa fa-eye"></i> RESTORE</a>
                                    </div>
                                </td>
                            </tr>
                        
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>  
 
@stop 
@section('scripts') 
@parent

<!-- DataTables -->
<script src="{{ URL::asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
    $(function() {
        $('#archiveDriver').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': true,
            'order': [[ 1, "desc" ]],
            'aoColumnDefs': [{
                'bSortable': false,
                'aTargets': [-1] /* 1st one, start by the right */
            }]
        })
    });
</script>    
        
@stop
