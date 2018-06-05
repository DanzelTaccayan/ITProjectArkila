@extends('layouts.master')
@section('title', 'List of Rentals')
@section('content')
@if(!$rule)
<div class="padding-side-10">
    <div class="box box-solid with-shadow" style="height: 300px; padding: 50px; margin-top:7%;">
        <div class="box-body">
            <div class="text-center">
                <h1><i class="fa fa-warning text-yellow"></i> NO RENTAL RULES</h1>
                <h4>PLEASE SET UP THE RULES FOR RENTAL FIRST BEFORE USING THE RENTAL FEAUTURE.</h4>
                <a href="{{route('bookingRules.index')}}" class="btn btn-success btn-flat"  style="margin-top: 3%;">GO TO BOOKING RULES</a>
            </div>
        </div>
    </div>
</div>
@else
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
@endif
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
