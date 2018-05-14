    <!-- jQuery 3 -->
    {{ Html::script('adminlte/bower_components/jquery/dist/jquery.min.js') }}
    <!-- jQuery UI 1.11.4 -->
    {{ Html::script('adminlte/bower_components/jquery-ui/jquery-ui.min.js') }} 
    <!-- Bootstrap 3.3.7 -->
    {{ Html::script('adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js') }}
    <!-- Select2 -->
    {{ Html::script('adminlte/bower_components/select2/dist/js/select2.full.min.js') }}
    <!-- InputMask -->
    {{ Html::script('adminlte/plugins/input-mask/jquery.inputmask.js') }}
    {{ Html::script('adminlte/plugins/input-mask/jquery.inputmask.date.extensions.js') }}
    {{ Html::script('adminlte/plugins/input-mask/jquery.inputmask.extensions.js') }}
    <!-- date-range-picker -->
    {{ Html::script('adminlte/bower_components/moment/min/moment.min.js') }}
    {{ Html::script('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}
    <!-- bootstrap datepicker -->
    {{ Html::script('adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}
    <!-- bootstrap color picker -->
    {{ Html::script('adminlte/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}
    <!-- bootstrap time picker -->
    {{ Html::script('adminlte/plugins/timepicker/bootstrap-timepicker.min.js') }}
    <!-- SlimScroll -->
    {{ Html::script('adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}
    <!-- iCheck 1.0.1 -->
    {{ Html::script('adminlte/plugins/iCheck/icheck.min.js') }}
    <!-- SlimScroll -->
    {{ Html::script('adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}
    {{Html::script('adminlte/bower_components/Chart.js/Chart.js')}}
    <!-- FastClick -->
    {{ Html::script('adminlte/bower_components/fastclick/lib/fastclick.js') }}
    <!-- AdminLTE App -->
    {{ Html::script('adminlte/dist/js/adminlte.min.js') }}
    <!-- AdminLTE for demo purposes -->
    {{ Html::script('adminlte/dist/js/demo.js') }}
    <!-- Parsley -->
    {{ Html::script('adminlte/plugins/iCheck/icheck.min.js') }}
    {{ Html::script('js/client-side_validation/parsley.min.js') }}
    {{ Html::script('js/client-side_validation/member-validation.js') }}
    {{ Html::script('js/client-side_validation/van-validation.js') }}
    {{ Html::script('js/client-side_validation/settings-validation.js') }}
    {{ Html::script('js/client-side_validation/booking-form-validation.js') }}
    {{ Html::script('js/client-side_validation/driver-report-validation.js') }}
    {{ Html::script('js/notifications/pnotify.custom.min.js') }}
    {{ Html::script('js/notifications/bootstrap-notify.min.js') }}
    
    <!-- Van Queue Sidebar -->

    <script>    
    $(function () {
        $('.select2').select2();
    })
    </script>
    <script>
        $('#addQueueSideBarButt').on('click', function() {
            var destination = $('#destinationInputSideBar').val();
            var van = $('#vanInputSideBar').val();
            var driver = $('#driverInputSideBar').val();

            if( destination != "" && van != "" && driver != ""){
                $.ajax({
                    method:'POST',
                    url: '/home/trips/'+destination+'/'+van+'/'+driver,
                    data: {
                        '_token': '{{csrf_token()}}'
                    },
                    success: function(){
                        location.reload();
                    }

                });

            }
        });
    </script>



    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
        
    </script>
    <!-- Special Unit Checker -->
  <script>
      $(function(){
          function specialUnitChecker(){
              $.ajax({
                  method:'POST',
                  url: '{{route("vanqueue.specialUnitChecker")}}',
                  data: {
                      '_token': '{{csrf_token()}}'
                  },
                  success: function(response){
                      if(response[0]) {
                          $('#confirmBoxModal').load('/showConfirmationBox/' + response[0]);
                      }else{
                          if(response[1]){
                              $('#confirmBoxModal').load('/showConfirmationBoxOB/'+response[1]);
                          }
                      }
                  }

              });
          }

          specialUnitChecker();
      });
  </script>