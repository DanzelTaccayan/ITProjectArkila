 @extends('layouts.driver')
 @section('title', 'Driver Report')
 @section('content-title', 'Driver Report')
 @section('content')
@if($member->van->count() > 0)
<div class="row">
    <div class="col-md-offset-1 col-md-10">
        <div id="terminal" class="tab-pane">
            <div class="box box-solid">
                <div class="box-header with-border text-center">
                    <h3 class="box-title">{{$terminals->description}}</h3>
                </div>

                <div class="box-body">
                    <form action="{{route('drivermodule.storeReport', [$terminals->terminal_id])}}" method="POST" class="form-horizontal" data-parsley-validate="">
                      {{csrf_field()}}
                      @php $destination_name = null; @endphp
                      @foreach($terminals->routeFromDestination as $terminal)
                        @php $destination_name = $terminal->pivot->terminal_origin; @endphp
                        @break;
                      @endforeach
                      <input type="hidden" name="destinationName" value="{{$destination_name}}">
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
                          @php $counter = 0; @endphp
                          @foreach($destinations as $destination)
                            <div class='form-group'>
                                <label for="" class="col-sm-4">{{$destination->destination_name}}</label>
                                <div class="col-sm-6">
                                    <input type="hidden" name="destination[]" value="{{$destination->destid}}">
                                    <input value="{{old('qty.'.$counter)}}" class='form-control pull-right' onblur='findTotal()' type='number' name='qty[]' id='' min="0">
                                </div>
                                <div class="col-sm-4">
                                    <input type="hidden" name="discount[]" value="">
                                    <input value="{{old('qty.'.$counter)}}" class='form-control pull-right' onblur='findTotal()' type='number' name='dis[]' id='' min="0">
                                </div>
                            </div>
                            @php $counter++; @endphp
                          @endforeach
                        </div>

                        <div class="col-md-6">
                            <div class="text-center"><h4>DEPARTURE DETAILS</h4></div>
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
                                <input type="hidden" id="totalFee" value="{{$terminals->booking_fee}}">
                                <input id="totalFees"  type="hidden" name='totalBookingFee' value="">
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
        var arr = document.getElementsByName('qty[]');
        var tot = 0;
        for (var i = 0; i < arr.length; i++) {
            if (parseInt(arr[i].value))
                tot += parseInt(arr[i].value);
        }

        document.getElementById('totalPassenger').textContent = tot;
        document.getElementById('totalPassengers').value = tot;
        var bookingFee = document.getElementById('totalFee');
        //bookingFee.textContent = document.getElementById('totalPassengers').value * bookingFee.value;
        document.getElementById('totalFees').value = document.getElementById('totalPassengers').value * bookingFee.value;
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
