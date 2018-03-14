 @extends('layouts.driver') @section('title', 'Driver Report') @section('content-title', 'Driver Report') @section('content')
<div class="row">
    <div class="col-md-offset-1 col-md-10">
        <div class="nav-tabs-custom">
            @include('message.error')
            @include('message.success')
            <ul class="nav nav-tabs nav-justified">@foreach($terminals as $terminal)
                <li><a class href="#terminal{{$terminal->terminal_id}}" data-toggle="tab">{{$terminal->description}}</a></li>
                @endforeach
            </ul>
           
            <form action="{{route('drivermodule.storeReport')}}" method="POST" class="form-horizontal">
            {{csrf_field()}}   

            <div class="tab-content">
                @foreach($terminals as $terminal) 
                <div id="terminal{{$terminal->terminal_id}}" class="tab-pane">
                    <input type="hidden" name="termId" value="{{$terminal->terminal_id}}">
                    <div class="box box-solid">
                        <div class="box-header">
                            <h3 class="box-title">{{$terminal->description}}</h3>
                        </div>
                        <div class="box-body">

                            <div class="col-md-3">
                                

                                    @foreach($destinations as $destination) @if($destination->term_id == $terminal->terminal_id)
                                    <div class='form-group'>
                                        <label name='destination[]' value='{{$destination->destination_id}}' for=''>{{$destination->description}}</label>
                                        <input class='form-control pull-right' onblur='findTotal()' type='number' name='qty' id='qty{{$destination->term_id}}' style='width:30%;'>
                                    </div>
                                    @endif @endforeach

                            </div>
                            <div class="col-md-6 pull-right">
                                <div class="form-group">
                                    <label for="birthdateO">Date of Departure:</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input value="" id="" name="dateDeparted" type="text" class="form-control pull-right datepicker">
                                    </div>
                                </div>
                            <div class = "bootstrap-timepicker">
                                <div class="form-group">
                                    <label for="birthdateO">Time of Departure:</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                        <input value="" id="timepicker" name="timeDeparted" type="text" class = "form-control">
                                    </div>
                                </div>
                            </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class='form-group'>
                                            <label for=''>Total Passengers: </label>
                                            <input class='form-control pull-right' type='number' name='totalPassengers' id='total'>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class='form-group'>
                                            <label for=''>Total Booking Fee: </label>
                                            <input class='form-control pull-right' type='number' step="0.25" name='totalBookingFee' id='total'>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="box-footer text-center">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#discountModal">Submit</button>
                                    </div>
                                </div>
                            </div>

                            
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- /.nav-tabs -->
    </div>
    <!-- /.col -->
</div>
<!--               DISCOUNT MODAL-->
<div class="modal fade" id="discountModal">
    <div class="modal-dialog" style="margin-top:150px;">
        <div class="col-md-offset-2 col-md-8">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    Discounts
                </div>
                <div class="modal-body text-center">
                    <div class="form-group">
                        <label for="Discount">Tickets with discounts</label>
                        <input class="form-control" id="" type="number">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-group-justified">Confirm Discount</button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection @section('scripts') @parent


<!--   For sum of tables-->
<script type="text/javascript">
    function findTotal() {
        var arr = document.getElementsByName('qty');
        var tot = 0;
        for (var i = 0; i < arr.length; i++) {
            if (parseInt(arr[i].value))
                tot += parseInt(arr[i].value);
        }
        document.getElementById('totalPassengers').value = tot;
    }
</script>

<script>
    $('#timepicker').timepicker({
            showInputs: false
        })
</script>
<script>
    $(cloneDatePicker());

    function cloneDatePicker() {

        //Date picker
        $('.datepicker').datepicker({
            autoclose: true
        })

    }
      $(function() {

        //Date picker
        

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
@endsection