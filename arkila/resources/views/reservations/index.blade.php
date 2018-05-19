@extends('layouts.master')
@section('title', 'Reservations')
@section('content')
<div class="row">
        <div class="padding-side-5">
            <div>
                <h2 class="text-white">LINE RESERVATIONS</h2>
            </div>
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
                                            <th>Reservation #</th>
                                            <th>Destination</th>
                                            <th>Reservation Date</th>
                                            <th>Number of Slots</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody> 

                                        @foreach ($reservations as $reservation) 
                                        <tr>
                                            <td>{{ $reservation->id }}</td>
                                            <td>{{ $reservation->destination->destination_name }}</td>
                                            <td>{{ $reservation->reservation_date->formatLocalized('%d %B %Y') }}</td>
                                            <td>{{ $reservation->number_of_slots }}</td>
                                            <td>
                                            <a href="{{route('reservations.show', $reservation->id)}}" class="btn btn-block btn-primary btn-sm"> <i class="fa fa-plus"></i> <b>View</b></a>
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