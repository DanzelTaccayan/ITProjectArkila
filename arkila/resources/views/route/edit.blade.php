@extends('layouts.form')
@section('title', 'Edit Terminal/Destination')
@section('back-link', route('route.index'))
@section('form-action', route('route.update', $route->destination_id))
@if($route->is_terminal == true)
@section('form-title', 'EDIT TERMINAL')
@elseif($route->is_terminal == false)
@section('form-title', 'EDIT ROUTE')
@endif
@section('form-body')

{{ csrf_field() }} {{ method_field('PATCH') }}
  <div class="form-section">
      <div class="form-group">
          <label>Name: <span class="text-red">*</span> </label>
          <p class="info-container">{{$route->destination_name}}</p>
      </div>
      <div class="form-group">
          <label>Regular Fare: <span class="text-red">*</span> </label>
          <input type="number" class="form-control" min="1" max="5000" step=".01" name="regularFare" value="{{$fareReg->fare}}" val-regularFare required>
      </div>
      <div class="form-group">
          <label>Discounted Fare: <span class="text-red">*</span> </label>
          <input type="number" class="form-control" min="1" max="5000" step=".01" name="discountedFare" value="{{$fareDis->fare}}" val-discountFare required>
      </div> 
      <p><strong>NOTE:</strong> You can edit the ticket quantity in the manage tickets under Ticket Management tab.</p>
  </div>
  @if($route->is_terminal == true)
  <input type="hidden" name="type" value="Terminal">
  <div class="form-section">
    <div id="terminalForm">
      <div class="form-group">
          <label>Booking Fee: <span class="text-red">*</span> </label>
          <input type="number" class="form-control terminalInput terminalRequired" min="1" max="5000" name="bookingFee" value="{{$route->booking_fee}}" val-bookingFee step=".01" required>
      </div>
      <div class="form-group" id="shotTripReg">
          <label>Short Trip Fare Regular: <span class="text-red">*</span> </label>
          <input type="number" class="form-control terminalInput terminalRequired" min="1" max="5000" name="sTripFare" value="{{$route->short_trip_fare}}" val-regularStFare step=".01" required>
      </div>
       <div class="form-group" id="shotTripDis">
          <label>Short Trip Fare Discounted: <span class="text-red">*</span> </label>
          <input type="number" class="form-control terminalInput terminalRequired" min="1" max="5000" name="sdTripFare" value="{{$route->short_trip_fare_discount}}" step=".01" val-discountStFare required>
      </div>
        <div class="form-group" id="destination">
            <label>Destination Terminal: <span class="text-red">*</span> </label>
            @foreach($terminals as $count => $terminal)
                <div class="checkbox">
                    <label><input type="checkbox" class="routeRequired" name="dest[]" value="{{$terminal->destination_id}}"@foreach($route->routeDestination as $routeDes)@if($routeDes->destination_id == $terminal->destination_id) {{'checked'}}@endif @endforeach>{{$terminal->destination_name}}</label>
                </div>
            @endforeach
        </div>
    </div>
    @elseif($route->is_terminal == false)
    <input type="hidden" name="type" value="Route">
    <div class="form-section">
    <div id="terminalForm">
      <div class="form-group" id="origin">
        <label>Origin Terminal: <span class="text-red">*</span> </label>
        <input type="text" class="form-control" name="originTerm" value="{{$mainTerminal->destination_name}}" disabled>
      </div>
      <div class="form-group" id="destination">
          <label>Route:</label>
          @foreach($terminals as $count => $terminal)
          <div class="checkbox">
            <label><input type="checkbox" class="routeRequired" name="dest[]" value="{{$terminal->destination_id}}"@foreach($route->routeDestination as $routeDes)@if($routeDes->destination_id == $terminal->destination_id) {{'checked'}}@endif @endforeach>{{$terminal->destination_name}}</label>
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
    </script>
    </script>

@endsection
