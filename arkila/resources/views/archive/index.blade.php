@extends('layouts.master')
@section('title', 'Archive')
@section('content')
    {{session(['opLink'=> Request::url()])}} 
<div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#drivers" data-toggle="tab">Drivers</a></li>
                <li><a href="#vans" data-toggle="tab">Vans</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="drivers">
                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table table-bordered table-striped driverVan">

                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Contact Number</th>
                                        <th>Status</th>
                                        <th>Operator</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($drivers as $driver)
                                    <tr>
                                        <td>{{ $driver->full_name }}</td>
                                        <td>{{ $driver->age }}</td>
                                        <td>{{ $driver->contact_number }}</td>
                                        <td>{{ $driver->status }}</td>
                                        <td>{{ $driver->operator->full_name }}</td>
                                        <td>
                                
                                            
                                                <div class="text-center">
                                                    
                                                    <a href="#" class="btn btn-default"><i class="fa fa-eye"></i>View</a>
                                                   
                                                    <button class="btn btn-outline-danger" data-toggle="modal" data-target="#{{ 'deleteWarning'. $driver->member_id }}"><i class="fa fa-trash"></i> Delete</button>
                                                </div>
                                                
                                        </td>
                                    </tr>
                                    <!--DELETE MODAL MIGUEL-->
                                    <div class="modal fade" id="{{ 'deleteWarning'. $driver->member_id }}">
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
                                                        <p style="font-size: 110%;">Are you sure you want to delete "{{ $driver->full_name }}"</p>
                                                       </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        
                                                            <form method="POST" action="{{route('drivers.destroy',[$driver->member_id])}}">
                                                                {{csrf_field()}}
                                                                {{method_field('DELETE')}}
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                                                <button type="submit" class="btn btn-danger" style="width:22%;">Yes</button>
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
                            
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.tab-pane -->
                </div>
                
                <div class="tab-pane" id="vans">
                    <div class="box">
                        <div class="box-header">
                            
                        </div>
                        <div class="box-body">
                            <table  class="table table-bordered table-striped driverVan">
                                <thead>
                                    <tr>
                                        <th>Plate Number</th>
                                        <th>Driver</th>
                                        <th>Operator</th>
                                        <th>Model</th>
                                        <th>Seating Capacity</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vans as $van)
                                    <tr>
                                        <td>{{ $van->plate_number }}</td>
                                        <td>{{ $van->driver()->first()->full_name ?? $van->driver()->first() }}</td>
                                        <td>{{ $van->operator()->first()->full_name ??  $van->operator()->first() }}</td>
                                        <td>{{ $van->model }}</td>
                                        <td>{{ $van->seating_capacity }}</td>
                                        <td>
                                            <div class="text-center">
                                                 
                                                    <a data-val='#' name="vanInfo" class="btn btn-default" data-toggle="modal" data-target="#modal-view"><i class="fa fa-eye"></i>View</a>
                                                    <button class="btn btn-danger" data-toggle="modal" data-target="#deleteVan"><i class="fa fa-trash"></i> Delete</button>
                                                
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    
                                    <!--DELETE MODAL MIGUEL-->
                                    <div class="modal fade" id="deleteVan">
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
                                                        <p style="font-size: 110%;">Are you sure you want to delete "yung user para pogi"</p>
                                                       </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        
                                                   

                                                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                                        <button type="submit" class="btn btn-danger" style="width:22%;">Delete</button>

                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->
                                    
                                   
                                    
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.tab-pane -->
            </div>
                <!-- /.tab-content -->          
            </div>
            <!-- /.nav-tabs-custom -->
    @stop @section('scripts') @parent

    <!-- DataTables -->
    <script src="{{ URL::asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $(function() {
            $('.driverVan').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': true
            })
        });
    </script>    
        
@stop
