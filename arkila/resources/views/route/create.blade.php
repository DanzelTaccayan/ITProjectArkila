@extends('layouts.form')
@section('title', 'Create New Terminal/Destination')
@section('back-link', route('settings.index'))
@section('form-action', route('terminal.store'))
@section('form-title', 'CREATE TERMINAL/ROUTE')
@section('form-body')

	 <div class="form-section">
        <div class="form-group">
            <label>Name: <span class="text-red">*</span> </label>
            <input type="text" class="form-control" name="addName" required>
        </div>
        <div class="form-group">
            <label>Regular Fare: <span class="text-red">*</span> </label>
            <input type="number" class="form-control" min="0" step="0.25" name="regularFare" required>
        </div>
        <div class="form-group">
            <label>Discounted Fare: <span class="text-red">*</span> </label>
            <input type="number" class="form-control" min="0" step="0.25" name="regularFare">
        </div>
        <div class="form-group">
            <label>Number of Tickets: <span class="text-red">*</span> </label>
            <input type="number" class="form-control" min="0" step="0.25" name="numticket" required="">
        </div>
        <div class="form-group">
        	<label>Type:</label>
	        <div class="radio text-center">
	            <label for=""> Terminal</label>
	            <label class="radio-inline">
	                <input type="radio" name="termRoute" checked="checked"  value="Terminal" class="flat-blue">
	            </label>

	            <label for="">Route</label>
	            <label class="radio-inline">
	                <input type="radio" name="termRoute" value="Route" class="flat-blue" >
	            </label>
	        </div>
        </div>
    </div>

    <div class="form-section">
    	<div class="form-group">
          <label>Booking Fee: <span class="text-red">*</span> </label>
          <input type="number" class="form-control" min="0" step="0.25" name="bookingFee" required>
      </div>
      <div class="form-group">
          <label>Short Trip Fare Regular: <span class="text-red">*</span> </label>
          <input type="number" class="form-control" min="0" step="0.25" name="sTripFare">
      </div>
       <div class="form-group">
          <label>Short Trip Fare Discounted: <span class="text-red">*</span> </label>
          <input type="number" class="form-control" min="0" step="0.25" name="sdTripFare">
      </div>
    </div>

    <div class="form-section">
      <div class="form-group">
        <label>Origin Terminal: <span class="text-red">*</span> </label>
        <input type="text" class="form-control" name="originTerm" disabled>
      </div>
      
      <div class="form-group">
          <label>Destination Terminal: <span class="text-red">*</span> </label>
          <div class="checkbox">
            <label><input type="checkbox" value="">Cabanatuan</label>
          </div>
          <div class="checkbox">
            <label><input type="checkbox" value="">San Jose City</label>
          </div>
      </div>
    </div>

	@section('form-btn')
     <div style="overflow:auto;">
          <div class="form-navigation" style="float:right;">
              <button type="button" id="prevBtn" class="previous btn btn-default">Previous</button>
              <button type="button" id="nextBtn" class="next btn btn-primary">Next</button>
              <input type="submit" class="btn btn-primary">
          </div>
      </div>
  @endsection    

@endsection
@section('scripts') 
@parent

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
              navigateTo(curIndex() + 1);
          });

          // Prepare sections by setting the `data-parsley-group` attribute to 'block-0', 'block-1', etc.
          $sections.each(function(index, section) {
            $(section).find(':input').attr('data-parsley-group', 'block-' + index);
          });
          navigateTo(0); // Start at the beginning
        });
    </script>

@endsection
