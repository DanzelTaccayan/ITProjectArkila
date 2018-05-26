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
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rentals as $rental)
                               <tr>
                                    <td>{{ $rental->customer_name }}</td>
                                    <td>{{ $rental->destination }}</td>
                                    <td>{{ $rental->departure_date }}</td>
                                    <td>{{ $rental->departure_time }}</td>
                                    <td>{{ $rental->contact_number }}</td>
                                    <td>{{ $rental->status }}</td>
                                    <td>
                                        <div class="text-center">
                                            <a href="{{route('rental.show', $rental->rent_id)}}" class="btn btn-primary btn-sm">VIEW</a>
                                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#acceptRental{{ $rental->rent_id }}">ACCEPT</button>
                                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#payRental{{ $rental->rent_id }}">PAYMENT</button>
                                            <button class="btn bg-navy btn-sm" data-toggle="modal" data-target="#departRental{{ $rental->rent_id }}">DEPART</button>
                                        </div>
                                     </td>
                                 </tr>
                             @endforeach
                        </tbody>
                    </table>

                    <div class="modal fade" id="viewRental{{ $rental->rent_id }}">
                        <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">RENTAL DETAILS</h4>
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
                                                    <th>Comment</th>
                                                    <td>{{ $rental->comments}}</td>
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
                                    <div class="modal-header bg-green">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">ACCEPTANCE FORM</h4>
                                    </div>
                                    <form action="" class="form-horizontal">
                                        <div class="modal-body">
                                            <div class="padding-side-15">
                                                <table class="table table-striped table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <th>Destination</th>
                                                            <td>{{ $rental->destination }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Van Unit</th>
                                                            <td>
                                                                <select name="" id="" class="form-control">
                                                                    <option value=""></option>
                                                                    <option value=""></option>
                                                                    <option value=""></option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Driver</th>
                                                            <td>
                                                                <select name="" id="" class="form-control">
                                                                    <option value="">HALULUO DELA CRUZ</option>
                                                                    <option value=""></option>
                                                                    <option value=""></option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                                            <button type="submit" class="btn btn-success">Accept</button> 
                                        </div>
                                    </form>
                                </div>
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                    <div class="modal fade" id="payRental{{ $rental->rent_id }}">
                        <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">PAYMENT DETAILS</h4>
                                    </div>
                                    <form action="" class="form-horizontal">
                                    <div class="modal-body">
                                        <div class="padding-side-15">
                                            <div class="form-group">
                                                <div class="row">
                                                <label for="" class="col-sm-5">Rental Fee</label>
                                                <div class="col-sm-7">
                                                    <input type="number" class="form-control" step="0.25">
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                                        <button type="submit" class="btn btn-info"><i class="fa fa-money"></i> Receive Payment</button> 
                                    </div>
                                    </form>
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
