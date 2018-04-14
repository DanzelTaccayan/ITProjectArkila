@extends('layouts.master')
@section('title', 'List of Rentals')
@section('links')
    @parent
    @stop
@section('content')
<div class="box">
    <div class="box-body" style="box-shadow: 0px 5px 10px gray;">
        <div class="col-xl-6">
            <!-- Custom Tabs -->
            <div class="table-responsive">
                <div class="col-md-6">
                    <a href="/home/rental/create" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> ADD RENTAL</a>
                </div>

                <table id="listRent" class="table table-bordered table-striped rentalTable">
                    <thead>
                        <tr>
                            <th>Name</th>
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
                            <td>{{ $rental->departure_date }}</td>
                            <td>{{ $rental->departure_time }}</td>
                            <td>{{ $rental->contact_number }}</td>
                            <td>{{ $rental->plate_number }}</td>
                            @if ($rental->rent_type == 'Walk-in')
                            <td>{{ $rental->driver->full_name ?? 'None' }}</td>
                            @else
                            <td>{{ $rental->users->last_name ?? 'None' }}, {{ $rental->users->first_name ?? 'None'  }}</td>
                            @endif

                            <td>{{ $rental->status }}</td>
                            <td class="center-block">
                                <div class="center-block">
                                    @if ($rental->status == 'Accepted')
                                    <button class="btn btn-success btn-sm" name="click" id="paid" data-toggle="modal" data-target="#{{'paid'.$rental->rent_id}}"><i class="fa fa-automobile"></i> Paid </button>

                                    <div class="modal fade" id="{{'paid'.$rental->rent_id}}">
                                        <div class="modal-dialog">
                                            <div class="col-md-offset-2 col-md-8">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title"> Confirm</h4>
                                                    </div>
                                                    <div class="modal-body row" style="margin: 0% 1%;">

                                                        <p style="font-size: 110%;">Are you sure rental from {{$rental->full_name}} has paid?</p>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ route('rental.update', $rental->rent_id) }}" method="POST" class="form-action">
                                                            {{ csrf_field() }} {{ method_field('PATCH') }}

                                                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
                                                            <button type="submit" name="click" value="Paid" class="btn btn-primary btn-sm" style="width:22%;">Paid</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->
                                    @elseif ($rental->status == 'Paid')
                                    <button class="btn btn-primary btn-sm" name="click" id="depart" value="Depart" data-toggle="modal" data-target="#{{'depart'.$rental->rent_id}}"><i class="fa fa-automobile"></i> Depart </button>

                                    <button class="btn btn-outline-danger btn-sm" name="click" id="depart" value="Cancelled" data-toggle="modal" data-target="#{{'cancel'.$rental->rent_id}}"><i class="fa fa-close"></i> Cancel </button>

                                    <!-- Modal for depart-->
                                    <div class="modal fade" id="{{'depart'.$rental->rent_id}}">
                                        <div class="modal-dialog">
                                            <div class="col-md-offset-2 col-md-8">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title"> Confirm</h4>
                                                    </div>
                                                    <div class="modal-body row" style="margin: 0% 1%;">

                                                        <p style="font-size: 110%;">Are you sure you want to depart rental from {{$rental->full_name}} going to {{ $rental->destination }}?</p>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ route('rental.update', $rental->rent_id) }}" method="POST" class="form-action">
                                                            {{ csrf_field() }} {{ method_field('PATCH') }}

                                                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
                                                            <button type="submit" name="click" value="Departed" class="btn btn-primary btn-sm" style="width:22%;">Depart</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->

                                    <!-- Modal for Cancelation-->
                                    <div class="modal fade" id="{{'cancel'.$rental->rent_id}}">
                                        <div class="modal-dialog">
                                            <div class="col-md-offset-2 col-md-8">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-red">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title"> Confirm</h4>
                                                    </div>
                                                    <div class="modal-body row" style="margin: 0% 1%;">
                                                        <div class="col-md-2" style="font-size: 35px; margin-top: 7px;">
                                                            <i class="fa fa-exclamation-triangle pull-left" style="color:#d9534f;">  </i>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <p style="font-size: 110%;">Are you sure you want to cancel rental #{{$rental->rent_id}}?</p>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ route('rental.update', $rental->rent_id) }}" method="POST" class="form-action">
                                                            {{ csrf_field() }} {{ method_field('PATCH') }}

                                                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Discard</button>
                                                            <button type="submit" name="click" value="Cancelled" class="btn btn-danger btn-sm" style="width:22%;">Cancel</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->

                                    @elseif($rental->status == 'Pending')
                                    <p>No Action</p>

                        @elseif ($rental->status == 'Cancelled' && $rental->driver_id !== null && $rental->model_id !==null && $rental->plate_number !== null)
                          <form action="{{ route('rental.update', $rental->rent_id) }}" method="POST" class="form-action">
                              {{ csrf_field() }} {{ method_field('PATCH') }}

                              <button type="submit" name="click" value="Refunded" class="btn btn-primary btn-sm" style="width:22%;">Refund</button>
                          </form>
                        @endif
                         @endforeach
                    </tbody>
                </table>
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


    var currentTab = 0; // Current tab is set to be the first tab (0)
    showTab(currentTab); // Display the crurrent tab

    function showTab(n) {
        // This function will display the specified tab of the form...
        var x = document.getElementsByClassName("tab");
        x[n].style.display = "block";
        //... and fix the Previous/Next buttons:
        if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }
        if (n == (x.length - 1)) {
            document.getElementById("nextBtn").innerHTML = "Submit";
        } else {
            document.getElementById("nextBtn").innerHTML = "Next";
        }
        //... and run a function that will display the correct step indicator:
        fixStepIndicator(n)
    }

    function nextPrev(n) {
        // This function will figure out which tab to display
        var x = document.getElementsByClassName("tab");
        // Exit the function if any field in the current tab is invalid:
        if (n == 1 && !validateForm()) return false;
        // Hide the current tab:
        x[currentTab].style.display = "none";
        // Increase or decrease the current tab by 1:
        currentTab = currentTab + n;
        // if you have reached the end of the form...
        if (currentTab >= x.length) {
            // ... the form gets submitted:
            document.getElementById("regForm").submit();
            return false;
        }
        // Otherwise, display the correct tab:
        showTab(currentTab);
    }

    function validateForm() {
        // This function deals with validation of the form fields


        return true; // return the valid status
    }

    function fixStepIndicator(n) {
        // This function removes the "active" class of all steps...
        var i, x = document.getElementsByClassName("step");
        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace("active", "");
        }
        //... and adds the "active" class on the current step:
        x[n].className += " active";
    }

    function ConfirmDelete() {
        var x = confirm("Delete this request?");
        if (x)
            return true;
        else
            return false;
    }

    function ConfirmStatus() {
        var x = confirm("Change status?");

        if (x)
            return true;
        else
            return false;

    }
</script>
@endsection
