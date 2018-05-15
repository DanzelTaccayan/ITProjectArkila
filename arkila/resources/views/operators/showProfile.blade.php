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
                                <a href="{{route('archive.vanDriver',[$operator->member_id])}}" class="btn btn-block btn-info btn-sm"><strong>Archive</strong></a>
                            </div>
                            <hr> 
                            <div class="profile-btn-group">
                                <a href="#" class="btn btn-block btn-default btn-sm"><i class="fa fa-chevron-left"></i> <strong>Back</strong></a>
                            </div>   
                            <div style="margin: 15px;">
                                <ul class="nav nav-stacked" style="border: 1px solid lightgray;">
                                    <li class="active"><a href="#info" data-toggle="tab">Profile Information</a></li>
                                    <li><a href="#vans" data-toggle="tab">Vans<span class="badge badge-pill bg-red pull-right">{{count($operator->van)}}</span></a></li>
                                    <li><a href="#drivers" data-toggle="tab">Drivers<span class="badge badge-pill bg-orange pull-right">{{count($operator->drivers)}}</span></a></li>
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
                                                <td>{{$van->plate_number}}</td>
                                                <td>{{$van->driver()->first()->full_name ?? $van->driver()->first()}}</td>
                                                <td>{{$van->model->description}}</td>
                                                <td class="text-right" style="width: 10px;">{{$van->seating_capacity}}</td>
                                                <td>
                                                    <div class="text-center">
                                                        <a href="{{ route('vans.edit',[$van->plate_number] ) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> EDIT</a>
                                                        <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#{{ 'deleteVan'.$van->plate_number }}"><i class="fa fa-trash"></i> DELETE</button>
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                            <!--DELETE MODAL MIGUEL-->
                                            <div class="modal fade" id="{{ 'deleteVan'. $van->plate_number }}">
                                                <div class="modal-dialog">
                                                    <div class="col-md-offset-2 col-md-8">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-red">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title"> Confirm</h4>
                                                            </div>
                                                            <div class="modal-body row" style="margin: 0% 1%;">
                                                               <div class="col-md-2" style="font-size: 35px; margin-top: 7px;">
                                                                   <i class="fa fa-exclamation-triangle pull-left" style="color:#d9534f;">  </i>
                                                               </div>
                                                               <div class="col-md-10">
                                                                <p style="font-size: 110%;">Are you sure you want to delete "{{$van->plate_number}}"</p>
                                                               </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                
                                                               <form method="POST" action="{{route('vans.archiveVan',[$van->plate_number])}}">
                                                                    {{csrf_field()}}
                                                                    {{method_field('PATCH')}}

                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                                                    <button type="submit" class="btn btn-danger" style="width:22%;">Delete</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.col -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                            <!-- /.modal -->
                                            
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
                                                <td>{{$driver->full_name}}</td>
                                                <td>{{$driver->contact_number}}</td>
                                                <td>

                                                    
                                                        <div class="text-center">
                                                            <a href="{{route('drivers.show',[$driver->member_id])}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> VIEW</a>
                                                           
                                                            <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#{{ 'deleteDriver'.$operator->member_id }}"><i class="fa fa-trash"></i>  DELETE</button>
                                                        </div>                                                
                                                </td>
                                            </tr>
                                            
                                            <!--DELETE MODAL MIGUEL-->
                                            <div class="modal fade" id="{{ 'deleteDriver'.$operator->member_id }}">
                                                <div class="modal-dialog">
                                                    <div class="col-md-offset-2 col-md-8">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-red">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                                </button>
                                                                <h4 class="modal-title"> Confirm</h4>
                                                            </div>
                                                            <div class="modal-body row" style="margin: 0% 1%;">
                                                               <div class="col-md-2" style="font-size: 35px; margin-top: 7px;">
                                                                   <i class="fa fa-exclamation-triangle pull-left" style="color:#d9534f;">  </i>
                                                               </div>
                                                               <div class="col-md-10">
                                                                <p style="font-size: 110%;">Are you sure you want to delete "{{ $driver->full_name }}"</p>
                                                               </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form action="{{route('drivers.archiveDriver',[$driver->member_id])}}" method="POST">
                                                                     {{ csrf_field() }} {{method_field('PATCH')}}
                                                                    
                                                                    <button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal">No</button>
                                                                    <button type="submit" class="btn btn-danger btn-sm btn-flat" style="width:22%;">Delete</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.col -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                            <!-- /.modal -->
                                            @endforeach

                                        </tbody>
                                    </table>                  
                                        <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                                <!-- /.tab-content -->          
                        </div>
                        <!-- /.nav-tabs-custom -->
                    </div>
                </div>
        </div>
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
    });

</script>

@stop