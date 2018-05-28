@extends('layouts.master')
@section('title', 'Operator Archive')
@section('content')
    {{session(['opLink'=> Request::url()])}} 
 <div class="padding-side-5"> 
    <div>
        <h2 class="text-white">ARCHIVE OF OPERATORS</h2>
    </div>
    <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
           <div class="table-responsive">
            <div class="col-md-6">
                <a href="{{route('operators.index')}}" class="btn btn-info btn-sm btn-flat"><i class="fa  fa-chevron-left"></i> GO BACK TO OPERATOR LIST</a>
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
                        <td>{{$operator->updated_at->format('h:i A')." of ".$operator->updated_at->format('M d, Y')}}</td>
                        <td>
                            <div class="text-center">
                                <a href="{{ route('archive.showArchivedProfileOperator', [$operator->member_id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> VIEW</a>
                                <a href="" class="btn btn-success btn-sm" data-toggle="modal" data-target="#huhu"><i class="fa fa-eye"></i> RESTORE</a>
                            </div>
                            <!-- /.text -->
                        </td>
                    </tr>
                    <div class="modal fade" id="huhu">
                        <form action="{{route('operators.restoreArchivedOperator',[$operator->member_id])}}" method="POST">
                            {{csrf_field()}}
                            {{method_field('PATCH')}}
                            <div class="modal-dialog">
                            <div class="col-md-offset-2 col-md-8">
                                <div class="modal-content">
                                    <div class="modal-header bg-green">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title"> Confirm</h4>
                                    </div>
                                    <div class="modal-body row" style="margin: 0% 1%;">
                                        <p style="font-size: 110%;">Are you sure you want to restore <strong>"{{ $operator->full_name }}"</strong>?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="" method="POST">
                                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">No</button>
                                            <button type="submit" class="btn btn-success btn-sm" style="width:22%;">Restore</button>
                                        </form>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.col -->
                        </div>\
                        </form>
                        <!-- /.modal-dialog -->
                    </div>
                    @endforeach
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
