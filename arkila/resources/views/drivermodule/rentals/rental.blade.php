@extends('layouts.driver')
@section('title', 'Driver Profile')
@section('content-title', 'Driver Home')
@section('content')
<div class="box">
    <div class="box-body">
<div class="table-responsive">
<table class="table table-bordered table-striped rentalTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Destination</th>
            <th>Date</th>
            <th>Time</th>
            <th>Contact Number </th>
            <th>Van Model </th>
            <th>Status</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rentals->sortByDesc('status') as $rental)
            @if ($rental->status == 'Pending' && ($rental->model_id == $model_id))
        <tr>
            <td>{{ $rental->rent_id }}</td>
            <td>{{ $rental->full_name }}</td>
            <td>{{ $rental->destination }}</td>
            <td>{{ $rental->departure_date }}</td>
            <td>{{ $rental->departure_time }}</td>
            <td>{{ $rental->contact_number }}</td>
            <td>{{ $rental->vanmodel->description ?? 'None' }}</td>
            <td>{{ $rental->status }}</td>
            <td class="center-block">
                <div class="text-center">

                    @if ($rental->status == 'Pending')
                    <form action="{{ route('drivermodule.updateRental', $rental->rent_id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <button class="btn btn-success btn-sm" name="click" onclick="return ConfirmStatus()" value="Accepted"><i class="fa fa-automobile"></i> Accept</button>

                    </form>


                    @endif

                </div>
            </td>
        </tr>
        @endif
        @if ($rental->driver_id == Auth::id() && $rental->model_id == $model_id)
        <tr>
            <td>{{ $rental->rent_id }}</td>
            <td>{{ $rental->full_name }}</td>
            <td>{{ $rental->destination }}</td>
            <td>{{ $rental->departure_date }}</td>
            <td>{{ $rental->departure_time }}</td>
            <td>{{ $rental->contact_number }}</td>
            <td>{{ $rental->vanmodel->description ?? 'None'}}</td>
            <td>{{ $rental->status }}</td>
            <td class="center-block">
                <div class="text-center">
                    @if ($rental->status == 'Pending')
                    <form action="{{ route('drivermodule.updateRental', $rental->rent_id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <button class="btn btn-success btn-sm" name="click" onclick="return ConfirmStatus()" value="Accepted"><i class="fa fa-automobile"></i> Accept</button>

                    </form>
                    @elseif($rental->status == 'Accepted')
                    <form action="{{ route('drivermodule.updateRental', $rental->rent_id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <button class="btn btn-success btn-sm" name="click" onclick="return ConfirmStatus()" value="Cancelled"><i class="fa fa-automobile"></i> Cancel</button>

                    </form>
                    @endif

                </div>
            </td>
        </tr>
        @endif
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

        $('.rentalTable').DataTable({
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
    })
</script>

@endsection
