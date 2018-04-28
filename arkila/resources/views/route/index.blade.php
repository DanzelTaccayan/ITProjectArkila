@extends('layouts.master') 
@section('title', 'Show Profile') 
@section('links')
@parent

@endsection
@section('content')


<div class="row">
    <!-- /.col -->
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="">
                            <a href="" class="btn btn-block btn-success btn-sm"> <i class="fa fa-plus"></i> <b>ADD TERMINAL</b></a>
                        </div>
                        <div class="" style="border: 1px solid lightgray; margin: 5px;">
                            <ul class="nav nav-stacked">
                                <li class="active"><a href="#vans" data-toggle="tab">BAGUIO - CABANATUAN<span class="badge badge-pill pull-right">12</span></a></li>
                                <li><a href="#drivers" data-toggle="tab">BAGUIO - SAN JOSE<span class="badge badge-pill  pull-right">31</span></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-9"> 
                        <div class="nav-tabs-custom">
                            <div class="tab-content">
                                
                                <div class="tab-pane active " id="vans">
                                    <h3 class="profile-username text-center"><strong>BAGUIO - CABANATUAN</strong></h3> 
                                    <div class="col-md-6">
                                        <a href="" class="btn btn-success btn-sm btn-flat"><i class="fa fa-plus"></i> ADD ROUTE</a>
                                    </div>
                                    <table id="van" class="table table-bordered table-striped table-responsive datatablesRoute">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Regular Fee</th>
                                                <th>Discounted Fee</th>  
                                                <th>Number of Tickets</th>
                                                <th class="text-center">Actions</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                              <tr>
                                                <td>Asigan</td>
                                                <td class="text-right">200</td>
                                                <td class="text-right">500</td>
                                                <td class="text-right">120</td>
                                                <td>
                                                    <div class="text-center">
                                                        <a href="" class="btn btn-primary btn-sm"><i class="fa fa-user-plus"></i> EDIT</a>
                                                        <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="HHE"><i class="fa fa-trash"></i> DELETE</button>
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                            <!--DELETE MODAL MIGUEL-->
                                            <div class="modal fade" id="#">
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
                                                                <p style="font-size: 110%;">Are you sure you want to delete ""</p>
                                                               </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                
                                                               <form method="POST" action="">
                                                                    <!-- {{csrf_field()}}
                                                                    {{method_field('PATCH')}} -->

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
                                </div>
                                <div class="tab-pane" id="drivers">
                                    <h3 class="profile-username text-center"><strong>BAGUIO - SAN JOSE CITY</strong></h3> 
                                    <div class="col-md-6"> 
                                        <a href="" class="btn btn-success btn-sm btn-flat"><i class="fa fa-plus"></i> ADD ROUTE</a>
                                    </div>
                                    <table class="table table-bordered table-striped table-responsive datatablesRoute">

                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Regular Fee</th>
                                                <th>Discounted Fee</th>  
                                                <th>Number of Tickets</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Asigan</td>
                                                <td class="text-right">200</td>
                                                <td class="text-right">500</td>
                                                <td class="text-right">120</td>
                                                <td>
                                                    <div class="text-center">
                                                        <a href="" class="btn btn-primary btn-sm"><i class="fa fa-user-plus"></i> EDIT</a>
                                                        <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="HHE"><i class="fa fa-trash"></i> DELETE</button>
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                            <!--DELETE MODAL MIGUEL-->
                                            <div class="modal fade" id="#">
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
                                                                     <!-- {{ csrf_field() }} {{method_field('PATCH')}} -->
                                                                    
                                                                    <button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal">No</button>
                                                                    <button type="submit" class="btn btn-danger btn-sm btn-flat" style="width:22%;">Delete</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </tbody>
                                    </table>                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>    
</div>


    

    @stop @section('scripts') @parent

    <!-- DataTables -->
    <script src="{{ URL::asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $(function() {
            $('.datatablesRoute').DataTable({
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
        
        });

    </script>

    @stop