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
                <!-- One "tab" for each step in the form: -->
                <div class="form-section">
                    <h4>Trip Information</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Customer Name: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" placeholder="Last Name" name="lastName" id="lastName" value="{{ old('lastName') }}" val-fullname required>
                            </div>
                        </div>
                        <div class="col-md-4">
                             <div class="form-group">
                                <label>Contact Number: <span class="text-red">*</span></label>
                                <div class = "input-group">
                                    <div class = "input-group-addon">
                                        <span>+63</span>
                                    </div>
                                <input type="text" class="form-control" placeholder="Contact Number" name="contactNumber" id="contactNumber" value="{{ old('contactNumber') }}" data-inputmask='"mask": "999-999-9999"' data-parsley-errors-container="#errContactNumber" data-mask val-phone required>
                                </div>
                                <p id="errContactNumber"></p>
                            </div>
                        </div> 
                        <div class="col-md-4">
                             <div class="form-group">
                                <label>Destination: <span class="text-red">*</span></label>
                                <input type="text" class="form-control" placeholder="Destination" name="destination" id="destination" value="{{ old('destination') }}" val-book-dest required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Van:</label>
                                <select class="form-control select2" name="model" id="model">
                                    <option value="" selected>Select Van Unit</option>
                                @foreach ($models as $model)
                                   <option value="{{ $model->description }}" @if($model->description == old('model') ) {{'selected'}} @endif>{{ $model->description }}</option>
                                   @endforeach
                               </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Driver:</label>
                                <select class="form-control select2" name="model" id="model">
                                    <option value="" selected>Select Driver</option>
                                @foreach ($models as $model)
                                   <option value="{{ $model->description }}" @if($model->description == old('model') ) {{'selected'}} @endif>{{ $model->description }}</option>
                                   @endforeach
                               </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Number of Days: <span class="text-red">*</span></label>
                                <input type="number" class="form-control" placeholder="Number of Days" name="days" id="days" value="{{ old('days') }}" val-num-days required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        
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
                                        <input type="text" class="form-control" name="time" value="{{ old('time') }}" id = "timepicker" data-parsley-errors-container="#errDepartureTime" val-book-time required>
                                    </div>
                                    <p id="errDepartureTime"></p>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="form-section" style="margin-left:37%; font-size: 14pt">
                    <h4 style="margin-left:17%; margin-bottom:3%; font-size: 14pt">Summary</h4>
                    <div class = "row">
                           <dl class = "dl-horizontal">
                           <dt>Name:</dt>
                            <dd id="nameView"></dd>
                            <dt>Contact Number:</dt>
                            <dd id="contactView"></dd>
                            <dt>Destination:</dt>
                            <dd id="destView"></dd>
                            <dt>Van Model:</dt>
                            <dd id="vanView"></dd>
                            <dt>Number of Days:</dt>
                            <dd id="daysView"></dd>
                            <dt>Departure Date:</dt>
                            <dd id="dateView"></dd>
                            <dt>Departure Time:</dt>
                            <dd id="timeView"></dd>
                            </dl>
                        </div>
                </div>
                <!-- Circles which indicates the steps of the form: -->
                <div style="text-align:center;margin-top:40px;">
                    <span class="step"></span>
                    <span class="step"></span>
                </div>
        </div>
        <div class="box-footer">
            <div style="overflow:auto;">
                    <div class="form-navigation" style="float:right;">
                        <button type="button" id="prevBtn"  class="previous btn btn-default">Previous</button>
                        <button type="button" id="nextBtn" onclick="getData();"  class="next btn btn-primary">Next</button>
                        <input type="submit" class="btn btn-primary">
                    </div>
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
            var firstName = document.getElementById('firstName').value;
            var lastName = document.getElementById('lastName').value;
            var middleName = document.getElementById('middleName').value;

            document.getElementById('nameView').textContent = lastName + ', ' + firstName + ' ' + middleName;

            var contactNumber = document.getElementById('contactNumber').value;
            document.getElementById('contactView').textContent = contactNumber;

            var destination = document.getElementById('destination').value;
            document.getElementById('destView').textContent = destination;

            var vanType = document.getElementById('model').value;
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
    
  
      @include('message.error')
@endsection