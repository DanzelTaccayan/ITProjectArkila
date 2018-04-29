@extends('layouts.form_lg') 
@section('title', 'Operator Registration')
@section('links')
@parent
<style>
    th{
        width:200px;
        padding:20px;
    }
</style>
@endsection
@section('form-id','regForm')
@section('form-action',route('operators.store'))
@section('form-body')
<div class="box box-primary with-shadow">
        <div class="box-header with-border text-center">
            <h4>
            <a href="{{route('operators.index')}}" class="pull-left"><i class="fa  fa-chevron-left"></i></a>    
            </h4>
            <h4 class="box-title">
                Operator Registration
            </h4>
        </div>

        <div class="box-body">
          <div class="row">
            <div class="col-md-7">
              <h4>Personal Information</h4>
              <hr>
              <table class="table table-bordered table-striped">
                  <tbody>
                    <tr>
                      <th>Last Name <span class="text-red">*</span></th>
                      <td><input value="{{old('lastName')}}" name="lastName" type="text" class="form-control val-name" placeholder="Last Name" val-name required></td>
                    </tr>
                    <tr>
                      <th>First Name <span class="text-red">*</span></th>
                      <td><input value="{{old('firstName')}}" name="firstName" type="text" class="form-control" placeholder="First Name" val-name required></td>
                    </tr>
                    <tr>
                      <th>Middle Name</th>
                      <td><input value="{{old('middleName')}}" name="middleName" type="text" class="form-control" placeholder="Middle Name" val-name></td>
                    </tr>
                    <tr>
                      <th>Contact Number <span class="text-red">*</span></th>
                      <td><div class="input-group">
                                  <div class="input-group-addon">
                                    <span>+63</span>
                                  </div>
                                  <input type="text" name="contactNumber"  class="form-control" value="{{old('contactNumber')}}" placeholder="Contact Number" data-inputmask='"mask": "999-999-9999"' data-mask required data-parsley-errors-container="#errContactNumber" val-phone required>
                                </div>
                                <p id="errContactNumber"></p></td>
                    </tr>
                    <tr>
                      <th>Address: <span class="text-red">*</span></th>
                      <td><input value="{{old('address')}}" name="address" type="text" class="form-control" placeholder="Address" val-address  required></td>
                    </tr>
                    <tr>
                      <th>Gender: <span class="text-red">*</span></th>
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
                      <th>SSS No</th>
                      <td>
                        <input value="{{old('sss')}}" name="sss" type="text" class="form-control" placeholder="SSS No." val-sss data-inputmask='"mask": "99-9999999-9"' data-mask>
                      </td>
                    </tr>
                    <tr>
                      <th>License No</th>
                      <td>
                        <input value="{{old('licenseNo')}}" name="licenseNo" type="text" class="form-control" placeholder="License No." val-license data-inputmask='"mask": "A99-99-999999"' data-mask>
                      </td>
                    </tr>
                    <tr>
                      <th>License Expiry Date</th>
                      <td>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input value="{{old('licenseExpiryDate')}}" name="licenseExpiryDate" type="text" class="form-control date-mask" placeholder="mm/dd/yyyy" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask data-parsley-errors-container="#errExpireDate" val-license-exp data-parsley-expire-date>
                        </div>
                        <p id= "errExpireDate"></p>
                      </td>
                    </tr>
                    <tr>
                      <th>Profile Picture</th>
                      <td><input type="file" name="profilePicture" accept="image/*"></td>
                    </tr>
                  </tbody>
                </table>
                <h4>Contact Person</h4>
                <hr>
                <table class="table table-bordered table-striped">
                  <tbody>
                    <tr>
                      <th>Name</th>
                      <td>
                        <input value="{{old('contactPerson')}}" name="contactPerson" type="text" class="form-control" placeholder="Contact Person In Case of Emergency" val-name required>
                      </td>
                    </tr>
                    <tr>
                      <th>Address</th>
                      <td>
                         <input value="{{old('contactPersonAddress')}}" name="contactPersonAddress" type="text" class="form-control" placeholder="Address" val-address required>
                      </td>
                    </tr>
                    <tr>
                      <th>Contact Number</th>
                      <td>
                        <div class="input-group">
                          <div class="input-group-addon">
                            <span>+63</span>
                          </div>
                          <input type="text" name="contactPersonContactNumber"  class="form-control" value="{{old('contactPersonContactNumber')}}" placeholder="Contact Number" data-inputmask='"mask": "999-999-9999"' data-mask data-parsley-errors-container="#errContactPersonPhone" val-phone required>
                        </div>
                        <p id="errContactPersonPhone"></p>
                      </td>
                    </tr>
                  </tbody>
                </table>
            </div>
          </div>
                
                <!-- One "tab" for each step in the form: -->
                <div class="form-section">
                    {{-- <form action="">
                        <div class="form-group">
                           <label>Add profile image</label>
                           <input type="file" name="profilePicture" accept="image/*">
                        </div>
                    </form> --}}
                    {{-- <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Last Name: <span class="text-red">*</span></label>
                                <input value="{{old('lastName')}}" name="lastName" type="text" class="form-control val-name" placeholder="Last Name" val-name required> 
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>First Name: <span class="text-red">*</span></label>
                                <input value="{{old('firstName')}}" name="firstName" type="text" class="form-control" placeholder="First Name" val-name required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Middle Name:</label>
                                <input value="{{old('middleName')}}" name="middleName" type="text" class="form-control" placeholder="Middle Name" val-name>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                             <div class="form-group">
                             	<label>Contact Number: <span class="text-red">*</span></label>
                                <div class="input-group">
                                  <div class="input-group-addon">
                                    <span>+63</span>
                                  </div>
                                  <input type="text" name="contactNumber"  class="form-control" value="{{old('contactNumber')}}" placeholder="Contact Number" data-inputmask='"mask": "999-999-9999"' data-mask required data-parsley-errors-container="#errContactNumber" val-phone required>
                                </div>
                                <p id="errContactNumber"></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                             <div class="form-group">
                                <label>Address: <span class="text-red">*</span></label>
                                <input value="{{old('address')}}" name="address" type="text" class="form-control" placeholder="Address" val-address  required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Provincial Address: <span class="text-red">*</span></label>
                                <input value="{{old('provincialAddress')}}" name="provincialAddress" type="text" class="form-control" placeholder="Provincial Address" val-address required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                       <div class="col-md-4">
                            <div class="form-group">
                                <label>Gender: <span class="text-red">*</span></label>
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
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>SSS No:</label>
                                <input value="{{old('sss')}}" name="sss" type="text" class="form-control" placeholder="SSS No." val-sss data-inputmask='"mask": "99-9999999-9"' data-mask>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>License No:</label>
                                <input value="{{old('licenseNo')}}" name="licenseNo" type="text" class="form-control" placeholder="License No." val-license data-inputmask='"mask": "A99-99-999999"' data-mask>
                            </div>
                        </div>
                    </div> 
                    <div class="row"> 
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>License Expiry Date:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input value="{{old('licenseExpiryDate')}}" name="licenseExpiryDate" type="text" class="form-control date-mask" placeholder="mm/dd/yyyy" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask data-parsley-errors-container="#errExpireDate" val-license-exp data-parsley-expire-date>
                                </div>
                                <p id= "errExpireDate"></p>
                            </div>
                        </div>
                    </div> --}}
                    <hr>    {{-- 
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Contact Person: <span class="text-red">*</span></label>
                                <input value="{{old('contactPerson')}}" name="contactPerson" type="text" class="form-control" placeholder="Contact Person In Case of Emergency" val-name required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Address: <span class="text-red">*</span></label>
                                <input value="{{old('contactPersonAddress')}}" name="contactPersonAddress" type="text" class="form-control" placeholder="Address" val-address required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Contact Number: <span class="text-red">*</span></label>
                                <div class="input-group">
                                  <div class="input-group-addon">
                                    <span>+63</span>
                                  </div>
                                  <input type="text" name="contactPersonContactNumber"  class="form-control" value="{{old('contactPersonContactNumber')}}" placeholder="Contact Number" data-inputmask='"mask": "999-999-9999"' data-mask data-parsley-errors-container="#errContactPersonPhone" val-phone required>
                                </div>
                                <p id="errContactPersonPhone"></p>
                            </div>
                        </div>
                    </div> --}}
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
                        <button type="button" id="nextBtn"  class="next btn btn-primary">Next</button>
                        <input type="submit" class="btn btn-primary">
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
                $('input[name="childrenBDay[]"]').each(function(key,value) {
                    if($(value).val() === '')
                    {
                        $(value).val(null);
                    }
                });

                 if($('input[name="sss"]').val() === ""){
                     $('input[name="sss"]').val(null);
                 }

                 if($('input[name="spouseBirthDate"]').val() === ""){
                     $('input[name="spouseBirthDate"]').val(null);
                 }

                if($('input[name="licenseExpiryDate"]').val() === ""){
                    $('input[name="licenseExpiryDate"]').val(null);
                }
         });

         cloneDateMask();
         switch($('select[name="civilStatus"]').val()){
             case "Single":
                 $('input[name="nameOfSpouse"]').prop('disabled',true);
                 $('input[name="spouseBirthDate"]').prop('disabled', true);
                 break;
             case "Divorced":
                 $('input[name="nameOfSpouse"]').prop('disabled',true);
                 $('input[name="spouseBirthDate"]').prop('disabled', true);
                 break;
             default:
                 $('input[name="nameOfSpouse"]').prop('disabled',false);
                 $('input[name="spouseBirthDate"]').prop('disabled', false);
                 break;
         }


         $('select[name="civilStatus"]').change(function(){
             switch($('select[name="civilStatus"]').val()){
                 case "Single":
                     $('input[name="nameOfSpouse"]').prop('disabled',true);
                     $('input[name="spouseBirthDate"]').prop('disabled', true);
                     break;
                 case "Divorced":
                     $('input[name="nameOfSpouse"]').prop('disabled',true);
                     $('input[name="spouseBirthDate"]').prop('disabled', true);
                     break;
                 default:
                     $('input[name="nameOfSpouse"]').prop('disabled',false);
                     $('input[name="spouseBirthDate"]').prop('disabled', false);
                     break;
             }
         });
     });

        function cloneDateMask() {

            $('.date-mask').inputmask('mm/dd/yyyy',{removeMaskOnSubmit: true})

        }

        function addDependent() {
            var tablebody = document.getElementById('childrens');
            if (tablebody.rows.length == 1) {
                tablebody.rows[0].cells[tablebody.rows[0].cells.length - 1].children[0].children[0].style.display = "";
            }   


            var tablebody = document.getElementById('childrens');
            var iClone = tablebody.children[0].cloneNode(true);
            for (var i = 0; i < iClone.cells.length; i++) {
                iClone.cells[i].children[0].value = "";
                iClone.cells[1].children[0].children[1].value="";
            
            }
            tablebody.appendChild(iClone);
            cloneDateMask();
        }
        

        function rmv() {
            var tabRow = document.getElementById("childrens");
            if (tabRow.rows.length == 1) {
                tabRow.rows[0].cells[tabRow.rows[0].cells.length - 1].children[0].children[0].style.display = "none";
            } else {
                tabRow.rows[0].cells[tabRow.rows[0].cells.length - 1].children[0].children[0].style.display = "";
            }
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