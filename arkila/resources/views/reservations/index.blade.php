@extends('layouts.master')
@section('title', 'Reservations')
@section('content')
@if(!$rule)
<div class="padding-side-10">
    <div class="box box-solid with-shadow" style="height: 300px; padding: 50px; margin-top:7%;">
        <div class="box-body">
            <div class="text-center">
                <h1><i class="fa fa-warning text-yellow"></i> NO RESERVATION RULES</h1>
                <h4>PLEASE SET UP THE RULES FOR RESERVATION FIRST BEFORE USING THE RESERVATION FEAUTURE.</h4>
                <a href="{{route('bookingRules.index')}}" class="btn btn-success btn-flat" style="margin-top: 3%;">GO TO BOOKING RULES</a>
            </div>
        </div>
    </div>
</div>
@else
<div class="padding-side-5">
    <div class="row">
    @if($main->count() == 0 && $destinations->count() == 0)
        <div class="box box-solid" style="height: 300px; padding: 50px;">
            <div class="box-body">
                <div class="text-center">
                <h1><i class="fa fa-warning text-red"></i> NO TERMINAL/DESTINATION FOUND</h1>
                <h4>CREATE A TERMINAL/DESTINATION FIRST BEFORE YOU CAN CREATE A RESERVATION DATE</h4>
                <a href="{{route('reservations.create')}}" class="btn btn-success btn-flat btn-lg">CREATE TERMINAL</a>
                </div>
            </div>
        </div>
        @else
        <div>
            <h2 class="text-white">RESERVATION DATE</h2>
        </div>
        <div class="box">
            <div class="box-body">
                 <div class="table-responsive">
                    <div class="col-md-6">
                        <a href="/home/reservations/create" class="btn btn-success btn-sm btn-flat"><i class="fa fa-plus"></i> CREATE RESERVATION DATE</a>
                    </div>
                    <table class="table table-bordered table-striped listReservation">
                        <thead>
                            <tr>
                                <th class="text-center">Reservation #</th>
                                <th class="text-center">Destination</th>
                                <th class="text-center">Reservation Date</th>
                                <th class="text-center">Departure Time</th>
                                <th class="text-center">Number of Slots</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody> 

                            @foreach ($reservations->sortByDesc('id') as $reservation) 
                            <tr>
                                <td>{{ $reservation->id }}</td>
                                <td>{{ $reservation->destination->destination_name }}</td>
                                <td class="text-right">{{ $reservation->reservation_date->formatLocalized('%d %B %Y') }}</td>
                                <td class="text-right">{{ date('g:i A', strtotime($reservation->departure_time)) }}</td>
                                <td class="text-right">{{ $reservation->number_of_slots }}</td>
                                <td class="text-right" id="status{{$reservation->id}}">{{ $reservation->status }}</td>
                                <td>
                                    <div class="text-center"> 
                                        <form action="{{route('reservations.update', $reservation->id)}}" method="POST">
                                        {{ csrf_field() }} {{ method_field('PATCH') }}  
                                            <a href="{{route('reservations.show', $reservation->id)}}" class="btn btn-primary btn-sm"> <i class="fa fa-eye"></i> VIEW</a>  
                                            @if($reservation->status == 'OPEN')
                                            <button name="status" value="CLOSED" class="btn btn-danger btn-sm">CLOSE</button>               
                                            @elseif($reservation->status == 'CLOSED')
                                            <button name="status" value="OPEN" class="btn btn-success btn-sm">OPEN</button>
                                            <button name="deleteBtn" class="btn btn-outline-danger btn-sm">DELETE</button>
                                            @endif
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    @endif
    </div>
</div>
@endif
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
            'pageLength': 5,
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

@endsection