@extends('layouts.master')
@section('title', 'List of Rentals')
@section('content')
<div class="padding-side-10">
    <div class="box box-solid with-shadow" style="height: 300px; padding: 50px;">
        <div class="box-body">
            
        </div>
    </div>
</div>
<div class="padding-side-5">
    <div>
        <h2 class="text-white">RENTALS</h2>
    </div>
    <div class="box">
        <div class="box-body with-shadow">
            <div class="col-xl-6">
                <!-- Custom Tabs -->
                <div class="table-responsive">
                    <div class="col-md-6">
                        <a href="/home/rental/create" class="btn btn-success btn-sm btn-flat"><i class="fa fa-plus"></i> ADD RENTAL</a>
                    </div>
                    <table class="table table-bordered table-striped rentalTable">
                        <thead>
                            <tr>
                                <th>Customer Name</th>
                                <th>Destination</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Contact Number</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rentals as $rental)
                               <tr>
                                    <td>{{ $rental->customer_name }}</td>
                                    <td>{{ $rental->destination }}</td>
                                    <td>{{ $rental->departure_date->formatLocalized('%d %B %Y') }}</td>
                                    <td>{{ date('g:i A', strtotime($rental->departure_time)) }}</td>
                                    <td>{{ $rental->contact_number }}</td>
                                    <td>{{ $rental->status }}</td>
                                    <td>
                                        <div class="text-center">
                                            <a href="{{route('rental.show', $rental->rent_id)}}" class="btn btn-primary btn-sm">VIEW</a>
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
<script>
    $(function() {

        $('.rentalTable').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': true
        })
    })
</script>
@endsection
