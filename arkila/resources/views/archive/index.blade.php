@extends('layouts.master')
@section('title', 'Operator Archive')
@section('content-header', 'Operator Archive')
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
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($operators as $operator)
                <tr>
                    <td>{{ $operator->operator->full_name }}</td>
                    <td>{{ $operator->operator->contact_number }}</td>
                    <td>{{ $operator->operator->address }}</td>
                    <td>
                        <div class="text-center">
                            <a href="{{ route('archive.showProfile', [$operator->archive_member_id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> VIEW</a>
                            <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#{{'deleteWarning'.$operator->archive_member_id}}"><i class="fa fa-trash"></i> DELETE</button>
                        </div>
                        <!-- /.text -->
                    </td>
                </tr>
                <!-- Modal for Delete-->
                <div class="modal fade" id="{{'deleteWarning'.$operator->archive_member_id}}">
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
                                <p>Are you sure you want to delete "{{ $operator->operator->full_name }}"</p>
                            </div>
                            <div class="modal-footer">
                                @if($operators && $operator)
                                <form action="{{ route('operators.destroy', [$operator->archive_member_id]) }}" method="POST">
                                    {{ csrf_field() }} {{method_field('DELETE')}}
                                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                                @endif
                            </div>
                        </div>
                        <!-- /.modal-content -->
                        <!-- /.col -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
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
            'aoColumnDefs': [
                { 'bSortable': false, 'aTargets': [-1]}
            ]
        })
    });
</script>    
        
@stop
