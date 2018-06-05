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
                    <button onclick="window.open('')"  class="btn btn-default btn-sm btn-flat"> <i class="fa fa-print"></i> PRINT</button>
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
                                <td class="text-uppercase">{{$archivedDriver->full_name}}</td>
                                <td class="text-uppercase">{{$archivedDriver->address}}</td>
                                <td>{{$archivedDriver->contact_number}}</td>
                                <td>{{$archivedDriver->updated_at->format('h:i A')." of ".$archivedDriver->updated_at->format('M d, Y')}}</td>
                                <td>
                                    <div class="text-center">
                                        <a href="{{route('drivers.show',[$archivedDriver->member_id])}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> VIEW</a>
                                        <a href="" class="btn btn-success btn-sm" data-toggle="modal" data-target="#{{'restoreDriver'.$archivedDriver->member_id}}"><i class="fa fa-undo"></i> RESTORE</a>
                                        <button type="button" data-toggle="modal" data-target="#unable{{$archivedDriver->member_id}}" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> DELETE</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <!--RESTORE MODAL-->
            @foreach($archivedDrivers as $archivedDriver)
                <div class="modal" id="{{'restoreDriver'.$archivedDriver->member_id}}">
                <form name="driverRestoreForm" method="POST" action="{{route('drivers.restoreArchivedDriver',[$archivedDriver->member_id])}}">
                    {{csrf_field()}}
                    {{method_field('PATCH')}}
                    <div class="modal-dialog" style="margin-top: 10%;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body">
                                <h1 class="text-center text-green"><i class="fa fa-undo"></i> RESTORE</h1>
                                <h4 class="text-center">RESTORE <strong class="text-green text-uppercase">{{$archivedDriver->full_name}} </strong>AS A DRIVER.</h4>
                                <p class="text-center">CHOOSE OPERATOR</p>
                                <div class="form-group padding-side-25">
                                    <select name="operator" class="form-control select2">
                                        <option value="">None</option>
                                        @foreach($activeOperators as $activeOperator)
                                            <option value="{{$activeOperator->member_id}}">{{$activeOperator->full_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="text-center">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                                    <button type="submit" class="btn btn-success">RESTORE</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!--delete modal -->
            <div class="modal" id="delete{{$archivedDriver->member_id}}">
                <div class="modal-dialog" style="margin-top: 10%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <h1 class="text-center text-red"><i class="fa fa-trash"></i>DELETE</h1>
                            <p class="text-center">ARE YOU SURE YOU WANT TO PERMANENTLY DELETE</p>
                            <h4 class="text-center "><strong class="text-red">{{$archivedDriver->full_name}}</strong>?</h4>
                        </div>
                        <div class="modal-footer">
                            <form name="driverDeleteForm" action="{{route('drivers.deleteDriver',[$archivedDriver->member_id])}}" method="POST">
                                {{method_field('DELETE')}}
                                {{csrf_field()}}
                                <div class="text-center">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                                    <button type="submit" class="btn btn-danger">DELETE</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

             <div class="modal" id="unable{{$archivedDriver->member_id}}">
                <div class="modal-dialog" style="margin-top: 10%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <h1 class="text-center text-red"><i class="fa fa-ban"></i> RESTRICTED</h1>
                            <h4 class="text-center">UNABLE TO DELETE <strong class="text-red">{{$archivedDriver->full_name}}</strong> PERMANENTLY.</h4>
                            <p class="text-center ">ONLY THOSE DRIVERS WHO HAVE NO RECORD OR TRANSACTION CAN BE DELETED.</p>
                        </div>
                        <div class="modal-footer">
                                <div class="text-center">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
           @endforeach
        </div>
        @include('layouts.partials.preloader_div')
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
        $('form[name="driverRestoreForm"]').on('submit',function () {
            $(this).find('button[type="submit"]').prop('disabled',true);
            $('#submit-loader').removeClass('hidden');
            $('#submit-loader').css("display","block");
            $('.modal').modal('hide');
        });

        $('form[name="driverDeleteForm"]').on('submit',function () {
            $(this).find('button[type="submit"]').prop('disabled',true);
            $('#submit-loader').removeClass('hidden');
            $('#submit-loader').css("display","block");
            $('.modal').modal('hide');
        });

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
