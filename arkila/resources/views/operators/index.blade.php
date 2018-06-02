@extends('layouts.master')
@section('title', 'List of Operators')
@section('content')
<div class="padding-side-5">
    <div>
        <h2 class="text-white">LIST OF OPERATORS</h2>
    </div>
    <div class="box">
        <div class="box-body with-shadow">
           <div class="table-responsive">
            <div class="col col-md-6">
                <a href="/home/operators/create" class="btn btn-success btn-sm btn-flat"><i class="fa fa-plus"></i> REGISTER OPERATOR</a>
                <a href="{{route('archive.index')}}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-archive"></i> ARCHIVE</a>
                <button onclick="window.open('{{route('pdf.operators')}}')"  class="btn btn-default btn-sm btn-flat"> <i class="fa fa-print"></i> PRINT</button>

            </div>
            
            <!-- /.col -->
            
            <table id="operatorList" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Contact Number</th>
                        <th>No. Of Van</th>
                        <th>No. Of Driver</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($operators->where('status', 'Active')->sortByDesc('member_id') as $operator)
                    <tr>
                        <td class="hidden-xs" name="opId">{{ $operator->member_id }}</td>
                        <td>{{trim(strtoupper($operator->full_name))}}</td>
                        <td>{{ $operator->contact_number }}</td>
                        <td class="text-right">{{count($operator->van)}}</td>
                        <td class="text-right">{{count($operator->drivers)}}</td>
                        <td>
                            <div class="text-center">
                                <a href="{{ route('operators.show', [$operator->member_id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> VIEW</a>
                                <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#{{'deleteWarning'.$operator->member_id}}"><i class="fa fa-trash"></i> DELETE</button>
                            </div>
                            <!-- /.text -->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @foreach ($operators->where('status', 'Active')->sortByDesc('member_id') as $operator)
        <div class="modal" id="{{'deleteWarning'.$operator->member_id}}">
            <div class="modal-dialog" style="margin-top: 10%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <h1 class="text-center text-red"><i class="fa fa-trash"></i> DELETE</h1>
                        <p class="text-center">ARE YOU SURE YOU WANT TO DELETE</p>
                        <h4 class="text-center "><strong class="text-red">{{trim($operator->full_name)}}</strong>?</h4>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('operators.archiveOperator', [$operator->member_id]) }}" method="POST">
                            {{csrf_field()}}
                            {{method_field('PATCH')}}
                            <div class="text-center">
                                <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                                <button type="submit" class="btn btn-danger">DELETE</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
@section('scripts') 
@parent

<!-- DataTables -->
<script src="{{ URL::asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
    $(function() {
        $('#operatorList').DataTable({
            'paging': true,
            'lengthChange': false,
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