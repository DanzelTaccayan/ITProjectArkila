@extends('layouts.master')
@section('title', 'Trip Log')
@section('links')
@parent
<!-- additional CSS -->
<link rel="stylesheet" href="tripModal.css"> 

@stop
@section('content')

<div class="box">
    <!-- /.box-header -->
    <div class="box-body" style="box-shadow: 0px 5px 10px gray;">
        <div class="table-responsive">
        <table class="table table-bordered table-striped tripLog">
            <thead>
                <tr>
                    <th>Trip ID</th>
                    <th>Van</th>
                    <th>Driver</th>
                    <th>Departed at</th>
                    <th>Destination</th>
                    <th>Departure date</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trips as $trip)
                <tr>
                    <td>{{$trip->trip_id}}</td>
                    <td>{{$trip->plate_number}}</td>
                    <td>{{$trip->driver->first_name . " " . $trip->driver->middle_name . " " . $trip->driver->last_name}}</td>
                    <td>{{$superAdmin->description}}</td>
                    <td>{{$trip->terminal->description}}</td>
                    <td>{{$trip->time_departed}} of {{$trip->date_departed}} </td>
                    <td>
                        <div class="text-center">
                            <a href="{{route('trips.viewTripLog', [$trip->trip_id])}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> VIEW</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
    <!-- /.box-body -->
</div>

@endsection

@section('scripts') 
@parent

<!-- DataTables -->
<script src="{{ URL::asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
    $(function() {
        $('.tripLog').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            'order': [[ 0, "desc" ]],
            'aoColumnDefs': [
                { 'bSortable': false, 'aTargets': [-1]}
            ]
        })
    })
</script>

@endsection