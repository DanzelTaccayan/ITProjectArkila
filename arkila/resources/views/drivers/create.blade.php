@extends('layouts.form_lg') 
@section('title', 'Driver Registration')
@section('form-id', 'regForm')

@if ( isset($operator) )
    @section('form-action',route('drivers.storeFromOperator',[$operator->member_id]))
    @section('backRef') {{ route('operators.show',[$operator->member_id]) }} @endsection
@elseif ( isset($vanNd) )
    @section('form-action',route('drivers.storeFromVan',[$vanNd->van_id]))
    @if(session()->get('vanBack'))
        @section('backRef') {{ session()->get('vanBack') }} @endsection
    @else
        @section('backRef') {{ route('vans.index') }} @endsection
    @endif
@else
    @section('form-action',route('drivers.store'))
    @section('backRef') {{ route('drivers.index') }} @endsection
@endif


@section('form-body')
<div class="margin-side-10">
    <div class="box box-warning" style="box-shadow: 0px 5px 10px gray;">
        <div class="box-header with-border text-center">
            <h4>    
            <a href="@yield('backRef')" class="pull-left"><i class="fa  fa-chevron-left"></i></a>
            </h4>
            <h3 class="box-title">
                DRIVER REGISTRATION
            </h3>
        </div>
        <div class="box-body">
            <div class="padding-side-15">
                <h4 class="form-heading-orange">Personal Information</h4>
                <table class="table table-bordered table-striped form-table">
                    <tbody>
                            @if(isset($operator))
                                <tr>
                                    <th>
                                        Operator
                                    </th>
                                    <td id="opName">
                                        {{$operator->full_name}}
                                    </td>
                                </tr>
                            @elseif(isset($vanNd))
                                <tr>
                                    <th>
                                        Operator
                                    </th>
                                    <td>
                                        {{ $vanNd->operator->first()->full_name}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Van Unit
                                    </th>
                                    <td>
                                        {{ $vanNd->plate_number}}
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <th>
                                        Operator
                                    </th>
                                    <td>
                                        <select name="operator" id="" class="form-control select2">
                                            <option value='' @if(!old('operator')) {{'selected'}} @endif>No Operator</option>
                                            @foreach($operators as $operator)
                                                <option value={{$operator->member_id}} @if($operator->member_id == old('operator')) {{'selected'}}@endif>{{$operator->full_name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            @endif
                        <tr>
                            <th>
                                Last Name <span class="text-red">*</span>
                            </th>
                            <td>
                                <input value="{{old('lastName')}}" name="lastName" type="text" class="form-control" placeholder="Last Name" val-name required>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                First Name <span class="text-red">*</span>
                            </th>
                            <td>
                                <input value="{{old('firstName')}}" name="firstName" type="text" class="form-control" placeholder="First Name" val-name required>
                            </td>
                        </tr>
                        <tr>
                            <th>
                               Middle Name
                            </th>
                            <td>
                                <input value="{{old('middleName')}}" name="middleName" type="text" class="form-control" placeholder="Middle Name" val-name>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Contact Number <span class="text-red">*</span>
                            </th>
                            <td>
                                <input type="text" name="contactNumber"  class="form-control" value="{{old('contactNumber')}}" placeholder="Contact Number" val-contact required>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Address <span class="text-red">*</span>
                            </th>
                            <td>
                                <input value="{{old('address')}}" name="address" type="text" class="form-control" placeholder="Address" val-address required>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Provincial Address <span class="text-red">*</span>
                            </th>
                            <td>
                                <input value="{{old('provincialAddress')}}" name="provincialAddress" type="text" class="form-control" placeholder="Provincial Address" val-address required>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Gender <span class="text-red">*</span>
                            </th>
                            <td>
                                <div class="radio">
                                    <label for=""> Male</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" checked="checked"  value="Male" class="flat-blue" @if(old('gender') == 'Male') {{'checked'}}@endif>
                                    </label>
                                    <label for="">Female</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" value="Female" class="flat-blue" @if(old('gender') == 'Female') {{'checked'}}@endif>
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                SSS No
                            </th>
                            <td>
                                <input value="{{old('sss')}}" name="sss" type="text" class="form-control" placeholder="SSS No." val-sss>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                License No <span class="text-red">*</span>
                            </th>
                            <td>
                               <input value="{{old('licenseNo')}}" name="licenseNo" type="text" class="form-control" placeholder="License No." val-license required> 
                            </td>
                        </tr>
                        <tr>
                            <th>
                                License Expiry Date <span class="text-red">*</span>
                            </th>
                            <td>
                                <input type="text" name="licenseExpiryDate" class="form-control date-mask" placeholder="mm/dd/yyyy" value="{{old('licenseExpiryDate')}}" data-inputmask="'alias': 'mm/dd/yyyy'" val-license-exp required>
                            </td>
                        </tr>
                        <tr>
                            <th>Profile Picture</th>
                            <td><input type="file" name="profilePicture" accept="image/*"></td>
                        </tr>
                    </tbody>
                </table>

                <h4 class="form-heading-orange">Contact Person</h4>

                <table class="table table-bordered table-striped form-table">
                    <tbody>
                        <tr>
                            <th>Name <span class="text-red">*</span></th>
                            <td>
                                <input value="{{old('contactPerson')}}" name="contactPerson" type="text" class="form-control" placeholder="Contact Person In Case of Emergency" val-cname required>
                            </td>
                        </tr>
                        <tr>
                            <th>Address <span class="text-red">*</span></th>
                            <td>
                                <input value="{{old('contactPersonAddress')}}" name="contactPersonAddress" type="text" class="form-control" placeholder="Address" val-address required>
                            </td>
                        </tr>
                        <tr>
                            <th>Contact Number <span class="text-red">*</span></th>
                            <td>
                                <input type="text" name="contactPersonContactNumber"  class="form-control" value="{{old('contactPersonContactNumber')}}" placeholder="Contact Number" val-contact required>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

             
      {{--   @if(isset($operator))
            <label for="opName">Operator Name: </label>
            <span id="opName">{{$operator->full_name}}</span>
        @elseif(isset($vanNd))
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Van Unit</label>
                    <span id="">{{ $vanNd->plate_number}}</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Operator of the Van Unit</label>
                    <span id="">{{ $vanNd->operator->first()->full_name}}</span>
                </div>
            </div>
        @else
            <label>Choose Operator:</label>
            <select name="operator" id="" class="form-control select2">
                <option value='' @if(!old('operator')) {{'selected'}} @endif>No Operator</option>
                @foreach($operators as $operator)
                    <option value={{$operator->member_id}} @if($operator->member_id == old('operator')) {{'selected'}}@endif>{{$operator->full_name}}</option>
                @endforeach
            </select>
        @endif --}}
        </div>
        <div class="box-footer">
            <div style="overflow:auto;">
                    <div class="text-center">
                        <input type="submit" class="btn btn-success" value="REGISTER">
                    </div>
                </div>
        </div>
    </div> 
</div>
@endsection
@section('scripts')
@parent
 <script>
     $(document).ready(function(){
         $('input[type="submit"]').on('click',function(){
             if($('input[name="licenseExpiryDate"]').val() === "") {
                 $('input[name="licenseExpiryDate"]').val(null);
             }
         });

         cloneDateMask();
     });

        function cloneDateMask() {

            //Date picker
            $('.date-mask').inputmask('mm/dd/yyyy',{removeMaskOnSubmit: true})

        }
    </script>

    <script>
    $(function () {

        $('.select2').select2();

        $('#datepicker').datepicker({
          autoclose: true
        });

        $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
          checkboxClass: 'icheckbox_flat-blue',
          radioClass   : 'iradio_flat-blue'
        });

        $('[data-mask]').inputmask();
        $('.date-mask').inputmask('mm/dd/yyyy',{removeMaskOnSubmit: true});
    });

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
    </script>
@endsection