@extends('layouts.master') 
@section('title', 'Operator Archive') 
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

                <h3 class="profile-username text-center">{{ $archive->operator->full_name }}</h3>
                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>Contact Number</b> <p class="pull-right">{{ $archive->operator->contact_number }}</p>
                    </li>
                    <li class="list-group-item">
                        <b>Number of Vans</b> <p class="pull-right">{{ count($archive->archiveVan) }}  </p>
                    </li>
                    <li class="list-group-item">
                        <b>Number of Drivers</b> <p class="pull-right">{{ count($archive->driver_id) }}</p>
                    </li>
                </ul>
                <a href="{{route('operators.show',[$archive->operator->member_id])}}" class="btn btn-default btn-block"><b>View All Information</b></a>
                <a href="{{route('operators.destroy', [$archive->operator->member_id])}}" class="btn btn-block btn-danger"><b>Permanently Delete Operator</b></a>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

        
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="nav-tabs-custom" style="box-shadow: 0px 5px 10px gray;">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#drivers" data-toggle="tab">Drivers</a></li>
                <li><a href="#vans" data-toggle="tab">Vans</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="drivers">
                    <table id="driver" class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Contact Number</th>
                                <th>Van</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($drivers as $driver)
                            <tr>
                                <td>{{ $driver->drivers->full_name ?? $driver->drivers()->first() }}</td>
                                <td>{{ $driver->drivers()->first()->age ?? $driver->drivers()->first() }}</td>
                                <td>{{ $driver->drivers()->first()->contact_number ?? $driver->drivers()->first() }}</td>
                                <td>{{ $driver->archiveVan()->first()->plate_number ?? $driver->archiveVan()->first() }}</td>
                                <td>
                        
                                    
                                        <div class="text-center">
                                
                                            <a href="#" class="btn btn-default"><i class="fa fa-eye"></i>View</a>
                                           
                                            <button class="btn btn-danger" data-toggle="modal" data-target="#"><i class="fa fa-trash"></i> Delete</button>
                                        </div>                                                
                                </td>
                            </tr>
                            @endforeach
                            <!--DELETE MODAL MIGUEL-->
                            <div class="modal fade" id="">
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
                                                <p style="font-size: 110%;">Are you sure you want to delete ""</p>
                                               </div>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="" method="POST">
                                                  
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
                          

                        </tbody>
                    </table>                  
                        <!-- /.tab-pane -->
                </div>
                
                <div class="tab-pane" id="vans">
                    <table id="van" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Plate Number</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($archive->archiveVan as $vans)
                            <tr>
                                <td>{{ $vans->plate_number }}</td>
                                <td>
                                    <div class="text-center">
                                            
                                            <a data-val='' name="vanInfo" class="btn btn-default" data-toggle="modal" data-target="#modal-view"><i class="fa fa-eye"></i>View</a>
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
                <!-- /.tab-pane -->
            </div>
                <!-- /.tab-content -->          
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    @endsection

    @section('scripts') 
    @parent

    <!-- DataTables -->
    <script>
        $(function() {
            $('#driver').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': true
            })
            $('#van').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': true
            })
        });

    </script>

    @stop
