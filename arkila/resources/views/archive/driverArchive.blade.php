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
                        @foreach($archivedDrivers as $archivedDriver)
                            <tr>
                                <td>{{$archivedDriver->full_name}}</td>
                                <td>{{$archivedDriver->address}}</td>
                                <td>{{$archivedDriver->contact_number}}</td>
                                <td>{{$archivedDriver->updated_at->format('h:i A')." of ".$archivedDriver->updated_at->format('M d, Y')}}</td>
                                <td>
                                    <div class="text-center">
                                        <a href="{{route('drivers.show',[$archivedDriver->member_id])}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> VIEW</a>
                                        <a href="" class="btn btn-success btn-sm" data-toggle="modal" data-target="#huhu"><i class="fa fa-eye"></i> RESTORE</a>
                                    </div>
                                </td>
                            </tr>
                            <!--RESTORE MODAL-->
                            <div class="modal fade" id="huhu">
                                <form method="POST" action="{{route('drivers.restoreArchivedDriver',[$archivedDriver->member_id])}}">
                                    {{csrf_field()}}
                                    {{method_field('PATCH')}}
                                    <div class="modal-dialog">
                                    <div class="col-md-offset-2 col-md-8">
                                        <div class="modal-content">
                                            <div class="modal-header bg-green">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title"> Choose Operator</h4>
                                            </div>
                                            <div class="modal-body row" style="margin: 0% 1%;">
                                                <div class="form-group">
                                                    <label for="">Name of Oerator:</label>
                                                        <select name="operator" class="form-control select2">
                                                            <option value="">None</option>
                                                           @foreach($activeOperators as $activeOperator)
                                                                <option value="{{$activeOperator->member_id}}">{{$activeOperator->full_name}}</option>
                                                            @endforeach
                                                        </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">

                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success" style="width:22%;">Restore</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </form>
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
        $('#archiveDriver').DataTable({
            'paging': true,
            'lengthChange': false,
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
