@extends('layouts.master')
@section('title', 'Operator Archive')
@section('content')
    {{session(['opLink'=> Request::url()])}} 
    
<div class="box">
    <!-- /.box-header -->
    <div class="box-body">
       <div class="table-responsive">
        <div class="col-md-6">
            <a href="{{route('operators.index')}}" class="btn btn-info btn-sm btn-flat"><i class="fa  fa-file-text-o"></i> OPERATOR LIST</a>
            <button onclick="window.open('{{route('pdf.drivers')}}')"  class="btn btn-default btn-sm btn-flat"> <i class="fa fa-print"></i> PRINT ARCHIVE</button>
        </div>
        <table class="table table-bordered table-striped archiveOpe">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Contact Number</th>
                    <th>Address</th>
                    <th>Date Archived</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($operators as $operator)
                <tr>
                    <td>{{ $operator->full_name }}</td>
                    <td>{{ $operator->contact_number }}</td>
                    <td>{{ $operator->address }}</td>
                    <td>{{ $operator->date_archived }}</td>
                    <td>
                        <div class="text-center">
                            <a href="{{ route('archive.showProfile', [$operator->member_id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> VIEW</a>
                        </div>
                        <!-- /.text -->
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>
 
@stop 
@section('scripts') 
@parent

<!-- DataTables -->
<script src="{{ URL::asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
    $(function() {
        $('.archiveOpe').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': true,
            'order': [[ 3, "desc" ]],
            'aoColumnDefs': [
                { 'bSortable': false, 'aTargets': [-1]}
            ]
        })
    });
</script>    
        
@stop
