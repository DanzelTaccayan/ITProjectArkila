@extends('layouts.master')
@section('title', 'Driver Report')
@section('links')
@parent
<!-- additional CSS -->
<link rel="stylesheet" href="tripModal.css">

@stop
@section('content')

<div class="padding-side-5">
    <div>
        <h2 class="text-white">DRIVER REPORT</h2>
    </div>

    <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
            <table id="driversTrips" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Trip ID</th>
                        <th>Van</th>
                        <th>Driver</th>
                        <th>Departed at</th>
                        <th>Destination</th>
                        <th>Daparture date</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trips as $trip)
                    <tr>
                        <td>{{$trip->trip_id}}</td>
                        <td>{{$trip->van->plate_number}}</td>
                        <td>{{$trip->driver->first_name . " " . $trip->driver->middle_name . " " . $trip->driver->last_name}}</td>
                        <td>{{$trip->origin}}</td>
                        <td>{{$trip->destination}}</td>
                        <td>{{$trip->time_departed}} of {{$trip->date_departed}}</td>
                        <th>{{$trip->report_status}}</th>
                        <td>
                            <div class="text-center">
                               <a href="{{route('trips.viewReport', [$trip->trip_id])}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> VIEW</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@section('scripts')
@parent

<script>
    $(function() {
        $('#driversTrips').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            'order': [
                [0, "desc"]
            ],
            'aoColumnDefs': [{
                'bSortable': false,
                'aTargets': [-1]
            }]
        })
    });
</script>

@endsection
