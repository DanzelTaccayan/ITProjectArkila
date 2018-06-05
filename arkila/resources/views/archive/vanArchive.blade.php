@extends('layouts.master')
@section('title', 'Van Archive')
@section('content')
    {{session(['opLink'=> Request::url()])}} 
 <div class="padding-side-5"> 
    <div>
        <h2 class="text-white">ARCHIVE OF VANS</h2>
    </div>
    <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
           <div class="table-responsive">
                <div class="col-md-6">
                    <a href="{{route('vans.index')}}" class="btn btn-info btn-sm btn-flat"><i class="fa  fa-chevron-left"></i> GO BACK TO VAN LIST</a>
                    <button onclick="window.open('')"  class="btn btn-default btn-sm btn-flat"> <i class="fa fa-print"></i> PRINT</button>
                </div>
                <table id="archiveVan" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Plate Number</th>
                            <th>Model</th>
                            <th>Seating Capacity</th>
                            <th>Date Archived</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($archivedVans as $archivedVan)
                                <tr>
                                    <td class="text-uppercase">{{$archivedVan->plate_number}}</td>
                                    <td class="text-uppercase">{{$archivedVan->model->description}}</td>
                                    <td class="text-right" style="width: 10px;">{{$archivedVan->seating_capacity}}</td>
                                    <td>{{$archivedVan->updated_at->format('h:i A')." of ".$archivedVan->updated_at->format('M d, Y')}}</td>
                                    <td>
                                        <div class="text-center">
                                            <a href="" class="btn btn-success btn-sm" data-toggle="modal" data-target="#{{'restoreDriver'.$archivedVan->van_id}}"><i class="fa fa-undo"></i> RESTORE</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <!--RESTORE MODAL-->
            @foreach($archivedVans as $archivedVan)
            <div class="modal" id="{{'restoreDriver'.$archivedVan->van_id}}">
                <form name="vanRestoreForm" method="POST" action="{{route('vans.restoreArchivedVan',[$archivedVan->van_id])}}">
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
                                <p class="text-center">RESTORE VAN UNIT<strong class="text-green text-uppercase"> {{$archivedVan->plate_number}} </strong>.</p>
                                <p class="text-center">CHOOSE OPERATOR</p>
                                <div class="form-group">
                                    <select name="operator" class="form-control select2">
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
        $('form[name="vanRestoreForm"]').on('submit',function () {
            $(this).find('button[type="submit"]').prop('disabled',true);
            $('#submit-loader').removeClass('hidden');
            $('#submit-loader').css("display","block");
            $('.modal').modal('hide');
        });

        $('#archiveVan').DataTable({
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
