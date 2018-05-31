@extends('layouts.form_lg')
@section('title', 'Rent Van')
@section('form-id', 'parsley-form')
@section('form-action', route('rental.store'))
@section('form-method', 'POST')
@section('form-body')
{{csrf_field()}}     
<div class="box box-danger with-shadow" style = " margin: 7% auto;">
        <div class="box-header with-border text-center">
            <h3>
            <a href="{{ route('rental.index')}}" class="pull-left"><i class="fa fa-chevron-left"></i></a>
            </h3>
            <h3 class="box-title">
                Rental Form
            </h3>
        </div>
        <div class="box-body">
            <h4>Trip Information</h4>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Customer Name: <span class="text-red">*</span></label>
                        <input type="text" class="form-control" placeholder="Customer Name" name="name" id="name" value="{{ old('name') }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                     <div class="form-group">
                        <label>Destination: <span class="text-red">*</span></label>
                        <select name="destination" id="destination" class="form-control" val-rent-dest required>
                            <option value="">Select Destination</option>
                            @foreach ($destinations as $destination)
                            <option value="{{$destination->destination_name}}">{{$destination->destination_name}}</option>
                            @endforeach
                            <option value="other">** OTHER DESTINATION **</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                     <div class="form-group">
                        <label>Other Destination: <span class="text-red">*</span></label>
                        <input type="text" class="form-control" placeholder="" name="otherDestination" id="destination" value="{{ old('destination') }}" val-rent-dest disabled>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                     <div class="form-group">
                        <label>Contact Number: <span class="text-red">*</span></label>
                        <div class = "input-group">
                            <div class = "input-group-addon">
                               <i class="fa fa-phone"></i>
                            </div>
                        <input type="text" class="form-control" placeholder="Contact Number" name="contactNumber" id="contactNumber" value="{{ old('contactNumber') }}" data-parsley-errors-container="#errContactNumber" val-contact required>
                        </div>
                        <p id="errContactNumber"></p>
                    </div>
                </div> 
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Van Unit:</label>
                        <select class="form-control select2" name="plateNumber" id="plateNumber" onchange="triggerDriver()" val-van required>
                            <option value="" selected>Select Van Unit</option>
                        @foreach ($vans as $van)
                           <option value="{{ $van->van_id }}" @if($van->van_id == old('plateNumber') ) {{'selected'}} @endif>{{ $van->plate_number }}</option>
                           @endforeach
                       </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Driver:</label>
                        <select class="form-control select2" name="driver" id="driver" val-driver required>
                            <option value="" selected>Select Driver</option>
                        @foreach ($drivers as $driver)
                           <option value="{{ $driver->member_id }}" @if($driver->member_id == old('driver') ) {{'selected'}} @endif>{{ $driver->full_name }}</option>
                           @endforeach
                       </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Number of Days: <span class="text-red">*</span></label>
                        <input type="number" class="form-control" placeholder="Number of Days" name="days" id="days" value="{{ old('days') }}" min="0" max="3" val-num-days required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Departure Date: <span class="text-red">*</span></label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control" name="date" id="date" value="{{ old('date') }}" placeholder="mm/dd/yyyy" data-inputmask="'alias': 'mm/dd/yyyy'" data-parsley-errors-container="#errDepartureDate" data-mask val-book-date data-parsley-valid-departure required>
                        </div>
                        <p id="errDepartureDate"></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class = "bootstrap-timepicker">
                        <div class="form-group">
                            <label>Departure Time: <span class="text-red">*</span></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="fa fa-clock-o"></i>
                                </div>
                                <input type="text" class="form-control" name="time" value="{{ old('time') }}" data-parsley-errors-container="#errDepartureTime" val-book-time required>
                            </div>
                            <p id="errDepartureTime"></p>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        <div class="box-footer">
            <div style="overflow:auto;">
                <input type="submit" class="btn btn-primary pull-right">
            </div>
        </div>
</div> 
@endsection
@section('scripts')
@parent
    <script>
    	$('#timepicker').timepicker({
    		template: false
         });
    </script>

    <script>
        
    </script>
    
    <script type="text/javascript">
        $(function () {
          var $sections = $('.form-section');

          function navigateTo(index) {
            // Mark the current section with the class 'current'
            $sections
              .removeClass('current')
              .eq(index)
                .addClass('current');
            // Show only the navigation buttons that make sense for the current section:
            $('.form-navigation .previous').toggle(index > 0);
            var atTheEnd = index >= $sections.length - 1;
            $('.form-navigation .next').toggle(!atTheEnd);
            $('.form-navigation [type=submit]').toggle(atTheEnd);
          }

          function curIndex() {
            // Return the current index by looking at which section has the class 'current'
            return $sections.index($sections.filter('.current'));
          }

          // Previous button is easy, just go back
          $('.form-navigation .previous').click(function() {
            navigateTo(curIndex() - 1);
          });

          // Next button goes forward iff current block validates
          $('.form-navigation .next').click(function() {
            $('.parsley-form').parsley().whenValidate({
              group: 'block-' + curIndex()
            })  .done(function() {
              navigateTo(curIndex() + 1);
            });
          });

          // Prepare sections by setting the `data-parsley-group` attribute to 'block-0', 'block-1', etc.
          $sections.each(function(index, section) {
            $(section).find(':input').attr('data-parsley-group', 'block-' + index);
          });
          navigateTo(0); // Start at the beginning
        });

        function getData() {

            var name = document.getElementById('name').value;
            document.getElementById('nameView').textContent = name;

            var contactNumber = document.getElementById('contactNumber').value;
            document.getElementById('contactView').textContent = contactNumber;

            var driver = $("#driver option:selected").text();
            document.getElementById('driverView').textContent = driver;

            var destination = document.getElementById('destination').value;
            document.getElementById('destView').textContent = destination;

            var vanType = document.getElementById('plateNumber').value;
            document.getElementById('vanView').textContent = vanType;

            var days = document.getElementById('days').value;
            document.getElementById('daysView').textContent = days;

            var date = document.getElementById('date').value;
            document.getElementById('dateView').textContent = date;

            var time = document.getElementById('timepicker').value;
            document.getElementById('timeView').textContent = time;
        }
    </script>

    <script>
    $('[data-mask]').inputmask()
    $('.date-mask').inputmask('mm/dd/yyyy',{removeMaskOnSubmit: true})
    </script>
    <script>
    function triggerDriver()
    {
        var van = document.getElementById('plateNumber').value;
        var driver = document.getElementById('driver');

        for (var i = 0; i < driver.options.length; i++) {
            if (driver.options[i].value == van) {
                driver.options[i].selected = true;
            }
        }        
    }
    </script>
    <script>
        $( "select[name='destination']" ).change(function() {
            if( $( this ).val() == 'other' ){
                $("input[name='otherDestination']").prop("disabled", false);
                $("input[name='otherDestination']").attr("placeholder", "Enter Destination");
            } else {
                $("input[name='otherDestination']").prop("disabled", true);
                $("input[name='otherDestination']").attr("placeholder", "");
            }
        });
    </script>
@endsection