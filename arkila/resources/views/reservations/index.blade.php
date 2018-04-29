@extends('layouts.master')
@section('title', 'Reservations')
@section('links')
@parent
  <link rel="stylesheet" href="public\css\myOwnStyle.css">
  @stop

@section('content')
<div class="row">
    <div class="col-md-3">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Ticket</h3>
                </div>
                <form action="">
                    <div class="box-body">
                        <label for="">Reservation</label>
                        <select name="reservation_code" id="reservationSell" class="form-control">
                        <option value="">Select Reservation</option>
                                @foreach ($reservations->where('type', 'Online')->where('status', 'Accepted') as $reservation)
                            @if($reservation->destination->terminal->trips->where('queue_number',1)->first()->plate_number ?? null)
                                <option value="{{$reservation->id}}">#{{$reservation->id}} by {{$reservation->name}}</option>
                            @endif
                        @endforeach
                        </select>
                        <label for="">Terminal</label>
                        <select name="terminal" id="terminalSell" class="form-control">
                        <option value="">Select Terminal</option>
                            @php $counter = 0; @endphp
                            @foreach($terminals as $terminal)
                                @if($terminal->trips->where('queue_number',1)->first()->plate_number ?? null)
                                    <option value="{{$terminal->terminal_id}}">{{$terminal->description}}</option>
                                @endif
                            @endforeach
                        </select>
                        <label for="">Destination</label>
                        <select name="destination" id="destinationSell" class="form-control">
                        <option value="">Select Destination</option>
                        @foreach ($destinations as $destination)
                        <option value="{{$destination->destination_id}}">{{$destination->description}}</option>
                        @endforeach
                        </select>
                        <label for="">Discount</label>
                        <div class="input-group">
                                                <span class="input-group-addon">
                                                  <input id="checkDiscount" type="checkbox">
                                                </span>
                            <select name="discount" id="discount" class="form-control">
                            @foreach ($discounts as $discount)
                            <option value="">Select Discount</option>
                            <option value="">{{$discount->description}}</option>
                            @endforeach
                            </select>
                        </div>
                        <label for="">Ticket</label>
                        <select name="tickets" id="ticket" class="form-control select2" multiple="multiple" data-placeholder="Select Ticket" disabled>
                        </select>
                    </div>

                    <div class="box-footer">
                        <div id="sellButtContainer" class="pull-right">
                            <button type="button" class="btn btn-info btn-flat" @if($counter) title="Please add atleast one destination for the specified terminal on the terminal field" @else title="Please Add a van from the queue to start selling tickets" @endif disabled>Sell</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-9">
            <div class="box">
                <div class="box-body">

                        <!-- Custom Tabs -->
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab">List of Reservations</a>
                            <li><a href="#tab_2" data-toggle="tab">Online Reservation</a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div class="col-md-6">
                                    <a href="/home/reservations/create" class="btn btn-success btn-sm btn-flat"><i class="fa fa-plus"></i> ADD RESERVATION</a>
                                </div>

                                <table class="table table-bordered table-striped listReservation">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Contact Number</th>
                                            <th>Destination</th>
                                            <th>Preferred Date</th>
                                            <th>Time</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($reservations as $reservation) 
                                        @if ($reservation->status == 'Paid' | $reservation->status == 'Departed' | $reservation->status == 'Cancelled' )
                                        <tr>
                                            <td>{{ $reservation->id }}</td>
                                            <td>{{ $reservation->name }}</td>
                                            <td>{{ $reservation->contact_number }}</td>
                                            <td>{{ $reservation->destination->description }}</td>
                                            <td>{{ $reservation->departure_date }}</td>
                                            <td>{{ $reservation->departure_time }}</td>
                                            <td>{{ $reservation->amount }}</td>
                                            <td>{{ $reservation->status }}</td>
                                            <td class="center-block">
                                                <div class="text-center">
                                                    
                                                        
                                                    @if ($reservation->status == 'Paid')
                                                    
                                                        <button class="btn btn-outline-danger btn-sm" type="submit" name="butt" data-toggle="modal" data-target="#{{'cancel'.$reservation->id}}" value="Cancelled"><i class="fa fa-close"></i> Cancel</button>
                                                    
                                                    
                                                         <!-- Modal for Cancelation-->
                                                         <div class="modal fade" id="{{'cancel'.$reservation->id}}">
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
                                                                                <p style="font-size: 110%;">Are you sure you want to cancel reservation #{{ $reservation->id }}?</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                           <form method="POST" action="{{ route('reservations.update', $reservation->id) }}">
                                                                                {{ csrf_field() }} {{ method_field('PATCH') }} 

                                                                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Discard</button>
                                                                                <button type="submit" name="butt" value="Cancelled" class="btn btn-danger" style="width:22%;">Cancel</button>
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

                                                    @else
                                                   
                                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#{{'deletion'.$reservation->id}}"><i class="fa fa-close"></i> Delete</button>
                                                    
                                                    
                                                    <!-- Modal for Deletion-->
                                                     <div class="modal fade" id="{{'deletion'.$reservation->id}}">
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
                                                                            <p style="font-size: 110%;">Are you sure you want to delete reservation #{{ $reservation->id }}?</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form method="POST" action="{{ route('reservations.destroy', [$reservation->id]) }}" class="delete">
                                                                            {{csrf_field()}} {{method_field('DELETE')}}

                                                                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
                                                                            <button type="submit" class="btn btn-danger btn-sm" style="width:22%;">Delete</button>
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
                                                    
                                                    @endif

                                                </div>
                                            </td>
                                        </tr>
                                        @endif 
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        <div class="tab-pane" id="tab_2">

                            <table class="table table-bordered table-striped listReservation">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Contact Number</th>
                                        <th>Destination</th>
                                        <th>Preferred Date</th>
                                        <th>Time</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reservations->where('type', 'Online') as $reservation)
                                    <tr>
                                        <td>{{ $reservation->id }}</td>
                                        <td>{{ $reservation->name }}</td>
                                        <td>{{ $reservation->contact_number }}</td>
                                        <td>{{ $reservation->destination->description }}</td>
                                        <td>{{ $reservation->departure_date }}</td>
                                        <td>{{ $reservation->departure_time }}</td>
                                        <td>{{ $reservation->amount }}</td>
                                        <td>{{ $reservation->status }}</td>
                                        <td class="text-center">


                                            @if ($reservation->status == 'Pending')
                                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#{{'paid'.$reservation->id}}"><i class="fa fa-automobile"></i>Accept</button>
                                                
                                                <!-- Modal for Paid-->
                                                <div class="modal fade" id="{{'paid'.$reservation->id}}">
                                                    <div class="modal-dialog">
                                                        <div class="col-md-offset-2 col-md-8">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-primary">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span></button>
                                                                    <h4 class="modal-title"> Confirm</h4>
                                                                </div>
                                                                <div class="modal-body row">     
                                                                    <p style="font-size: 110%;">Are you sure you want to accept reservation #{{$reservation->id}}?</p>
                                                                    
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form action="{{ route('reservations.update', $reservation->id) }}" method="POST" class="form-action">
                                                                        {{ csrf_field() }} {{ method_field('PATCH') }}

                                                                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Discard</button>
                                                                        <button type="submit" name="click" value="Accepted" class="btn btn-primary btn-sm" style="width:22%;">Accept</button>
                                                                    </form>
                                                                </div>
                                                                <!-- /.modal-content -->
                                                            </div>
                                                            <!-- /.col -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                    </div>
                                                    <!-- /.modal -->

                                                <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#{{'cancel'.$reservation->id}}"><i class="fa fa-automobile"></i> Decline</button>

                                                     <!-- Modal for Cancelation-->
                                                    <div class="modal fade" id="{{'cancel'.$reservation->id}}">
                                                        <div class="modal-dialog">
                                                            <div class="col-md-offset-2 col-md-8">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-red">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span></button>
                                                                        <h4 class="modal-title"> Confirm</h4>
                                                                    </div>
                                                                    <div class="col-md-10">
                                                                        <p style="font-size: 110%;">Are you sure you want to decline Reservation #{{$reservation->id}}?</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form action="{{ route('reservations.update', $reservation->id) }}" method="POST" class="form-action">
                                                                            {{ csrf_field() }} {{ method_field('PATCH') }}

                                                                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Discard</button>
                                                                        <button type="submit" name="click" value="Declined" class="btn btn-danger btn-sm" style="width:22%;">Decline</button>
                                                                    </form>
                                                                </div>
                                                                <!-- /.modal-content -->
                                                            </div>
                                                            <!-- /.col -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                    </div>
                                                    <!-- /.modal -->
                                               
                                            @elseif ($reservation->status == 'Accepted')
                                            <button type="submit" class="btn btn-primary btn-sm" style="width:100%;">Sell</button>
                                            @else
                                            <span>No Action</span>
                                            @endif
                                           
                                        </td>
                                    </tr>
                                 

                                    
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                        <!-- /.tab-pane -->
                    <!-- /.tab-content -->
                </div>
            </div>
</div>
</div>

@endsection 
@section('scripts') 
@parent
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- iCheck 1.0.1 -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
    $(function() {
        $('.listReservation').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': true,
            'order': [[ 0, "desc" ]],
            'aoColumnDefs': [{
                'bSortable': false,
                'aTargets': [-1] /* 1st one, start by the right */
            }]
        })

    })
</script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', {
            'placeholder': 'dd/mm/yyyy'
        })
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', {
            'placeholder': 'mm/dd/yyyy'
        })
        //Money Euro
        $('[data-mask]').inputmask()

        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            format: 'MM/DD/YYYY h:mm A'
        })
        //Date range as a button
        $('#daterange-btn').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function(start, end) {
                $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            }
        )

        //Date picker
        $('#datepicker').datepicker({
            autoclose: true
        })

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        })
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
        })
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        })

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        //Timepicker
        $('.timepicker').timepicker({
            showInputs: false
        })
    })

    $(document).ready(function(){

        $(document).on('change', '#reservationSell', function(){

            var resId = $(this).val();

            var parent = $(this).parent();

            var destination = "";
            var terminal = "";

            $.ajax({
                type: 'get',
                url: '{!!URL::to('findDestinationTerminal')!!}',
                data: {'id':resId},
                success:function(data){
                    console.log('success');
                    console.log(data);
                    for(var i=0; i<data.length; i++) {
                        destination = '<option value="'+ data[i].destination_id +'">'+ data[i].description +'</option>';
                        terminal = '<option value="'+ data[i].terminal_id +'">'+ data[i].terminal +'</option>';
                    }
                    
                    parent.find('#destinationSell').html(" ");
                    parent.find('#destinationSell').append(destination);
                    parent.find('#terminalSell').html(" ");
                    parent.find('#terminalSell').append(terminal);

                },
                error:function(){

                }
            });
        });
    });
</script>

@endsection