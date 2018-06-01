@extends('layouts.master')
@section('title', 'User Management')
@section('links')
@parent
<!-- additional CSS -->
<link rel="stylesheet" href="tripModal.css">

@stop
@section('content')
<div class="padding-side-15">
    <div>
        <h2 class="text-white">USER MANAGEMENT</h2>
    </div>
    <div class="box">
        <div class="col-xl-6">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_2" data-toggle="tab">DRIVER</a></li>
                    <li><a href="#tab_3" data-toggle="tab">CUSTOMER</a></li>
                </ul>

                <div class="tab-content">
                    <!-- /.tab-pane -->
                    <div class="tab-pane active" id="tab_2">


                        <div class="box-body">
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped dataTable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- driver -->
                                    @foreach($userDrivers as $userDriver)
                                    <tr>
                                        <td>{{strtoupper($userDriver->first_name)}} {{strtoupper($userDriver->last_name)}}</td>
                                        <td>{{$userDriver->username}}</td>
                                        <td class="center-block">
                                            <div class="text-center">
                                                <a href="/home/user-management/driver/{{$userDriver->id}}" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-cog"></i>MANAGE ACCOUNTS</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>


                    <div class="tab-pane" id="tab_3">
                        <div class="box-body">
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped dataTable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Email Address</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- customer -->
                                    @foreach($userCustomers as $userCustomer)
                                    <tr>
                                        <td>{{strtoupper($userCustomer->first_name)}} {{strtoupper($userCustomer->last_name)}}</td>
                                        <td>{{$userCustomer->username}}</td>
                                        <td>{{$userCustomer->email}}</td>
                                        <td class="center-block">
                                            <div class="text-center">
                                                <a href="/home/user-management/customer/{{$userCustomer->id}}" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-cog"></i>MANAGE ACCOUNTS</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>


                    <!-- /.box-body -->
                </div>
            </div>
            <!-- /.tab-pane -->
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent

    <script>
        $(function() {
            $('.dataTable').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': true,
                'aoColumnDefs': [{
                    'bSortable': false,
                    'aTargets': [-1] /* 1st one, start by the right */
                }]
            })

        });
    </script>

@endsection
