@extends('layouts.master')
@section('title', 'Operator Archive')
@section('content')
    {{session(['opLink'=> Request::url()])}} 
    
<div class="box">
    <!-- /.box-header -->
    <div class="box-body">
       <div class="table-responsive">
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
                    <td>{{ \Carbon\Carbon::parse($operator->pivot->created_at)->toDayDateTimeString() }}</td>
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
            'lengthChange': true,
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
