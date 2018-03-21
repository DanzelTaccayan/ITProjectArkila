@extends('layouts.form_lg') 
@section('links')
@parent
<style>
        /* Mark input boxes that gets an error on validation: */

        /* Hide all steps by default: */

        .tab {
            display: none;
        }



        /* Make circles that indicate the steps of the form: */

        .step {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbbbbb;
            border: none;
            border-radius: 50%;
            display: inline-block;
            opacity: 0.5;
        }

        .step.active {
            opacity: 1;
        }

        /* Mark the steps that are finished and valid: */

        .step.finish {
            background-color: #4CAF50;
        }
    </style>
@endsection
@section('title', 'Operator Registration')
@section('form-id','regForm')
@section('form-action',route('operators.store'))
@section('form-body')
<div class="box box-primary" style="box-shadow: 0px 5px 10px gray;">
        <div class="box-header with-border text-center">
            <h4>
            <a href="{{route('operators.index')}}" class="pull-left"><i class="fa  fa-chevron-left"></i></a>    
            </h4>
            <h4 class="box-title">
                Operator Registration
            </h4>
        </div>

        <div class="box-body">

                <!-- One "tab" for each step in the form: -->
                <div class="tab">
                    <h4>Personal Information</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Last Name: <span class="text-red">*</span></label>
                                <input value="{{old('lastName')}}" name="lastName" type="text" class="form-control" placeholder="Last Name" maxlength="25">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>First Name: <span class="text-red">*</span></label>
                                <input value="{{old('firstName')}}" name="firstName" type="text" class="form-control" placeholder="First Name" maxlength="25">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Middle Name: <span class="text-red">*</span></label>
                                <input value="{{old('middleName')}}" name="middleName" type="text" class="form-control" placeholder="Middle Name" maxlength="25">
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
                                  <input type="text" name="contactNumber"  class="form-control" value="{{old('contactNumber')}}" placeholder="Contact Number" data-inputmask='"mask": "999-999-9999"' data-mask>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                             <div class="form-group">
                                <label>Address: <span class="text-red">*</span></label>
                                <input value="{{old('address')}}" name="address" type="text" class="form-control" placeholder="Address" maxlength="100">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Provincial Address: <span class="text-red">*</span></label>
                                <input value="{{old('provincialAddress')}}" name="provincialAddress" type="text" class="form-control" placeholder="Provincial Address" maxlength="100">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Birthdate: <span class="text-red">*</span></label>
                               <div class="input-group">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input type="text" name="birthDate" class="form-control date-mask" placeholder="mm/dd/yyyy" value="{{old('birthDate')}}" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Birthplace: <span class="text-red">*</span></label>
                                <input value="{{old('birthPlace')}}" name="birthPlace" type="text" class="form-control" placeholder="Birthplace" maxlength="30">
                            </div>
                        </div>
                    
                    
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Gender: <span class="text-red">*</span></label>
                                <div class="radio">
                                    <label for=""> Male</label>
                                    <label class="radio-inline">
                                        <input @if(old('gender') == 'Male') {{'checked'}} @endif type="radio" name="gender"  value="Male" class="flat-blue">
                                    </label>
                                    <label for="">Female</label>
                                    <label class="radio-inline">
                                        <input @if(old('gender') == 'Female') {{'checked'}} @endif type="radio" name="gender" value="Female" class="flat-blue">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Citizenship:</label>
                                <input value="{{old('citizenship')}}" name="citizenship" type="text" class="form-control" placeholder="Citizenship" maxlength="25">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Civil Status:</label>
                                <select name="civilStatus" class="form-control">
                                   <option @if(old('civilStatus') == 'Single') {{'selected'}} @endif>Single</option>
                                   <option @if(old('civilStatus') == 'Married') {{'selected'}} @endif>Married</option>
                                   <option @if(old('civilStatus') == 'Divorced') {{'selected'}} @endif>Divorced</option>
                                   <option @if(old('civilStatus') == 'Widowed') {{'selected'}} @endif>Widowed</option>
                               </select>
                            </div>
                        </div>
                    
                    
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>SSS No: <span class="text-red">*</span></label>
                                <input value="{{old('sss')}}" name="sss" type="text" class="form-control" placeholder="SSS No." maxlength="10">
                            </div>
                        </div>
                    </div> 
                    <div class="row">   
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>License No: <span class="text-red">*</span></label>
                                <input value="{{old('licenseNo')}}" name="licenseNo" type="text" class="form-control" placeholder="License No." maxlength="20">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>License Expiry Date: <span class="text-red">*</span></label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input value="{{old('licenseExpiryDate')}}" name="licenseExpiryDate" type="text" class="form-control date-mask" placeholder="mm/dd/yyyy" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab">
                    <h4>Family Information</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name of Spouse:</label>
                                <input value="{{old('nameOfSpouse')}}" name="nameOfSpouse" type="text" class="form-control" placeholder="Name of Spouse" maxlength="40">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Birthdate of Spouse:</label>
                                <div class="input-group">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input type="text" name="spouseBirthDate" class="form-control date-mask" placeholder="mm/dd/yyyy" value="{{old('spouseBirthDate')}}" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fathers Name:</label>
                                <input value="{{old('fathersName')}}" name="fathersName" type="text" class="form-control" placeholder="Fathers Name" maxlength="40">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Occupation:</label>
                                <input value="{{old('fatherOccupation')}}" name="fatherOccupation" type="text" class="form-control" placeholder="Occupation" maxlength="25">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                             <div class="form-group">
                                <label>Mothers Maiden Name:</label>
                                <input value="{{old('mothersName')}}" name="mothersName" type="text" class="form-control" placeholder="Mothers Name" maxlength="40">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Occupation:</label>
                                <input value="{{old('motherOccupation')}}" name="motherOccupation" type="text" class="form-control" placeholder="Occupation" maxlength="25">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Contact Person: <span class="text-red">*</span></label>
                                <input value="{{old('contactPerson')}}" name="contactPerson" type="text" class="form-control" placeholder="Contact Person In Case of Emergency" maxlength="40">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Address: <span class="text-red">*</span></label>
                                <input value="{{old('contactPersonAddress')}}" name="contactPersonAddress" type="text" class="form-control" placeholder="Address" maxlength="100">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Contact Number: <span class="text-red">*</span></label>
                                <div class="input-group">
                                  <div class="input-group-addon">
                                    <span>+63</span>
                                  </div>
                                  <input type="text" name="contactPersonContactNumber"  class="form-control" value="{{old('contactPersonContactNumber')}}" placeholder="Contact Number" data-inputmask='"mask": "999-999-9999"' data-mask>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <Label>Dependents:</Label>
                            <table class="table table-hover custab">
                                <thead>
                                    <th>Name</th>
                                    <th>Birthdate</th>
                                    <th>
                                        <div class="pull-right">
                                            <button type="button" class="btn btn-primary" onclick="addItem()"><i class="fa fa-plus-circle"></i> Add Children</button>
                                        </div>
                                    </th>
                                </thead>
                                <tbody id="childrens">

                                @if(old('children'))

                                    @for($i = 0; $i < count(old('children')); $i++)
                                        <tr>
                                            <td>
                                                <input value="{{old('children.'.$i)}}" name="children[]" type="text" placeholder="Name of Child" class="form-control">
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                  <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                  </div>
                                                  <input type="text" name="childrenBDay[]" class="form-control date-mask" placeholder="mm/dd/yyyy" value="{{old('childrenBDay.'.$i)}}" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="pull-right">
                                                    <button style="display: none;" type="button" onclick="event.srcElement.parentElement.parentElement.parentElement.remove();rmv()" class='btn btn-danger'>Delete</button>
                                                </div>
                                            </td>

                                        </tr>
                                    @endfor
                                @else
                                    <tr>
                                        <td>
                                            <input name="children[]" type="text" placeholder="Name of Child" class="form-control" maxlength="40">
                                        </td>
                                        <td>
                                            <div class="input-group">
                                              <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                              </div>
                                              <input type="text" name="childrenBDay[]" class="form-control date-mask" placeholder="mm/dd/yyyy" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask>
                                            </div>
                                        </td>
                                        <td>
                                        <div class="pull-right">
                                        <button style="display: none;" type="button" onclick="event.srcElement.parentElement.parentElement.parentElement.remove();rmv()" class='btn btn-danger'>Delete</button>
                                    </div>
                                        </td>

                                    </tr>
                                @endif
                        
                                </tbody>
                            </table>
                    
                        </div>
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
                    <div style="float:right;">
                        <button type="button" id="prevBtn" onclick="nextPrev(-1)" class = "btn btn-default">Previous</button>
                        <button type="button" id="nextBtn" onclick="nextPrev(1)" class = "btn btn-primary">Next</button>
                    </div>
                </div>
        </div>
    </div>
@endsection
@section('scripts')
@parent
 <script>

     $(document).ready(function(){
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




        function addItem() {
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
     var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the crurrent tab

        function showTab(n) {
            // This function will display the specified tab of the form...
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            //... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "Submit";
            } else {
                document.getElementById("nextBtn").innerHTML = "Next";
            }
            //... and run a function that will display the correct step indicator:
            fixStepIndicator(n)
        }

        function nextPrev(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab");
            // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateForm()) return false;
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form...
            if (currentTab >= x.length) {
                // ... the form gets submitted:
                document.getElementById("regForm").submit();
                return false;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        function validateForm() {
            // This function deals with validation of the form fields


            return true; // return the valid status
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace("active", "");
            }
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }
    </script>
    <script>
    $(function () {

        $('.select2').select2()

        $('#datepicker').datepicker({
          autoclose: true
        })

        $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
          checkboxClass: 'icheckbox_flat-blue',
          radioClass   : 'iradio_flat-blue'
        })
    })
     $('[data-mask]').inputmask()
     $('.date-mask').inputmask('mm/dd/yyyy',{removeMaskOnSubmit: true})
    </script>

    
@endsection