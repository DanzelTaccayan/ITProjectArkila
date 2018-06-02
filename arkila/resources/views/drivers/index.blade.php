@extends('layouts.master') 
@section('title', 'List of Drivers') 
@section('content-header', 'List of Drivers') 
@section('content')
@if(session()->get('opLink')) {{ session()->forget('opLink') }} 
@endif
<div class="padding-side-5">
    <div>
        <h2 class="text-white">LIST OF DRIVERS</h2>
    </div>
    <div class="box">
        <div class="box-body with-shadow">
            <div class="table-responsive">
                 <div class="col-md-6">
                    <a href="{{route('drivers.create')}}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-plus"></i> REGISTER DRIVER</a>
                    <a href="{{route('archive.showAllArchivedDriver')}}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-archive"></i> ARCHIVE</a>
                    <button onclick="window.open('{{route('pdf.drivers')}}')"  class="btn btn-default btn-sm btn-flat"> <i class="fa fa-print"></i> PRINT</button>
                </div>
                <table id="driverList" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Operator</th>
                            <th>Contact Number</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($drivers->where('status','Active')->sortByDesc('member_id') as $driver)
                        <tr>
                            <th>{{$driver->member_id}}</th>
                            <td>{{trim(strtoupper($driver->full_name ?? null))}}</td>
                            <td>{{trim(strtoupper($driver->operator->full_name ?? null)) }}</td>
                            <td>{{$driver->contact_number}}</td>
                            <td>
                                <div class="text-center">
                                    <a href="{{route('drivers.show',[$driver->member_id])}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> VIEW</a>
                                    
                                    <button type="button" data-toggle="modal" data-target="#{{'deleteWarning'.$driver->member_id}}" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> DELETE</button>
                                </div>
                                <!-- /.text-->
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.box-body -->
        @foreach($drivers->where('status','Active')->sortByDesc('member_id') as $driver)
        <div class="modal" id="{{'deleteWarning'.$driver->member_id}}">
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
                        <h4 class="text-center "><strong class="text-red">{{trim($driver->full_name)}}</strong>?</h4>
                    </div>
                    <div class="modal-footer">
                        <form action="{{route('drivers.archiveDriver', $driver->member_id)}}" method="POST">
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
    <!-- /.box-->
</div>

@stop 
@section('scripts') 
@parent

<script>
    $(function() {
        $('#driverList').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            'order': [[ 0, "desc" ]],
            'aoColumnDefs': [
                { 'bSortable': false, 'aTargets': [-1]}             
            ]
        });

    })
</script>

@stop