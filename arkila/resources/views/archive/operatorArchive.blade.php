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

                <h3 class="profile-username text-center">{{ $archive->full_name }}</h3>
                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>Contact Number</b> <p class="pull-right">{{ $archive->contact_number }}</p>
                    </li>
                    <li class="list-group-item">
                        <b>Number of Vans</b> <p class="pull-right">{{ count($archive->archivedVan) }}  </p>
                    </li>
                    <li class="list-group-item">
                        <b>Number of Drivers</b> <p class="pull-right">{{ count($archive->archivedDriver) }}</p>
                    </li>
                    <li class="list-group-item">
                        <b>Date Archived</b> <p class="pull-right">{{ \Carbon\Carbon::parse($archive->created_at)->toDayDateTimeString() }}</p>
                    </li>
                </ul>
                <a href="{{route('operators.show',[$archive->member_id])}}" class="btn btn-primary btn-block btn-sm"><b>View All Information</b></a>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="nav-tabs-custom" style="box-shadow: 0px 5px 10px gray;">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#vans" data-toggle="tab">Vans</a></li>
                <li><a href="#drivers" data-toggle="tab">Drivers</a></li>
            </ul>
            <div class="tab-content">
                
                <div class="active tab-pane" id="vans">
                    <table id="van" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Plate Number</th>
                                <th>Model</th>
                                <th>Seating Capacity</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($archive->archivedVan as $vans)
                            <tr>
                                <td>{{ $vans->plate_number }}</td>
                                <td>{{$vans->vanmodel->description}}</td>
                                <td class="text-right">{{$vans->seating_capacity}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="tab-pane" id="drivers">
                    <table id="driver" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Contact Number</th>
                                <th>Van</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($archive->archivedDriver as $driver)
                            <tr>
                                <td>{{ $driver->first_name }}</td>
                                <td>{{ $driver->age }}</td>
                                <td>{{ $driver->contact_number }}</td>
                                <td>{{ $archive->archivedVan()->first()->plate_number ?? null }}</td>
                                <td>
                                    <div class="text-center">
                                        <a href="{{route('drivers.show',[$driver->member_id])}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i>View</a>
                                    </div>                                                
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>                 
                </div>
            </div>  
        </div>
    </div>
</div>

@endsection

@section('scripts') 
@parent

<!-- DataTables -->
<script>
    $(function() {
        $('#driver').DataTable({
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
        $('#van').DataTable({
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

@stop
