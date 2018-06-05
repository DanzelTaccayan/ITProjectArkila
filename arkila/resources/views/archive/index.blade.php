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
                <button onclick="window.open('{{route('pdf.drivers')}}')"  class="btn btn-default btn-sm btn-flat"> <i class="fa fa-print"></i> PRINT</button>
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
                        <td class="text-uppercase">{{ $operator->full_name }}</td>
                        <td>{{ $operator->contact_number }}</td>
                        <td class="text-uppercase">{{ $operator->address }}</td>
                        <td>{{$operator->updated_at->format('h:i A')." of ".$operator->updated_at->format('M d, Y')}}</td>
                        <td>
                            @php
                                $archivedDrivers = $operator->archivedDriver->count();
                                $archivedVans = $operator->archivedVan->count();
                                $trips = $operator->trips->count();

                                if($archivedDrivers || $archivedVans || $trips) {
                                    $result = '#unable'.$operator->member_id;
                                } else {
                                    $result = '#delete'.$operator->member_id;
                                }

                            @endphp

                            <div class="text-center">
                                <a href="{{ route('archive.showArchivedProfileOperator', [$operator->member_id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> VIEW</a>
                                <a href="" class="btn btn-success btn-sm" data-toggle="modal" data-target="#{{'restoreOperator'.$operator->member_id}}"><i class="fa fa-undo"></i> RESTORE</a>
                                <button type="button" data-toggle="modal" data-target="{{$result}}" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> DELETE</button>
                            </div>
                            <!-- /.text -->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <!-- /.box-body -->
            @foreach ($operators as $operator)
                <div class="modal" id="{{'restoreOperator'.$operator->member_id}}">
                    <form name="restoreOperatorForm" action="{{route('operators.restoreArchivedOperator',[$operator->member_id])}}" method="POST">
                        {{csrf_field()}}
                        {{method_field('PATCH')}}
                        <div class="modal-dialog" style="margin-top: 10%;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h1 class="text-center text-green"><i class="fa fa-undo"></i> RESTORE</h1>
                                    <p class="text-center">ARE YOU SURE YOU WANT TO RESTORE <strong class="text-green">{{ $operator->full_name }}</strong>?</p>
                                </div>
                                <div class="modal-footer">
                                    <div class="text-center">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                                        <button type="submit" class="btn btn-success">RESTORE</button>
                                    </div>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                    </div>
                </form>
                <!-- /.modal-dialog -->
                </div>
                <!--delete modal -->
                <div class="modal" id="delete{{$operator->member_id}}">
                    <div class="modal-dialog" style="margin-top: 10%;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body">
                                <h1 class="text-center text-red"><i class="fa fa-trash"></i>DELETE</h1>
                                <p class="text-center">ARE YOU SURE YOU WANT TO PERMANENTLY DELETE</p>
                                <h4 class="text-center "><strong class="text-red">{{trim($operator->full_name)}}</strong>?</h4>
                            </div>
                            <div class="modal-footer">
                                <form name="deleteOperatorForm" action="{{route('operators.deleteOperator',[$operator->member_id])}}" method="POST">
                                    {{csrf_field()}}
                                    {{method_field('DELETE')}}
                                    <div class="text-center">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                                        <button type="submit" class="btn btn-danger">DELETE</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal" id="unable{{$operator->member_id}}">
                    <div class="modal-dialog" style="margin-top: 10%;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <h1 class="text-center text-red"><i class="fa fa-ban"></i> RESTRICTED</h1>
                                <h4 class="text-center">UNABLE TO DELETE <strong class="text-red">{{$operator->full_name}}</strong> PERMANENTLY.</h4>
                                <p class="text-center ">ONLY THOSE OPERATORS WHO HAVE NO RECORD OR TRANSACTION CAN BE DELETED.</p>
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
        <!-- /.box -->
        @include('layouts.partials.preloader_div')
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
        $('form[name="restoreOperatorForm"]').on('submit',function () {
            $(this).find('button[type="submit"]').prop('disabled',true);
            $('#submit-loader').removeClass('hidden');
            $('#submit-loader').css("display","block");
            $('.modal').modal('hide');
        });

        $('form[name="deleteOperatorForm"]').on('submit',function () {
            $(this).find('button[type="submit"]').prop('disabled',true);
            $('#submit-loader').removeClass('hidden');
            $('#submit-loader').css("display","block");
            $('.modal').modal('hide');
        });

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
