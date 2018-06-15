@extends('layouts.form')
@section('title', 'Create New Terminal/Destination')
@section('back-link', route('route.index'))
@section('form-action', route('route.store'))
@if ($type == 'Terminal')
@section('form-title', 'CREATE TERMINAL')
@elseif ($type == 'Route')
@section('form-title', 'CREATE DESTINATION')
@endif

@section('form-body')

  <div class="form-section">
      <div class="form-group">
          <label>Name: <span class="text-red">*</span> </label>
          <input type="text" class="form-control" name="addTerminal" value="{{old('addTerminal')}}" required>
      </div>
      <div class="form-group">
          <label>Regular Fare: <span class="text-red">*</span> </label>
          <input type="number" class="form-control" min="1" max="5000" placeholder="Php 0.00" name="regularFare" value="{{old('regularFare')}}" val-regularFare step=".01" required>
      </div>
      <div class="form-group">
          <label>Discounted Fare: <span class="text-red">*</span> </label>
          <input type="number" class="form-control" min="1" max="5000" placeholder="Php 0.00" name="discountedFare" value="{{old('discountedFare')}}" val-discountFare step=".01" required>
      </div>
      <div class="form-group">
          <label>Number of Regular Tickets: <span class="text-red">*</span> </label>
          <input type="number" class="form-control" min="1" step="1" name="numticket" value="{{old('numticket')}}" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" val-regularTick required>
      </div>
      <div class="form-group">
          <label>Number of Discount Tickets: <span class="text-red">*</span> </label>
          <input type="number" class="form-control" min="26" step="26" name="numticketDis" value="{{old('numticketDis')}}" val-discountTick required>
          <p><strong>NOTE:</strong> Discount tickets are in intervals of 26 based on the letters of the alphabet. (use up and down arrow keys.)</p> 
      </div>
  </div>
  @if ($type == 'Terminal')
  <input type="hidden" name="type" value="Terminal">
  <div class="form-section">
    <div id="terminalForm">
      <div class="form-group">
          <label>Booking Fee: <span class="text-red">*</span> </label>
          <input type="number" class="form-control terminalInput terminalRequired" min="1" max="5000" placeholder="Php 0.00" name="bookingFee" value="{{old('bookingFee')}}" step=".01" val-bookingFee required>
      </div>
      <div class="form-group" id="shotTripReg">
          <label>Short Trip Regular Fare: <span class="text-red">*</span> </label>
          <input type="number" class="form-control terminalInput terminalRequired" min="1" max="5000" placeholder="Php 0.00" name="sTripFare" value="{{old('sTripFare')}}" step=".01" val-regularStFare required>
      </div>
       <div class="form-group" id="shotTripDis">
          <label>Short Trip Discounted Fare: <span class="text-red">*</span> </label>
          <input type="number" class="form-control terminalInput terminalRequired" min="1" max="5000" placeholder="Php 0.00" name="sdTripFare" value="{{old('sdTripFare')}}" step=".01" val-discountStFare required>
      </div>
    </div>
    @elseif ($type == 'Route')
    <input type="hidden" name="type" value="Route">
    <div class="form-section">
    <div id="terminalForm">
      <div class="form-group" id="origin">
        <label>Origin Terminal: <span class="text-red">*</span> </label>
        <input type="text" class="form-control" name="originTerm" value="{{$mainTerminal->destination_name}}" disabled>
      </div>
      <div class="form-group" id="destination">
          <label>Destination Terminal: <span class="text-red">*</span> </label>
          @foreach($terminals as $count => $terminal)
          <div class="checkbox">
            <label><input type="checkbox" class="routeRequired" name="dest[]" value="{{$terminal->destination_id}}">{{$terminal->destination_name}}</label>
          </div>
          @endforeach
      </div>
    </div>
    @endif
  </div>

    <!-- <div class="form-section">
    </div> -->

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
    
      $('[name="numticketDis"]').keydown(function (e) {
        var key = e.keyCode || e.charCode;
        if (key == 8 || key == 46) {
            e.preventDefault();
            e.stopPropagation();
        }
      });

      $('[name="numticketDis"]').keypress(function (evt) {
        evt.preventDefault();
      });
    </script>

@endsection
