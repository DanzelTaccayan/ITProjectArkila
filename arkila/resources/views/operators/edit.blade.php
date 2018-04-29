@extends('layouts.form_lg')
@section('title', 'Edit Operator Information')
@section('form-id','regForm')
@section('form-action', route('operators.update',[$operator->member_id]))
@section('form-body')

<div class="box box-primary" style="box-shadow: 0px 5px 10px gray;">
    <div class="box-header with-border text-center">
        <h4>
        <a href="{{route('operators.showProfile',[$operator->member_id])}}" class="pull-left"><i class="fa  fa-chevron-left"></i></a>
        </h4>
        <h3 class="box-title">
            EDIT OPERATOR INFORMATION
        </h3>
    </div>
        {{csrf_field()}}
        {{method_field("PATCH")}}
        <div class="box-body">
            <h4>{{old('lastName') ?? $operator->last_name }}, {{old('firstName')  ?? $operator->first_name}} {{  old('middleName')  ?? $operator->middle_name }}</h4>
            <form action="">
                <div class="form-group">
                   <label>Edit profile image</label>
                   <input type="file" name="profilePicture" accept="image/*">
                </div>
            </form>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="operatorLastName">Last Name: <span class="text-red">*</span></label>
                        <input value= "{{old('lastName') ?? $operator->last_name }}" id="driverLastName" name="lastName" type="text" class="form-control" placeholder="Last Name" val-name required  data-parsley-trigger="keyup">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="operatorFirstName">First Name: <span class="text-red">*</span></label>
                        <input id="operatorFirstName" value="{{old('firstName')  ?? $operator->first_name}}" name="firstName" type="text" class="form-control" placeholder="First Name" val-name required  data-parsley-trigger="keyup">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="operatorMiddleName">Middle Name: </label>
                        <input id="operatorMiddleName" value="{{  old('middleName')  ?? $operator->middle_name }}"  name="middleName" type="text" class="form-control" placeholder="Middle Name" val-name data-parsley-trigger="keyup">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="contactNumberO">Contact Number: <span class="text-red">*</span></label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span>+63</span>
                            </div>
                            <input  value="{{old('contactNumber') ?? $operator->edit_contact_number }}" id="contactNumberO" name="contactNumber" type="text" class="form-control" placeholder="Contact Number" data-inputmask='"mask": "999-999-9999"' data-mask data-parsley-errors-container="#errContactNumber" val-phone required data-parsley-trigger="keyup">
                        </div>
                        <p id="errContactNumber"></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="addressO">Address: <span class="text-red">*</span></label>
                        <input id="addressO" value="{{old('address') ?? $operator->address }}" name="address" type="text" class="form-control" placeholder="Address" val-address required data-parsley-trigger="keyup">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="provincialAddressO">Provincial Address: <span class="text-red">*</span></label>
                        <input value="{{old('provincialAddress') ?? $operator->provincial_address }}"  id="provincialAddress" name="provincialAddress" type="text" class="form-control" placeholder="Provincial Address" val-address required data-parsley-trigger="keyup">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="sssO">SSS No:</label>
                        <input id="sssO" name="sss" value="{{  old('sss') ?? $operator->SSS }}" type="text" class="form-control" placeholder="SSS No." val-sss data-inputmask='"mask": "99-9999999-9"' data-mask data-parsley-trigger="keyup">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="licenseNoO">License No: <span class="text-red">*</span></label>
                        <input id="licenseNoO" value="{{  old('licenseNo') ?? $operator->license_number }}"  name="licenseNo" type="text" class="form-control" placeholder="License No." val-license data-inputmask='"mask": "A99-99-999999"' data-mask data-parsley-trigger="keyup">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="licenseExpiryDateO">License Expiry Date: <span class="text-red">*</span></label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input value="{{  old('licenseExpiryDate')  ?? $operator->expiry_date }}" id="licenseExpiryDateO" name="licenseExpiryDate" type="text" class="form-control date-mask" placeholder="mm/dd/yyyy" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask data-parsley-errors-container="#errExpireDate" val-license-exp data-parsley-expire-date data-parsley-trigger="keyup">
                        </div>
                        <p id= "errExpireDate"></p>
                    </div>
                </div>
            </div>
            <hr>    
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="contactPersonO">Contact Person: <span class="text-red">*</span></label>
                        <input value="{{ old('contactPerson') ?? $operator->person_in_case_of_emergency }}" id="contactPersonO" name="contactPerson" type="text" class="form-control" placeholder="Contact Person In Case of Emergency" val-fullname required data-parsley-trigger="keyup">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="addressO">Address: <span class="text-red">*</span></label>
                        <input  value="{{ old('contactPersonAddress') ?? $operator->emergency_address }}" id="addressO" name="contactPersonAddress" type="text" class="form-control" placeholder="Address" val-address required data-parsley-trigger="keyup">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="contactNumberO">Contact Number: <span class="text-red">*</span></label>
                        <div class = "input-group">
                            <div class = "input-group-addon">
                                <span>+63</span>
                            </div>
                        <input value="{{ old('contactPersonContactNumber') ?? $operator->edit_emergency_contactno }}" id="contactNumberO" name="contactPersonContactNumber" type="text" class="form-control" placeholder="Contact Number" data-inputmask='"mask": "999-999-9999"' data-mask data-parsley-errors-container="#errContactPersonPhone" val-phone required data-parsley-trigger="keyup">
                        </div>
                        <p id="errContactPersonPhone"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="pull-right">
                <a href="" class="btn btn-default">Cancel</a>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Changes</button>
            </div>
        </div>    
</div>


@stop @section('scripts') @parent

<script>
    $(document).ready(function(){
        $('button[type="submit"]').on('click',function(){
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
            iClone.cells[1].children[0].children[1].value = "";

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
@stop