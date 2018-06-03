@extends('layouts.master') 
@section('title', 'Show Profile') 
@section('links')
@parent
<style>
    .info-table th{
        width:150px;
    }
    .profile-btn-group{
        padding-left:  25px;
        padding-right: 25px;
        margin-top: 10px;
    }
</style>
@endsection
@section('content')
    {{session(['opLink'=> Request::url()])}}

<div class="row">
    <!-- /.col -->
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="profile-side">   
                            <img class="profile-user-img img-responsive img-circle" src="{{ URL::asset('uploads/profilePictures/'.$operator->profile_picture) }}" alt="Operator profile picture">
                            <div class="profile-btn-group"> 
                                <a href="{{route('operators.edit',[$operator->member_id])}}" class="btn btn-block btn-primary btn-sm"><strong>Update Information</strong></a>
                            </div>
                            <hr> 
                            <div class="profile-btn-group">
                                <a href="{{route('operators.index')}}" class="btn btn-block btn-default btn-sm"><i class="fa fa-chevron-left"></i> <strong>Back</strong></a>
                            </div>   
                            <div style="margin: 15px;">
                                <ul class="nav nav-stacked" style="border: 1px solid lightgray;">
                                    <li class="active"><a href="#info" data-toggle="tab">Profile Information</a></li>
                                    <li><a href="#vans" data-toggle="tab">Vans<span class="badge badge-pill bg-orange pull-right">{{count($operator->van->where('status','Active'))}}</span></a></li>
                                    <li><a href="#drivers" data-toggle="tab">Drivers<span class="badge badge-pill bg-orange pull-right">{{count($operator->drivers->where('status','Active'))}}</span></a></li>
                                    <li><a href="#archivedVans" data-toggle="tab">Archived Vans<span class="badge badge-pill bg-red pull-right">{{$operator->archivedVan->count()}}</span></a></li>
                                    <li><a href="#archivedDrivers" data-toggle="tab">Archived Drivers<span class="badge badge-pill bg-red pull-right">{{$operator->archivedDriver->count()}}</span></a></li>
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-9"> 
                        <div class="nav-tabs-custom">
                            <div class="tab-content" style="height: 550px;">
                                <h3 class="profile-username"><strong>{{trim(strtoupper($operator->full_name))}}</strong></h3> 
                                <div class="active tab-pane" id="info">
                                    <div style="margin-bottom: 3%;">
                                        <button onclick="window.open('{{route('pdf.perOperator', [$operator->member_id])}}')" class="btn btn-default btn-sm btn-flat pull-right"> <i class="fa fa-print"></i> PRINT INFORMATION</button>
                                        <h4>Personal Information</h4> 
                                    </div>

                                    <table class="table table-bordered table-striped table-responsive info-table">
                                        <tbody>
                                            <tr>
                                                <th>Contact Number</th>
                                                <td>{{ $operator->contact_number }}</td>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <td>{{ $operator->address }}</td>
                                            </tr>
                                            <tr>
                                                <th>Provincial Address</th>
                                                <td>{{ $operator->provincial_address }}</td>
                                            </tr>
                                            <tr>
                                                <th>Gender</th>
                                                <td>{{ $operator->gender }}</td>
                                            </tr>
                                            <tr>
                                                <th>SSS No.</th>
                                                <td>{{$operator->SSS}}</td>
                                            </tr>
                                            <tr>
                                                <th>License No.</th>
                                                <td>{{$operator->license_number}}</td>
                                            </tr>
                                            <tr>
                                                <th>License Exp Date</th>
                                                <td>{{$operator->expiry_date}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <h4>Contact Person</h4>
                                    <table class="table table-bordered table-striped table-responsive info-table">
                                        <tbody>
                                            <tr>
                                                <th>Name</th>
                                                <td>{{$operator->person_in_case_of_emergency}}</td>
                                            </tr>
                                            <tr>
                                                <th>Contact Number</th>
                                                <td>{{$operator->emergency_contactno}}</td>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <td>{{$operator->emergency_address}}</td>
                                            </tr>
                                        </tbody>
                                    </table> 
                                </div>
                                <div class="tab-pane" id="vans">
                                    <div class="col-md-6">
                                        <a href="{{route('vans.createFromOperator',$operator->member_id)}}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-plus"></i> ADD VAN</a>
                                    </div>
                                    <table id="van" class="table table-bordered table-striped table-responsive info-table">
                                        <thead>
                                            <tr>
                                                <th style="width: 20%;">Plate Number</th>
                                                <th>Driver</th>
                                                <th>Model</th>
                                                <th style="width: 5%;">Seating Capacity</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($operator->van->where('status', 'Active') as $van)
                                            <tr>
                                                <td class="text-uppercase">{{$van->plate_number}}</td>
                                                <td class="text-uppercase">{{$van->driver()->first()->full_name ?? $van->driver()->first()}}</td>
                                                <td class="text-uppercase">{{$van->model->description}}</td>
                                                <td class="text-right" style="width: 10px;">{{$van->seating_capacity}}</td>
                                                <td>
                                                    <div class="text-center">
                                                        <a href="{{ route('vans.edit',[$van->van_id] ) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> EDIT</a>
                                                        <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#{{ 'deleteVan'.$van->van_id }}"><i class="fa fa-trash"></i>DELETE</button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="drivers">
                                    <div class="col-md-6">
                                        <a href="{{route('drivers.createFromOperator',[$operator->member_id])}}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-plus"></i> ADD DRIVER</a>
                                    </div>
                                    <table id="driver" class="table table-bordered table-striped table-responsive info-table">

                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Contact Number</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($operator->drivers->where('status', 'Active') as $driver)
                                            <tr>
                                                <td>{{$driver->member_id}}</td>
                                                <td class="text-uppercase">{{$driver->full_name}}</td>
                                                <td>{{$driver->contact_number}}</td>
                                                <td>
                                                    <div class="text-center">
                                                        <a href="{{route('drivers.show',[$driver->member_id])}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> VIEW</a>
                                                       
                                                        <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#{{ 'deleteDriver'.$driver->member_id }}"><i class="fa fa-trash"></i> DELETE</button>
                                                    </div>                                                
                                                </td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>                  
                                        <!-- /.tab-pane -->
                                </div>
                                <div class="tab-pane" id="archivedVans">
                                    <table id="archiveVan" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Plate Number</th>
                                            <th>Model</th>
                                            <th>Seating Capacity</th>
                                            <th>Date Archived</th>  
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($operator->archivedVan as $archivedVan)
                                                <tr>
                                                    <td>{{$archivedVan->plate_number}}</td>
                                                    <td>{{$archivedVan->model->description}}</td>
                                                    <td class="text-right" style="width: 10px;">{{$archivedVan->seating_capacity}}</td>
                                                    <td>{{$archivedVan->archivedAt->created_at->format('h:i A')." of ".$archivedVan->archivedAt->created_at->format('M d, Y')}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="archivedDrivers">
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
                                            @foreach($operator->archivedDriver as $archivedDriver)
                                                <tr>
                                                    <td class="text-uppercase">{{$archivedDriver->full_name}}</td>
                                                    <td class="text-uppercase">{{$archivedDriver->address}}</td>
                                                    <td>{{$archivedDriver->contact_number}}</td>
                                                    <td>{{$archivedDriver->archivedAt->created_at->format('h:i A')." of ".$archivedDriver->archivedAt->created_at->format('M d, Y')}}</td>
                                                    <td>
                                                        <div class="text-center">
                                                            <a href="{{route('drivers.show',[$archivedDriver->member_id])}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> VIEW</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                                <!-- /.tab-content -->          
                        </div>
                        <!-- /.nav-tabs-custom -->
                    </div>
                </div>

                @foreach($operator->van->where('status', 'Active') as $van)
                    <div class="modal" id="{{ 'deleteVan'. $van->van_id }}">
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
                                    <h4 class="text-center "><strong class="text-red">{{$van->plate_number}}</strong>?</h4>
                                </div>
                                <div class="modal-footer">
                                    <form name="archiveVanForm" method="POST" action="{{route('vans.archiveVan',[$van->van_id])}}">
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

                @foreach($operator->drivers->where('status', 'Active') as $driver)
                    <div class="modal" id="{{ 'deleteDriver'.$driver->member_id }}">
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
                                    <form name="archiveDriverForm" action="{{route('drivers.archiveDriver',[$driver->member_id])}}" method="POST">
                                        {{ csrf_field() }}
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
            @include('layouts.partials.preloader_div')
    </div>    
    <!-- /.col -->
</div>
<!-- /.row -->

    

@stop 
@section('scripts') 
@parent

<!-- DataTables -->
<script src="{{ URL::asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
    $(function() {
        $('form[name="archiveVanForm"]').on('submit',function () {
            $(this).find('button[type="submit"]').prop('disabled',true);
            $('#submit-loader').removeClass('hidden');
            $('#submit-loader').css("display","block");
            $('.modal').modal('hide');
        });

        $('form[name="archiveDriverForm"]').on('submit',function () {
            $(this).find('button[type="submit"]').prop('disabled',true);
            $('#submit-loader').removeClass('hidden');
            $('#submit-loader').css("display","block");
            $('.modal').modal('hide');
        });

        $('#driver').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': true,
            'order': [[ 0, "desc" ]],
            'aoColumnDefs': [{
                'bSortable': false,
                'aTargets': [-1] /* 1st one, start by the right */
            }]
        })
        $('#van').DataTable({
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
        $('#archiveDriver').DataTable({
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