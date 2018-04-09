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
                <table id="driver" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Age</th>
                        <th>Contact Number</th>
                        <th>Date Archived</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($operator->archivedDriver as $driver)
                        <tr>
                            <td>{{$driver->full_name}}</td>
                            <td>{{$driver->address}}</td>
                            <td>{{$driver->age}}</td>
                            <td>{{ $driver->contact_number }}</td>
                            <td>{{ \Carbon\Carbon::parse($driver->created_at)->toDayDateTimeString() }}</td>
                            <td>
                                <div class="text-center">
                                    <a href="" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i>VIEW</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="tab-pane" id="vans"> 
                <table id="van" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Plate Number</th>
                        <th>Model</th>
                        <th>Seating Capacity</th>
                        <th>Date Archived</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($operator->archivedVan as $van)
                        <tr>
                            <td>{{$van->plate_number}}</td>
                            <td>{{$van->vanmodel->description}}</td>
                            <td class="text-right">{{$van->seating_capacity}}</td>
                            <td>{{ \Carbon\Carbon::parse($van->created_at)->toDayDateTimeString() }}</td>
                            <td>
                                <div class="text-center">
                                    <a data-val='#' class="btn btn-primary btn-sm"><i class="fa fa-eye"></i>View</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop 
@section('scripts') 
@parent

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
            'order': [[ 4, "desc" ]],
            'aoColumnDefs': [{
                'bSortable': false,
                'aTargets': [-1] 
            }]
        }),

        $('#van').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': true,
            'order': [[ 3, "desc" ]],
            'aoColumnDefs': [{
                'bSortable': false,
                'aTargets': [-1] 
            }]
        })
    });
</script>

@stop