@extends('layouts.master')
@section('title', 'User Management')
@section('links')
@parent
<!-- additional CSS -->
<link rel="stylesheet" href="tripModal.css">

@stop
@section('content')
<div class="box">


        <div class="col-xl-6">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_2" data-toggle="tab">Driver</a></li>
                    <li><a href="#tab_3" data-toggle="tab">Customer</a></li>
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
                                        <td>{{$userDriver->first_name}} {{$userDriver->last_name}}</td>
                                        <td>{{$userDriver->username}}</td>
                                        <td class="center-block">
                                            <div class="text-center">
                                                <a href="/home/user-management/driver/{{$userDriver->id}}" class="btn btn-default"><i class="glyphicon glyphicon-cog"></i>Manage Account</a>
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
                                        <td>{{$userCustomer->first_name}} {{$userCustomer->last_name}}</td>
                                        <td>{{$userCustomer->username}}</td>
                                        <td>{{$userCustomer->email}}</td>
                                        <td class="center-block">
                                            <div class="text-center">
                                                <a href="/home/user-management/customer/{{$userCustomer->id}}" class="btn btn-default"><i class="glyphicon glyphicon-cog"></i>Manage Account</a>
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
        <!-- /.tab-content -->

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
