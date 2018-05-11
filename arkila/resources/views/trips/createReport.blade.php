@extends('layouts.master')
@section('title', 'Create Report')
@section('content')
<div class="row">
    <div class="col-md-offset-1 col-md-10">
        <div id="terminal" class="tab-pane">
            <div class="box box-solid">
                <div class="box-header with-border text-center">
                    <h3 class="box-title">{{$terminals->description}}</h3>
                </div>

                <div class="box-body">
                    <form action="{{route('trips.admin.storeReport', [$terminals->destination_id])}}" method="POST" class="form-horizontal" data-parsley-validate="">
                      {{csrf_field()}}
                      <input type="hidden" name="orgId" value="{{$terminals->destination_id}}">
                        <div class="col-md-6">
                            <div class="text-center"><h4>ROUTES</h4></div>
                            <div class="col-sm-4">

                            </div>
                            <div class="col-sm-4">
                                <label class="text-center">#Passengers</label>
                            </div>
                            <div class="col-sm-4">
                                <label class="text-center">#Discounted</label>
                            </div>
                            @if($terminals->is_terminal == true && $terminals->is_main_terminal == false)
                            <!-- TO MAIN TERMINAL -->
                            <div class='form-group'>
                                <label for="" class="col-sm-4">Main Terminal</label>
                                <div class="col-sm-6">
                                    <input value="" class='form-control pull-right num-pass' onblur='findUpTotal()' type='number' name='numPassMain' min="0">
                                </div>
                                <div class="col-sm-4">
                                    <input value="" class='form-control pull-right'  type='number' name='numDisMain' min="0">
                                </div>
                            </div>

                            <div class='form-group'>
                                <label for="" class="col-sm-4">Short Trip</label>
                                <div class="col-sm-6">
                                    <input value="" class='form-control pull-right num-pass' onblur='findUpTotal()' type='number' name='numPassST' id='numPassST' min="0">
                                </div>
                                <div class="col-sm-4">
                                    <input value="" class='form-control pull-right'  type='number' name='numDisST' id='' min="0">
                                </div>
                            </div>

                            @elseif($terminals->is_terminal == true && $terminals->is_main_terminal == true)
                            @php $counter = 0; @endphp
                            @foreach($destinations as $destination)
                            <!-- FROM MAIN TERMINAL -->
                            <div class='form-group'>
                                <label for="" class="col-sm-4">{{$destination->first()->destination_name}}</label>
                                <div class="col-sm-4">
                                    <input type="hidden" name="destination[]" value="{{$destination->first()->destination_id}}">
                                    <input value="" class='form-control pull-right' onblur='findTotal()' type='number' name='qty[]' id='' min="0">
                                </div>
                                <div class="col-sm-4">
                                    <input type="hidden" name="discount[]" value="">
                                    <input value="" class='form-control pull-right' onblur='findTotal()' type='number' name='disqty[]' id='' min="0">
                                </div>
                            </div>
                            @php $counter++; @endphp
                          @endforeach
                          @endif
                        </div>
                        <div class="col-md-6">
                            <div class="text-center"><h4>DEPARTURE DETAILS</h4></div>
                            @if($terminals->is_terminal == true && $terminals->is_main_terminal == true)
                            <div class="form-group">
                                <label for="driver" class="col-sm-4">Destination Terminal:</label>
                                <div class="col-sm-8">
                                <select name="origin" id="originTerminal" class="form-control select2">
                                    @foreach($origins as $origin)
                                    <option value="{{$origin->destination_id}}">{{$origin->destination_name}}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            @endif
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
                                <div class="bootstrap-timepicker">
                                    <label for="timeDepart" class="col-sm-4">Departure Time:</label>
                                    <div class=" col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                        <input value="{{old('timeDeparted')}}" id="timepicker" name="timeDeparted" class="form-control" required data-parsley-errors-container="#errTimeDeparted" val-time-depart required>
                                    </div>
                                    <p id="errTimeDeparted"></p>
                                    </div>
                                </div>
                            </div>
                            <div class='form-group'>
                                <label for="" class="col-sm-4">Total Passengers:</label>
                                <div class=" col-sm-6">
                                <p id="totalPassenger" class="info-container">{{old('totalPassengers')}}</p>
                                <input id="totalPassengers" type="hidden" name="totalPassengers" value="">
                                </div>
                            </div>

                            <div class="box-footer text-center">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#discountModal">Submit</button>
                            </div>
                            <!-- /.box-footer -->
                        </div>
                        <!-- /.col -->
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.tab-pane -->

        <!--               DISCOUNT MODAL-->
        <div class="modal fade" id="discountModal">
            <div class="modal-dialog" style="margin-top:150px;">
                <div class="col-md-offset-2 col-md-8">
                    <div class="modal-content">
                        <div class="modal-header bg-blue">
                            Confirm
                        </div>
                        <div class="modal-body text-center">
                            <p>Are you sure you want to add these tickets?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </div>
                        <!-- /.modal-footer -->
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        </form>
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
</div>


@endsection

@section('scripts')
@parent


<!--   For sum of tables-->
<script type="text/javascript">
    function findTotal() {
        var arr = document.getElementsByName('qty[]');
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
</script>


@endsection
