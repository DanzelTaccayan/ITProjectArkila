@extends('layouts.master') 
@section('title', 'View Operator')  
@section('content')

<div class="box box-default with-shadow">
    <div class="box-header with-border text-center">
        <h4>
            @if($operator->status == 'Active')
                <a href="{{route('operators.showProfile',[$operator->member_id])}}" class="pull-left"><i class="fa  fa-chevron-left"></i></a>
            @else
                <a href="{{route('archive.showProfile',[$operator->member_id])}}" class="pull-left"><i class="fa  fa-chevron-left"></i></a>
            @endif
        </h4>
        <h3 class="box-title">
            VIEW OPERATOR INFORMATION
        </h3>
    </div>
    <div class="box-body">
        <h3><i class="fa fa-user"></i> {{$operator->last_name}}, {{$operator->first_name}} {{$operator->middle_name}}
        </h3>
        <hr>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="contactNumberO">Contact Number:</label>
                    <p id="contactNumberO" name="contactNumberO" class="info-container" data-editable>{{$operator->edit_contact_number}}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="addressO">Address:</label>
                    <p id="addressO" name="addressO" class="info-container" data-editable>{{$operator->address}}</p>
                </div>
            </div>
            <div class="col-md-4">
                 <div class="form-group">
                    <label for="provincialAddressO">Provincial Address:</label>
                    <p id="provincialAddressO" name="provincialAddressO" class="info-container" data-editable>{{$operator->provincial_address}}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="genderO">Gender:</label>
                    <p id="genderO" name="genderO" type="text" class="info-container">{{$operator->gender}}</p>
                </div>
                
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="sssO">SSS No:</label>
                    <p id="sssO" name="sssO" type="text" class="info-container">{{$operator->SSS}}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="licenseNoO">License No:</label>
                    <p id="licenseNoO" name="licenseNoO" class="info-container">{{$operator->license_number}}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="licenseExpiryDateO">License Expiry Date:</label>
                    <p id="licenseExpiryDateO" name="licenseExpiryDateO" class="info-container">{{$operator->expiry_date}}</p>
                </div>
            </div>
        </div>
        <hr>    
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="contactPersonO">Contact Person:</label>
                    <p id="contactPersonO" name="contactPersonO" class="info-container" placeholder="Contact Person In Case of Emergency">{{$operator->person_in_case_of_emergency}}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="addressO">Address:</label>
                    <p id="addressO" name="addressO" class="info-container" placeholder="Address">{{$operator->emergency_address}}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="contactNumberO">Contact Number:</label>
                    <p id="contactNumberO" name="contactNumberO" class="info-container" placeholder="Contact Number">{{$operator->emergency_contactno}}</p>
                </div>
            </div>
        </div>
        <div>
            <button onclick="window.open('{{route('pdf.perOperator', [$operator->member_id])}}')" class="btn btn-default btn-sm btn-flat pull-right"> <i class="fa fa-print"></i> PRINT</button> 
        </div>
    </div>
</div>
@endsection
@section('script')
@parent
<script>    
$('body').on('click', '[data-editable]', function(){
  
  var $el = $(this);
              
  var $input = $('<input/>').val( $el.text() );
  $el.replaceWith( $input );
  
  var save = function(){
    var $p = $('<p data-editable />').text( $input.val() );
    $input.replaceWith( $p );
  };
  
  /**
    We're defining the callback with `one`, because we know that
    the element will be gone just after that, and we don't want 
    any callbacks leftovers take memory. 
    Next time `p` turns into `input` this single callback 
    will be applied again.
  */
  $input.one('blur', save).focus();
  
});
</script>
@endsection