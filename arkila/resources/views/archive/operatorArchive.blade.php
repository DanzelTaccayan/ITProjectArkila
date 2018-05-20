@extends('layouts.master') 
@section('title', 'Operator Archive') 
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
                            <img class="profile-user-img img-responsive img-circle" src="" alt="Operator profile picture">
                            <hr> 
                            <div class="profile-btn-group">
                                <a href="#" class="btn btn-block btn-default btn-sm"><i class="fa fa-chevron-left"></i> <strong>Back</strong></a>
                            </div>   
                            <div style="margin: 15px;">
                                <ul class="nav nav-stacked" style="border: 1px solid lightgray;">
                                    <li class="active"><a href="#info" data-toggle="tab">Profile Information</a></li>
                                    <li><a href="#vans" data-toggle="tab">Vans<span class="badge badge-pill bg-orange pull-right">1</span></a></li>
                                    <li><a href="#drivers" data-toggle="tab">Drivers<span class="badge badge-pill bg-orange pull-right">2</span></a></li>
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-9"> 
                        <div class="nav-tabs-custom">
                            <div class="tab-content" style="height: 550px;">
                                <h3 class="profile-username"><strong>NAME</strong></h3> 
                                <div class="active tab-pane" id="info">
                                    <div style="margin-bottom: 3%;">
                                        <button onclick="window.open('')" class="btn btn-default btn-sm btn-flat pull-right"> <i class="fa fa-print"></i> PRINT INFORMATION</button>
                                        <h4>Personal Information</h4> 
                                    </div>

                                    <table class="table table-bordered table-striped table-responsive info-table">
                                        <tbody>
                                            <tr>
                                                <th>Contact Number</th>
                                                <td>093909003</td>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <td>32 nfsjefn nfieifn </td>
                                            </tr>
                                            <tr>
                                                <th>Provincial Address</th>
                                                <td>54 ngifgnfi in</td>
                                            </tr>
                                            <tr>
                                                <th>Gender</th>
                                                <td>MALE</td>
                                            </tr>
                                            <tr>
                                                <th>SSS No.</th>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th>License No.</th>
                                                <td>3432434234</td>
                                            </tr>
                                            <tr>
                                                <th>License Exp Date</th>
                                                <td>DATE</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <h4>Contact Person</h4>
                                    <table class="table table-bordered table-striped table-responsive info-table">
                                        <tbody>
                                            <tr>
                                                <th>Name</th>
                                                <td>NAMEsdsdsd</td>
                                            </tr>
                                            <tr>
                                                <th>Contact Number</th>
                                                <td>342342343</td>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <td>424324 gerg</td>
                                            </tr>
                                        </tbody>
                                    </table> 
                                </div>
                                <div class="tab-pane" id="vans">
                                    <table id="van" class="table table-bordered table-striped table-responsive info-table">
                                        <thead>
                                            <tr>
                                                <th style="width: 20%;">Plate Number</th>
                                                <th>Driver</th>
                                                <th>Model</th>
                                                <th style="width: 5%;">Seating Capacity</th>
                                                <th>Date Archived</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>AAA112</td>
                                                <td>YUKI MARFIL</td>
                                                <td>FD</td>
                                                <td class="text-right" style="width: 10px;">15</td>
                                                <td>Yung date</td>
                                            </tr>                                            
                                            
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="drivers">
                                    <table id="driver" class="table table-bordered table-striped table-responsive info-table">

                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Contact Number</th>
                                                <th>Date Archived</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>HEHE</td>
                                                <td>95868594645</td>
                                                <td>YUNG DATE</td>
                                                <td> 
                                                    <div class="text-center">
                                                        <a href="" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> VIEW</a>

                                                    </div>                                                
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>                  
                                        <!-- /.tab-pane -->
                                </div>
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
            'lengthChange': true,
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