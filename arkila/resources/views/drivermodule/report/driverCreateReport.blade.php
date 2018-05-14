@extends('layouts.driver')
@section('title', 'Driver Report')
@section('content-title', 'Driver Report')
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
</style>
@endsection
@section('content')
@if($member->van->count() > 0)
<div class="row">
    <div class="col-md-offset-1 col-md-10">
        <form action="{{route('drivermodule.storeReport')}}" method="POST" id="createReport" class="form-horizontal create-rep" data-parsley-validate="">
        {{csrf_field()}}
        <div id="terminal">
            <div class="col-md-6">
                <div class="text-center"><h3>REPORT</h3></div>
                <div class="box box-solid">
                    <div class="box-body">
                        <div class="text-center"><h4 class="report-header msgreen">DEPARTURE DETAILS</h4></div>
                        <div class="form-group">
                            <label for="driver" class="col-sm-4">Origin Terminal:</label>
                            <div class="col-sm-8">
                                <select name="origin" id="originTerminal" class="form-control select2">
                                    @foreach($origins as $origin)
                                    <option value="{{$origin->destination_id}}">{{$origin->destination_name}}</option>
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
                                    <input type="text" value="{{$dateNow}}" id="date" name="dateDeparted" type="text" class="form-control" data-inputmask="'alias': 'mm/dd/yyyy'" placeholder="mm/dd/yyyy" data-mask data-parsley-errors-container="#errDateDeparted" val-date-depart data-parsley-departure-report required>
                                </div>
                                <p id="errDateDeparted"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="bootstrap-timepicker">
                                <label for="timeDepart" class="col-sm-4">Departure Time:</label>
                                <div class=" col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                        <input type="text" value="{{$timeNow}}" id="timepicker" name="timeDeparted" placeholder="hh:mm " class="form-control" data-parsley-errors-container="#errTimeDeparted" val-time-depart required>
                                    </div>
                                    <p id="errTimeDeparted"></p>
                                </div>
                            </div>
                        </div>
                        <div class="text-center "><h4 class="report-header sblue">PASSENGER COUNT</h4></div>
                        <table class="table table-bordered table-striped form-table">
                            <thead>
                                <th class="text-center"></th>
                                <th class="text-center">Regular</th>
                                <th class="text-center">Discounted</th>
                            </thead>
                            <tbody>
                              <tr>
                                <th class="text-center">Main Terminal</th>
                                <td>
                                    <input value="0" class='form-control pull-right num-pass' onblur='findTotal()' type='number' name='numPassMain' min="0">
                                </td>
                                <td>
                                    <input value="0" class='form-control pull-right'  type='number' name='numDisMain' min="0">
                                </td>
                              </tr>
                              <tr>
                                <th class="text-center">Short Trip</th>
                                <td><input value="0" class='form-control pull-right num-pass' onblur='findTotal()' type='number' name='numPassST' id='numPassST' min="0"></td>
                                <td><input value="0" class='form-control pull-right'  type='number' name='numDisST' id='' min="0"></td>
                              </tr>
                            </tbody>
                        </table>
                        <div class="form-group" style="margin-top: 5%">
                            <label for="" class="col-sm-4">Total Passengers:</label>
                            <div class=" col-sm-6">
                            <p id="totalPassenger" class="info-container">{{old('totalPassengers')}}</p>
                            <input id="totalPassengers" type="hidden" name="totalPassengers" value="">
                            </div>
                        </div>
                    </div>
                    <div class="box-footer text-center">
                        <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#dicountModal">Submit</button>
                    </div>
                </div>
            </div>       
        </div>
        </form>
    </div>
</div>
@else
<div class="container text-center" style="margin-top: 18%">
    <h1>Currently you don't have a registered van</h1>
    <p>Please approach the clerk in the Baguio Terminal to register your van unit</p>
</div>
@endif
@endsection
@section('scripts')
@parent

<!--   For sum of tables-->
<script type="text/javascript">
    function findTotal() {
        // var numMainPass = document.getElementById('numPassMain');
        // var numSTPass = document.getElementById('numPassST');

        // if(numMainPass == null){
        //     var tot = parseInt(numSTPass.value);
        //     console.log('null si main pass');
        // }else if(numSTPass == null){
        //     var tot = parseInt(numMainPass.value);
        //     console.log('null si st pass');
        // }else{
        //     var tot = parseInt(numMainPass.value) + parseInt(numSTPass.value);
        // }

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
</script>

<script>
    $('#timepicker').timepicker({
        showInputs: false,
        defaultTime: false
    })
</script>
<script>
    function cloneDatePicker() {

        //Date picker
        $('.datepicker').datepicker({
            autoclose: true
        })

    }
    $(function() {

        //Date picker
        cloneDatePicker();

    })



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
</script>

<script>
    $('[data-mask]').inputmask()
    $('.date-mask').inputmask('mm/dd/yyyy',{removeMaskOnSubmit: true})
</script>



@endsection
