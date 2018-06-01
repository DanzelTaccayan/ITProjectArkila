@extends('layouts.form_lg') 
@section('title', 'Operator Registration')
@section('form-id','regForm')
@section('form-action',route('operators.store'))
@section('form-body')
  <div class="margin-side-10">  
    <div class="box box-primary with-shadow">
      <div class="box-header with-border text-center">
          <h4>
          <a href="{{route('operators.index')}}" class="pull-left"><i class="fa  fa-chevron-left"></i></a>
          </h4>
          <h4 class="box-title">
              OPERATOR REGISTRATION
          </h4>
      </div>
      <div class="box-body">
        <div class="padding-side-15"> 
          <h4 class="form-heading-blue">Personal Information</h4>
          <table class="table table-bordered table-striped form-table">
                <tbody>
                  <tr>
                    <th>Last Name <span class="text-red">*</span></th>
                    <td><input value="{{old('lastName')}}" name="lastName" type="text" class="form-control" placeholder="Last Name" val-name required></td>
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
                    <td>  
                      <input type="text" name="contactNumber"  class="form-control" value="{{old('contactNumber')}}" placeholder="Contact Number" required data-parsley-errors-container="#errContactNumber" val-contact required>
                    </td>
                  </tr>
                  <tr>
                    <th>Address <span class="text-red">*</span></th>
                    <td><input value="{{old('address')}}" name="address" type="text" class="form-control" placeholder="Address" val-address  required></td>
                  </tr>
                  <tr>
                    <th>Provinicial Address <span class="text-red">*</span></th>
                    <td><input value="{{old('provincialAddress')}}" name="provincialAddress" type="text" class="form-control" placeholder="Provincial Address" val-address  required></td>
                  </tr>
                  <tr>
                    <th>Gender <span class="text-red">*</span></th>
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
                      <input value="{{old('sss')}}" name="sss" type="text" class="form-control" placeholder="SSS No." val-sss >
                    </td>
                  </tr>
                  <tr>
                    <th>License No <span class="text-red">*</span></th>
                    <td>
                      <input value="{{old('licenseNo')}}" name="licenseNo" type="text" class="form-control" placeholder="License No." val-license required>
                    </td>
                  </tr>
                  <tr>
                    <th>License Expiry Date <span class="text-red">*</span></th>
                    <td>
                        <input value="{{old('licenseExpiryDate')}}" name="licenseExpiryDate" type="text" class="form-control date-mask" placeholder="mm/dd/yyyy" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask data-parsley-errors-container="#errExpireDate" val-license-exp data-parsley-expire-date required>
                    </td>
                  </tr>
                  <tr>
                    <th>Profile Picture</th>
                    <td><input type="file" name="profilePicture" accept="image/*"></td>
                  </tr>
                </tbody>
          </table>
          <h4 class="form-heading-blue">Contact Person</h4>
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