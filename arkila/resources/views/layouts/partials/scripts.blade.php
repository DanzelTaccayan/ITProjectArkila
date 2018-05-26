    <!-- jQuery 3 -->
    {{ Html::script('adminlte/bower_components/jquery/dist/jquery.min.js') }}
    <!-- jQuery UI 1.11.4 -->
    {{ Html::script('adminlte/bower_components/jquery-ui/jquery-ui.min.js') }}
    <!-- Bootstrap 3.3.7 -->
    {{ Html::script('adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js') }}
    <!-- Morris.js charts -->
    {{ Html::script('adminlte/bower_components/raphael/raphael.min.js') }}
    {{ Html::script('adminlte/bower_components/morris.js/morris.min.js') }}
    <!-- ChartJs charts -->
    {{Html::script('adminlte/bower_components/Chart.js/Chart.js')}}
    <!-- Select2 -->
    {{ Html::script('adminlte/bower_components/select2/dist/js/select2.full.min.js') }}
    <!-- InputMask -->
    {{ Html::script('adminlte/plugins/input-mask/jquery.inputmask.js') }}
    {{ Html::script('adminlte/plugins/input-mask/jquery.inputmask.date.extensions.js') }}
    {{ Html::script('adminlte/plugins/input-mask/jquery.inputmask.extensions.js') }}
    <!-- Sparkline -->
    {{ Html::script('adminlte/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}
    <!-- jvectormap -->
    {{ Html::script('adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}
    {{ Html::script('adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}
    <!-- jQuery Knob Chart -->
    {{ Html::script('adminlte/bower_components/jquery-knob/dist/jquery.knob.min.js') }}
    <!-- daterangepicker -->
    {{ Html::script('adminlte/bower_components/moment/min/moment.min.js') }}
    {{ Html::script('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}
    <!-- datepicker -->
    {{ Html::script('adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}
    <!-- Bootstrap WYSIHTML5 -->
    {{ Html::script('adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}
    <!-- Slimscroll -->
    {{ Html::script('adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}
    <!-- FastClick -->
    {{ Html::script('adminlte/bower_components/fastclick/lib/fastclick.js') }}
    <!-- AdminLTE App -->
    {{ Html::script('adminlte/dist/js/adminlte.min.js') }}
    <!-- DataTables -->
    {{ Html::script('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js') }}
    {{ Html::script('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}
    <!-- Parsley -->
    {{ Html::script('js/client-side_validation/parsley.min.js') }}
    <!-- iCheck -->
    {{ Html::script('adminlte/plugins/iCheck/icheck.min.js') }}
    {{ Html::script('js/client-side_validation/parsley.min.js') }}
    {{ Html::script('js/client-side_validation/member-validation.js') }}
    {{ Html::script('js/client-side_validation/driver-validation.js') }}
    {{ Html::script('js/client-side_validation/van-validation.js') }}
    {{ Html::script('js/client-side_validation/settings-validation.js') }}
    {{ Html::script('js/client-side_validation/booking-form-validation.js') }}
    {{ Html::script('js/client-side_validation/driver-report-validation.js') }}
    {{ Html::script('js/notifications/pnotify.custom.min.js') }}
    {{ Html::script('js/notifications/bootstrap-notify.min.js') }}
    <!-- bootstrap time picker -->
    {{ Html::script('adminlte/plugins/timepicker/bootstrap-timepicker.min.js') }}
    <!-- Awesome Functions-->
    {{ Html::script('js/awesome-functions-min.js') }}
    <script>    
        $('.select2').select2();
    </script>

    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
        
    </script>
