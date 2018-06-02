@extends('layouts.master')
@section('title', 'Create Report')
@section('links')
@parent
<style>
.report-header {
    padding: 10px;
    color: white;
}
.sblue {
    background: slateblue;
}

.msgreen {
    background: mediumseagreen;
}
.smaroon {
    background: #800000;
}
</style>
@endsection
@section('content')
<div class="padding-side-5">
    <div>
        <h2 class="text-white">CREATE REPORT
        </h2>
    </div>

    <div class="box" style="box-shadow: 0px 5px 10px gray;">
        <div class="box-body">
            <div class="row">
                <form action="{{route('trips.admin.storeReport', [$terminals->destination_id, $destination->destination_id])}}" method="POST" class="form-horizontal" data-parsley-validate="">
                    {{csrf_field()}}
                    <input type="hidden" name="orgId" value="{{$terminals->destination_id}}">

                    <div class="col-md-6" style="padding: 2% 5%">
                        <div class="text-center">
                            <h4 class="report-header msgreen">DEPARTURE DETAILS</h4>
                        </div>

                        <div class="form-group">
                            <label for="driver" class="col-sm-4">Driver:</label>
                            <div class="col-sm-8">
                                <select name="driverAndOperator" id="driver" class="form-control select2">
                                    @foreach($driverAndOperators as $driverAndOperator)
                                    <option value="{{$driverAndOperator->member_id}}">{{$driverAndOperator->first_name . ' ' . $driverAndOperator->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="driver" class="col-sm-4">Van:</label>
                            <div class="col-sm-8">
                                <select name="van_platenumber" id="originTerminal" class="form-control select2">
                                    @foreach($plate_numbers as $plate_number)
                                    <option value="{{$plate_number->van_id}}">{{$plate_number->plate_number}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="departureDate" class="col-sm-4">Departure Date:</label>
                            <div class="col-sm-8">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input value="{{old('dateDeparted')}}" id="" name="dateDeparted" type="text" class="form-control" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask required data-parsley-errors-container="#errDateDeparted" val-date-depart data-parsley-departure-report required>
                                </div>
                                <p id="errDateDeparted"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            
                                <label for="timeDepart" class="col-sm-4">Departure Time:</label>
                                <div class=" col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                        <input type="time" name="timeDeparted" value="{{old('timeDeparted')}}" class="form-control" placeholder="hh:mm" required>
                                    </div>
                                    <p id="errTimeDeparted"></p>
                                </div>
                            
                        </div>


                        <!-- /.box-footer -->
                    </div>
                    <!-- /.col -->

                    <div class="col-md-6" style="padding: 2% 5%">
                        <div class="text-center">
                            <h4 class="report-header sblue">PASSENGER COUNT</h4>
                        </div>

                        @if($terminals->is_terminal == true && $terminals->is_main_terminal == false)

                        <!-- TO MAIN TERMINAL -->
                        <table class="table table-bordered table-striped form-table">
                            <thead>
                                <th></th>
                                <th class="text-center">Regular</th>
                                <th class="text-center">Discounted</th>
                            </thead>

                            <tbody>
                                <tr>
                                    <th>Main Terminal</th>
                                    <td>
                                        <input class='form-control pull-right num-pass' onblur='findUpTotal()' type='number' name='numPassMain' value="0" min="0">
                                    </td>
                                    <td>
                                        <input class='form-control pull-right num-pass' onblur='findUpTotal()' type='number' name='numDisMain' value="0" min="0">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Short Trip</th>
                                    <td>
                                        <input class='form-control pull-right num-pass' onblur='findUpTotal()' type='number' name='numPassST' id='numPassST' value="0" min="0">
                                    </td>
                                    <td>
                                        <input class='form-control pull-right num-pass' onblur='findUpTotal()' type='number' name='numDisST' id='' value="0" min="0">
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        @elseif($terminals->is_terminal == true && $terminals->is_main_terminal == true) @php $counter = 0; @endphp

                        <table class="table table-bordered table-striped form-table">
                            <thead>
                                <th></th>
                                <th class="text-center">Regular</th>
                                <th class="text-center">Discounted</th>
                            </thead>
                            <tbody>
                                @foreach($destinations as $destination)
                                <!-- FROM MAIN TERMINAL -->
                                <tr>
                                    <th>{{$destination->first()->destination_name}}</th>
                                    <td>
                                        <input type="hidden" name="destination[]" value="{{$destination->first()->destination_id}}">
                                        <input class='form-control pull-right num-pass' onblur='findTotal()' type='number' name='qty[]' id='' value="0" min="0">
                                    </td>
                                    <td>
                                        <input type="hidden" name="discount[]" value="">
                                        <input class='form-control pull-right num-pass' onblur='findTotal()' type='number' name='disqty[]' id='' value="0" min="0">
                                    </td>
                                </tr>
                                @php $counter++; @endphp @endforeach
                            </tbody>
                        </table>

                        @endif
                        <div class="form-group">
                            <label for="" class="col-sm-4">Total Passengers:</label>
                            <div class=" col-sm-6">
                                <input id="totalPassengers" type="hidden" name="totalPassengers" value="">
                                <p id="totalPassenger" class="info-container">{{old('totalPassengers')}}</p>
                            </div>
                        </div>
                        <div class="box-footer text-center">
                            <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#discountModal">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@parent


<!--   For sum of tables-->
<script type="text/javascript">
    function findTotal() {
        var arr = document.getElementsByClassName('num-pass');
        var tot = 0;
        for (var i = 0; i < arr.length; i++) {
            if (parseInt(arr[i].value))
                tot += parseInt(arr[i].value);
        }

        document.getElementById('totalPassenger').textContent = tot;
        document.getElementById('totalPassengers').value = tot;
        var bookingFee = document.getElementById('totalFee');
        document.getElementById('totalBookingFee').value = document.getElementById('totalPassengers').value * bookingFee.value;
    }

    function findUpTotal() {
        var arr = document.getElementsByClassName('num-pass');
        var tot = 0;

        for(var i = 0; i < arr.length; i++){
            if(parseInt(arr[i].value)){
                tot += parseInt(arr[i].value);
            }
        }

        document.getElementById('totalPassenger').textContent = tot;
        document.getElementById('totalPassengers').value = tot;

        //bookingFee.textContent = document.getElementById('totalPassengers').value * bookingFee.value;
        //document.getElementById('totalFees').value = document.getElementById('totalPassengers').value * bookingFee.value;
    }
    //document.getElementById('dest').value = document.getElementById('termId').value;

    function cloneDatePicker() {

        //Date picker
        $('.datepicker').datepicker({
            autoclose: true
        });

    }
    $(function() {

        //Date picker
        cloneDatePicker();

    });



    function addItem() {
        var tablebody = document.getElementById('childrens');
        if (tablebody.rows.length == 1) {
            tablebody.rows[0].cells[tablebody.rows[0].cells.length - 1].children[0].children[0].style.display = "";
        }


        var tablebody = document.getElementById('childrens');
        var iClone = tablebody.children[0].cloneNode(true);
        for (var i = 0; i < iClone.cells.length; i++) {
            iClone.cells[i].children[0].value = "";
            iClone.cells[1].children[0].children[1].value = "";


        }
        tablebody.appendChild(iClone);
        cloneDatePicker();
    }


    function rmv() {
        var tabRow = document.getElementById("childrens");
        if (tabRow.rows.length == 1) {
            tabRow.rows[0].cells[tabRow.rows[0].cells.length - 1].children[0].children[0].style.display = "none";
        } else {
            tabRow.rows[0].cells[tabRow.rows[0].cells.length - 1].children[0].children[0].style.display = "";
        }
    }

    $('[data-mask]').inputmask();

    $(function() {
        //Date picker
        $('#timepicker').timepicker({
            showInputs: false
            // startTime: new Time();
        })

    });
</script>

@endsection
