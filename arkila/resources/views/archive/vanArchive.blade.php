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
                    <button onclick="window.open('')"  class="btn btn-default btn-sm btn-flat"> <i class="fa fa-print"></i> PRINT VAN ARCHIVE</button>
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
                                    <td>{{$archivedVan->plate_number}}</td>
                                    <td>{{$archivedVan->model->description}}</td>
                                    <td class="text-right" style="width: 10px;">{{$archivedVan->seating_capacity}}</td>
                                    <td>{{$archivedVan->updated_at->format('h:i A')." of ".$archivedVan->updated_at->format('M d, Y')}}</td>
                                    <td>
                                        <div class="text-center">
                                            <a href="" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> VIEW</a>
                                            <a href="" class="btn btn-success btn-sm"><i class="fa fa-eye"></i> RESTORE</a>
                                        </div>
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
</div>  
 
@stop 
@section('scripts') 
@parent

<!-- DataTables -->
<script src="{{ URL::asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
    $(function() {
        $('#archiveVan').DataTable({
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
