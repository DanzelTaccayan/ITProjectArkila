@extends('layouts.master') 
@section('title', 'Show Profile') 
@section('links')
    @parent
    <style>
        .profile-user-img {
            height: 100px;
        }
    </style>
@endsection
@section('content')
    {{session(['opLink'=> Request::url()])}}

<div class="row">
    <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box box-primary" style = "box-shadow: 0px 5px 10px gray;">
            <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="{{ URL::asset('img/jl.JPG') }}" alt="Operator profile picture">

                <h3 class="profile-username text-center">{{ $operator->full_name }}</h3>
                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>Contact Number</b> <p class="pull-right">{{ $operator->contact_number }}</p>
                    </li>
                    <li class="list-group-item">
                        <b>Number of Vans</b> <p class="pull-right"> {{ count($operator->vans) }} </p>
                    </li>
                    <li class="list-group-item">
                        <b>Number of Drivers</b> <p class="pull-right">{{ count($operator->drivers) }}</p>
                    </li>
                </ul>
                <a href="{{route('operators.show',[$operator->member_id])}}" class="btn btn-info btn-block btn-sm"><b>View All Information</b></a>
                <a href="{{route('operators.edit',[$operator->member_id])}}" class="btn btn-block btn-primary btn-sm"><b>Edit Information</b></a>
                <a href="{{route('archive.vanDriver',[$operator->member_id])}}" class="btn btn-block btn-default btn-sm"><b>Archive</b></a>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

        
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="nav-tabs-custom" style="box-shadow: 0px 5px 10px gray;">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#vans" data-toggle="tab">Vans</a></li>
                <li><a href="#drivers" data-toggle="tab">Drivers</a></li>
            </ul>
            <div class="tab-content">
                
                 <div class="active tab-pane" id="vans">
                    <div class="col-md-6">
                        <a href="{{route('vans.createFromOperator',$operator->member_id)}}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus-circle"></i> Add Van</a>
                    </div>
                    <table id="van" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Plate Number</th>
                                <th>Driver</th>
                                <th>Model</th>
                                <th>Seating Capacity</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($operator->van->where('status', 'Active') as $van)
                            <tr>
                                <td>{{$van->plate_number}}</td>
                                <td>{{$van->driver()->first()->full_name ?? $van->driver()->first()}}</td>
                                <td>{{$van->vanmodel->description}}</td>
                                <td class="text-right">{{$van->seating_capacity}}</td>
                                <td>
                                    <div class="text-center">
                                        <a href="{{ route('vans.edit',[$van->plate_number] ) }}" class="btn btn-primary btn-sm"><i class="fa fa-user-plus"></i>EDIT</a>
                                        <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#{{ 'deleteVan'.$van->plate_number }}"><i class="fa fa-trash"></i> Delete</button>
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
                                                
                                               <form method="POST" action="{{route('vans.archiveDelete',[$van->plate_number])}}">
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
                       @if ($operator->drivers->count() < $operator->van->count())
                            <a href="{{route('drivers.createFromOperator',[$operator->member_id])}}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus-circle"></i> Add Driver</a>
                        @else
                            <a href="" class="btn btn-primary btn-sm btn-flat disabled"><i class="fa fa-plus-circle"></i> Add Driver </a>
                        @endif    
                    </div>
                    <table id="driver" class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Contact Number</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($operator->drivers->where('status', 'Active') as $driver)
                            <tr>
                                <td>{{$driver->member_id}}</td>
                                <td>{{$driver->full_name}}</td>
                                <td>{{$driver->age}}</td>
                                <td>{{$driver->contact_number}}</td>
                                <td>

                                    
                                        <div class="text-center">
                                            <a href="{{route('drivers.show',[$driver->member_id])}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i>View</a>
                                            
                                            <a href="{{route('drivers.edit',[$driver->member_id])}}" class="btn btn-outline-secondary btn-sm"><i class="fa fa-pencil-square-o"></i>Edit</a>
                                           
                                            <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#{{ 'deleteDriver'.$operator->member_id }}"><i class="fa fa-trash"></i> Delete</button>
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
                                                <form action="{{route('drivers.archiveDelete',[$driver->member_id])}}" method="POST">
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
        <!-- /.col -->
    </div>
    <!-- /.row -->

    

    @stop @section('scripts') @parent

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