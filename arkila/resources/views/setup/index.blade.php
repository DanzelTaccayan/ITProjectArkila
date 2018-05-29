@extends('layouts.startup')
@section('title', 'Setting Up')
@section('form-action', route('setup.store'))
@section('links')
@parent
<style>
.col-md-6 {
    position: relative;
    min-height: 1px;
    padding-right: 0px;
    padding-left: 0px;
}

.left{
    padding-right: 10px;
}

.right{
    padding-left: 10px;
}

.step.active {
    background-color: darkslategray;
}

</style>
@endsection
@section('form-body')

<div class="box" style="margin: 8% 0%">  
    <div class="box-body">

        <!-- WELCOME -->
        <div class="form-section" style="margin-bottom: 0%; padding: 6% 4% 3% 4%">
            
            <img class="profile-user-img img-responsive img-circle" src="{{ URL::asset('img/bantrans-logo.png') }}" alt="profile picture">
            <h2 class="text-center"><strong>Ban Trans - UV Express</strong></h2> 
            <hr>
            <p class="text-justify" style="font-size: 12pt"><strong>WELCOME! </strong>Lets get started by clicking on the next button below. You are required to fill in necessary information about the company such as the contact number, address and email. As we move along, you will be required to set the main terminal, destination terminal and fees by simply filling in the necessary information.</p>

            <div style="text-align:center;margin-top:40px;">
                <span class="step active"></span>
                <span class="step"></span>
                <span class="step"></span>
                <span class="step"></span>
            </div>
        </div>

        <!-- Company Profile-->
        <div class="form-section" >
            <div class="box-header with-border text-center">
                <h1 ><strong>COMPANY INFORMATION</strong></h1>
            </div>

            <div style="padding: 2% 10% 0% 10%">
                <div class="form-group">
                    <label for="contactNumber">Contact Number: </label>
                    <input type="text" class="form-control" name="contactNumber" value="{{old('contactNumber')}}" val-contact>    
                </div>

                <div class="form-group">
                    <label>Address:</label>
                    <input type="text" class="form-control" name="address" value="{{old('address')}}" val-address>
                </div>
                <div class="form-group">
                    <label>Email: </label>
                    <input type="text" class="form-control" name="email" value="{{old('email')}}">
                </div>
                <p class="font-italic"><strong>NOTE:</strong> The information you will enter can be edited in the Company Profile page under the Settings tab.</p>
            </div>
            <div style="text-align:center;margin-top:40px;">
                <span class="step"></span>
                <span class="step active"></span>
                <span class="step"></span>
                <span class="step"></span>
            </div>
        </div>
        
        <!--Terminals -->
        <div class="form-section">
            <div class="box-header with-border text-center">
                <h1><strong>TERMINALS</strong></h1>
            </div>
            <div style="padding: 2% 10% 0% 10%">
                <h4><strong>Main Terminal</strong></h4> 
                <div class="form-group">
                    <label>Name: <span class="text-red">*</span> </label>
                    <input type="text" class="form-control" name="addMainTerminal" value="{{old('addMainTerminal')}}" required>
                </div>
                <div class="form-group">
                    <label>Booking Fee: <span class="text-red">*</span> </label>
                    <input type="number" class="form-control terminalInput terminalRequired" min="0" name="mainBookingFee" value="{{old('mainBookingFee')}}" required>
                </div>
        
                <h4><strong>Destination Terminal</strong></h4> 
                <div class="form-group">
                    <label>Name: <span class="text-red">*</span> </label>
                    <input type="text" class="form-control" name="addTerminal" value="{{old('addTerminal')}}" required>
                </div>
                <div class="form-group">
                    <label>Booking Fee: <span class="text-red">*</span> </label>
                    <input type="number" class="form-control terminalInput terminalRequired" min="0" name="bookingFee" value="{{old('bookingFee')}}" val-bookingFee required>
                </div>

                <div class="form-group col-md-6 left">
                    <label>Regular Fare: <span class="text-red">*</span> </label>
                    <input type="number" class="form-control" min="0" name="regularFare" placeholder="Php 0.00" value="{{old('regularFare')}}" val-regularFare required>
                </div>
                <div class="form-group col-md-6 right">
                    <label>Discounted Fare: <span class="text-red">*</span> </label>
                    <input type="number" class="form-control" min="0" name="discountedFare" placeholder="Php 0.00" value="{{old('discountedFare')}}" val-discountFare required>
                </div>
                <div class="form-group col-md-6 left">
                    <label>Number of Regular Tickets: <span class="text-red">*</span> </label>
                    <input type="number" class="form-control" min="1" step="1" name="numticket" value="{{old('numticket')}}" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" val-regularTick required>
                </div>
                <div class="form-group col-md-6 right">
                    <label>Number of Discounted Tickets: <span class="text-red">*</span> </label>
                    <input type="number" class="form-control disTicket" min="26" step="26" name="numticketDis" value="{{old('numticketDis')}}" val-discountTick required>
                </div>
                <div class="form-group col-md-6 left" id="shotTripReg">
                    <label>Short Trip Fare Regular: <span class="text-red">*</span> </label>
                    <input type="number" class="form-control terminalInput terminalRequired" min="0" name="sTripFare" placeholder="Php 0.00" value="{{old('sTripFare')}}" val-regularStFare required>
                </div>
                <div class="form-group col-md-6 right" id="shotTripDis">
                    <label>Short Trip Fare Discounted: <span class="text-red">*</span> </label>
                    <input type="number" class="form-control terminalInput terminalRequired" min="0" name="sdTripFare" placeholder="Php 0.00" value="{{old('sdTripFare')}}" val-discountStFare required>
                </div>
                <p class="font-italic"><strong>NOTE:</strong> You can add more terminals after setting up in the Terminals and Routes page.</p>
            </div>
            <div style="text-align:center;margin-top:40px;">
                <span class="step"></span>
                <span class="step"></span>
                <span class="step active"></span>
                <span class="step"></span>
            </div>
        </div>

        <!-- Fees -->
        <div class="form-section">
            <div class="box-header with-border text-center">
                <h1><Storng>ADDITIONAL FEES</Storng></h1>
            </div>

            <div style="padding: 2% 10% 0% 10%">
                <div class="form-group">
                    <label>Description:</label>
                    <input type="text" class="form-control" name="addFeesDescSop" value="SOP" readonly>
                </div>
                <div class="form-group">
                    <label>Amount: <span class="text-red">*</span></label>
                    <input type="number" class="form-control" name="addSop" min="0" step="0.25" placeholder="Php 0.00" value="{{old('addSop')}}" val-sop required>
                </div>
                <div class="form-group">
                    <label>Description:</label>
                    <input type="text" class="form-control" name="addFeesDescCom" value="Community Fund" readonly>
                </div>
                <div class="form-group">
                    <label>Amount: <span class="text-red">*</span></label>
                    <input type="number" class="form-control" name="addComFund" min="0" placeholder="Php 0.00" value="{{old('addComFund')}}" val-cf required>
                </div>
                <p class="font-italic"><strong>NOTE:</strong> You can edit these amounts in the Fees and Features page under the Settings tab.</p>
            </div>
            <div style="text-align:center;margin-top:40px;">
                <span class="step"></span>
                <span class="step"></span>
                <span class="step"></span>
                <span class="step active"></span>
            </div>
        </div>

    </div>

    <div class="box-footer">
        <div style="overflow:auto;">
            <div class="form-navigation" style="float:right;">
                <button type="button" id="prevBtn" class="previous btn btn-default">Previous</button>
                <button type="button" id="nextBtn" class="next btn btn-primary">Next</button>
                <input type="submit" class="btn btn-primary">
            </div>
        </div>
    </div>
</div>  
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
    <script>
   $(".disTicket").keydown(function (e) {
        var key = e.keyCode || e.charCode;
        if (key == 8 || key == 46) {
            e.preventDefault();
            e.stopPropagation();
    }
   });

    $(".disTicket").keypress(function (evt) {
        evt.preventDefault();
    });

    </script>

@endsection
