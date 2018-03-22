 @extends('layouts.driver')
 @section('title', 'Driver Report')
 @section('content-title', 'Driver Report')
 @section('content')
<div class="row">
    <div class="col-md-offset-1 col-md-10">
        <div id="terminal" class="tab-pane">
            <div class="box box-solid">
                <div class="box-header">
                    <h3 class="box-title">{{$terminals->description}}</h3>
                </div>

                <div class="box-body">
                    <form action="{{route('drivermodule.storeReport', [request('id')])}}" method="POST" class="form-horizontal" data-parsley-validate="">
                      {{csrf_field()}}
                      <input type="hidden" name="termId" value="{{$terminals->terminal_id}}">
                        <div class="col-md-6">
                          @php $counter = 0; @endphp
                          @foreach($destinations as $destination)
                            <div class='form-group'>
                                <label for="" class="col-sm-4">{{$destination->description}}</label>
                                <div class="col-sm-6">
                                    <input type="hidden" name="destination[]" value="{{$destination->destid}}">
                                    <input value="{{old('qty.'.$counter)}}" class='form-control pull-right' onblur='findTotal()' type='number' name='qty[]' id=''>
                                </div>
                            </div>
                            @php $counter++; @endphp
                          @endforeach
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="departureDate" class="col-sm-4">Date of Departure:</label>
                                <div class="col-sm-8">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input value="{{old('dateDeparted')}}" id="" name="dateDeparted" type="text" class="form-control" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask required data-parsley-errors-container="#errDateDeparted">
                                        
                                    </div>
                                    <p id="errDateDeparted"></p>
                                </div>
                                
                            </div>
                            <div class="form-group">
                                <div class="bootstrap-timepicker">
                                    <label for="timeDepart" class="col-sm-4">Time of Departure:</label>
                                    <div class=" col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                        <input value="{{old('timeDeparted')}}" id="timepicker" name="timeDeparted" class="form-control" required data-parsley-errors-container="#errTimeDeparted">
                                    </div>
                                    <p id="errTimeDeparted"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-5">
                                    <div class='form-group'>
                                        <label for=''>Total Passengers: </label>
                                        <input value="{{old('totalPassengers')}}" class='form-control col-xs-3' type='number' name='totalPassengers' id='totalPassengers' required>
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-5">
                                    <div class='form-group clearfix'>
                                        <label for=''>Total Booking Fee: </label>
                                        <input value="{{old('totalBookingFee')}}" class='form-control col-xs-3' type='number' data-bookingfee="{{$terminals->booking_fee}}" name='totalBookingFee' id='totalFee' required>
                                    </div>
                                </div>
                            </div>
                            <label for='Discounts'> Number of Customers with Discounts: </label>
                            <div class="form-horizontal">
                              @php $c = 0; @endphp
                                @foreach($fads as $fad)
                                  <div class='form-group'>
                                      <label for='Discounts' class="col-sm-4"> {{$fad->description}} Discount: </label>
                                      <div class="col-sm-6">
                                        <input type="hidden" name="discountId[]" value="{{$fad->fad_id}}">
                                          <input value="{{old('numberOfDiscount.'.$c)}}" class='form-control col-sm-9' type='number' name='numberOfDiscount[]'>
                                      </div>
                                  </div>
                                    @php $c++; @endphp
                                @endforeach
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

        document.getElementById('totalPassengers').value = tot;
        var bookingFee = document.getElementById('totalFee');
        bookingFee.value = document.getElementById('totalPassengers').value * bookingFee.getAttribute('data-bookingfee');
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
