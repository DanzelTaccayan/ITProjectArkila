@extends('layouts.master')
@section('title', 'List of Rentals')
@section('content')
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
                                <th>Van</th>
                                <th>Driver</th>
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
                                <td>{{ $rental->van->plate_number }}</td>
                                @if ($rental->rent_type == 'Walk-in')
                                <td>{{ $rental->driver->full_name ?? 'None' }}</td>
                                @else
                                <td>{{ $rental->users->last_name ?? 'None' }}, {{ $rental->users->first_name ?? 'None'  }}</td>
                                @endif

                                <td>{{ $rental->status }}</td>
                                <td>
                                    <div class="text-center">
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#viewRental{{ $rental->rent_id }}">VIEW</button>
                                    <button class="btn btn-success btn-sm">ACCEPT</button>
                                    </div>
                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#acceptRental{{ $rental->rent_id }}">PAYMENT</button>
                                    </div>
                                 </td>   
                             @endforeach
                        </tbody>
                    </table>

                    <div class="modal fade" id="viewRental{{ $rental->rent_id }}">
                        <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">RENTAL DETAILS</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-striped table-bordered ">
                                            <tbody>
                                                <tr>
                                                    <th>Customer Name</th>
                                                    <td>{{ $rental->customer_name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Contact Number</th>
                                                    <td>{{ $rental->contact_number }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Destination</th>
                                                    <td>{{ $rental->destination }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Departure Date</th>
                                                    <td>{{ $rental->departure_date }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Departure Time</th>
                                                    <td>{{ $rental->departure_time }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    <td>{{ $rental->status }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Driver</th>
                                                    <td>{{ $rental->driver->full_name ?? 'None' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Van</th>
                                                    <td>{{ $rental->plate_number ?? 'None'}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Rental Fee</th>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th></th>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                                    </div>
                                </div>
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                    <div class="modal fade" id="acceptRental{{ $rental->rent_id }}">
                        <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">PAYMENT DETAILS</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-striped table-bordered ">
                                            <tbody>
                                                <tr>
                                                    <th>Customer Name</th>
                                                    <td>{{ $rental->customer_name }}</td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                                        <button type="submit" class="btn btn-success"><i class="fa fa-money"></i> Receive Payment</button> 
                                    </div>
                                </div>
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection @section('scripts') @parent
<script>
    $(function() {

        $('.rentalTable').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': true,
            'order': [[ 7, "asc" ]],
            'aoColumnDefs': [{
                'bSortable': false,
                'aTargets': [-1] /* 1st one, start by the right */
            }]
        })
    })
</script>
@endsection
