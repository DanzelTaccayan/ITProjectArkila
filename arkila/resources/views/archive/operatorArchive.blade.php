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
                            <img class="profile-user-img img-responsive img-circle" src="{{ URL::asset('uploads/profilePictures/'.$archivedOperator->profile_picture) }}" alt="Operator profile picture">
                            <hr> 
                            <div class="profile-btn-group">
                                <a href="#" class="btn btn-block btn-default btn-sm"><i class="fa fa-chevron-left"></i> <strong>Back</strong></a>
                            </div>   
                            <div style="margin: 15px;">
                                <ul class="nav nav-stacked" style="border: 1px solid lightgray;">
                                    <li class="active"><a href="#info" data-toggle="tab">Profile Information</a></li>
                                    <li><a href="#vans" data-toggle="tab">Vans<span class="badge badge-pill bg-orange pull-right">{{$archivedOperator->archivedVan->count()}}</span></a></li>
                                    <li><a href="#drivers" data-toggle="tab">Drivers<span class="badge badge-pill bg-orange pull-right">{{$archivedOperator->archivedDriver->count()}}</span></a></li>
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-9"> 
                        <div class="nav-tabs-custom">
                            <div class="tab-content" style="height: 550px;">
                                <h3 class="profile-username"><strong>{{$archivedOperator->full_name}}</strong></h3>
                                <div class="active tab-pane" id="info">
                                    <div style="margin-bottom: 3%;">
                                        <button onclick="window.open('')" class="btn btn-default btn-sm btn-flat pull-right"> <i class="fa fa-print"></i> PRINT INFORMATION</button>
                                        <h4>Personal Information</h4> 
                                    </div>

                                    <table class="table table-bordered table-striped table-responsive info-table">
                                        <tbody>
                                            <tr>
                                                <th>Contact Number</th>
                                                <td>{{$archivedOperator->contact_number}}</td>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <td>{{$archivedOperator->address}} </td>
                                            </tr>
                                            <tr>
                                                <th>Provincial Address</th>
                                                <td>{{$archivedOperator->provincial_address}}</td>
                                            </tr>
                                            <tr>
                                                <th>Gender</th>
                                                <td>{{$archivedOperator->gender}}</td>
                                            </tr>
                                            <tr>
                                                <th>SSS No.</th>
                                                <td>{{$archivedOperator->SSS}}</td>
                                            </tr>
                                            <tr>
                                                <th>License No.</th>
                                                <td>{{$archivedOperator->license_number}}</td>
                                            </tr>
                                            <tr>
                                                <th>License Exp Date</th>
                                                <td>{{$archivedOperator->expiry_date}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <h4>Contact Person</h4>
                                    <table class="table table-bordered table-striped table-responsive info-table">
                                        <tbody>
                                            <tr>
                                                <th>Name</th>
                                                <td>{{$archivedOperator->person_in_case_of_emergency}}</td>
                                            </tr>
                                            <tr>
                                                <th>Contact Number</th>
                                                <td>{{$archivedOperator->contact_number}}</td>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <td>{{$archivedOperator->emergency_address}}</td>
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
                                        @foreach($archivedOperator->archivedVan as $archivedVan)
                                            <tr>
                                                <td>{{$archivedVan->plate_number}}</td>
                                                <td>{{$archivedVan->archivedMember->where('role','Driver')->first()->full_name ?? null}}</td>
                                                <td>{{$archivedVan->model->description}}</td>
                                                <td class="text-right" style="width: 10px;">{{$archivedVan->seating_capacity}}</td>
                                                <td>{{$archivedVan->updated_at->format('h:i A')." of ".$archivedVan->updated_at->format('M d, Y')}}</td>
                                            </tr>
                                        @endforeach
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

                                            @foreach($archivedOperator->archivedDriver as $archivedDriver)
                                                <tr>
                                                    <td>{{$archivedDriver->member_id}}</td>
                                                    <td>{{$archivedDriver->full_name}}</td>
                                                    <td>{{$archivedDriver->contact_number}}</td>
                                                    <td>{{$archivedDriver->updated_at->format('h:i A')." of ".$archivedDriver->updated_at->format('M d, Y')}}</td>
                                                    <td>
                                                        <div class="text-center">
                                                            <a href="{{route('drivers.show',[$archivedDriver->member_id])}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> VIEW</a>

                                                        </div>
                                                    </td>
                                            </tr>
                                            @endforeach


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