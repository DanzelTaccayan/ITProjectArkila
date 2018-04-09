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
            <h4>Personal Information</h4>
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
                        <label for="birthdateO">Birthdate: <span class="text-red">*</span></label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input value="{{ old('birthDate') ?? $operator->birth_date }}" id="birthdateO" name="birthDate" type="text" class="form-control date-mask" placeholder="mm/dd/yyyy" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask data-parsley-errors-container="#errLegal" data-parsley-legal-age val-birthdate required  data-parsley-trigger="keyup">
                        </div>
                        <p id="errLegal"></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="birthplaceO">Birthplace: <span class="text-red">*</span></label>
                        <input value="{{old('birthPlace') ?? $operator->birth_place }}" id="birthplaceO" name="birthPlace" type="text" class="form-control" placeholder="Birthplace" val-birthplace required data-parsley-trigger="keyup">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="genderO">Gender: <span class="text-red">*</span></label>
                        <div class="radio">
                            <label for="genderMaleO"> Male</label>
                            <label class="radio-inline">
                                <input type="radio" name="gender" id="genderMaleO" value="Male" class="flat-blue" @if(old('gender') || $operator->gender == 'Male') {{ 'checked' }} @endif>
                            </label>
                            <label for="genderFemaleO">Female</label>
                            <label class="radio-inline">
                                    <input type="radio" name="gender" id="genderFemaleO" value="Female" class="flat-blue" @if(old('gender') || $operator->gender == 'Female') {{ 'checked' }} @endif>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="citizenshipO">Citizenship: <span class="text-red">*</span></label>
                        <input value="{{ old('citizenship') ?? $operator->citizenship }}" id="citizenshipO" name="citizenship" type="text" class="form-control" placeholder="Citizenship" val-citizenship required data-parsley-trigger="keyup">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="civilStatusO">Civil Status:</label>
                        <select id="civilStatusO" name="civilStatus" class="form-control">
                                <option @if(old('civilStatus') || $operator->civil_status == 'Single') {{ 'selected' }}  @endif >Single</option>
                                <option @if(old('civilStatus') || $operator->civil_status == 'Married') {{ 'selected' }}  @endif>Married</option>
                                <option @if(old('civilStatus') || $operator->civil_status == 'Divorced') {{ 'selected' }}  @endif>Divorced</option>
                                <option @if(old('civilStatus') || $operator->civil_status == 'Widowed') {{ 'selected' }} @endif>Widowed</option>
                            </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="sssO">SSS No:</label>
                        <input id="sssO" name="sss" value="{{  old('sss') ?? $operator->SSS }}" type="text" class="form-control" placeholder="SSS No." val-sss data-inputmask='"mask": "99-9999999-9"' data-mask data-parsley-trigger="keyup">
                    </div>
                </div>
            </div>
            <div class="row">
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
            <h4>Family Information</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="spouseNameO">Name of Spouse:</label>
                        <input value="{{ old('nameOfSpouse') ?? $operator->spouse }}"  id="spouseNameO" name="nameOfSpouse" type="text" class="form-control" placeholder="Name of Spouse" val-fullname data-parsley-trigger="keyup">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="spouseBirthDateO">Birthdate of Spouse:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input value="{{  old('spouseBirthDate') ?? $operator->spouse_birthdate }}" id="spouseBirthDateO" name="spouseBirthDate" type="text" class="form-control date-mask" placeholder="mm/dd/yyyy" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask data-parsley-errors-container="#errSpouseBirthdate" data-parsley-legal-age val-spouse-bdate data-parsley-trigger="keyup">
                        </div>
                        <p id="errSpouseBirthdate"></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fathersNameO">Father's Name:</label>
                        <input value="{{ old('fathersName') ?? $operator->father_name }}"  id="fathersNameO" name="fathersName" type="text" class="form-control" placeholder="Father's Name" val-fullname data-parsley-trigger="keyup">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="occupationFatherO">Occupation:</label>
                        <input value="{{  old('fatherOccupation') ?? $operator->father_occupation }}" id="occupationFatherO" name="fatherOccupation" type="text" class="form-control" placeholder="Occupation" val-occupation data-parsley-trigger="keyup">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mothersNameO">Mother's Maiden Name:</label>
                        <input value="{{ old('mothersName') ?? $operator->mother_name }}" id="mothersNameO" name="mothersName" type="text" class="form-control" placeholder="Mother's Maiden Name" val-fullname data-parsley-trigger="keyup">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="occupationMotherO">Occupation:</label>
                        <input value="{{ old('motherOccupation') ?? $operator->mother_occupation }}" id="occupationMotherO" name="motherOccupation" type="text" class="form-control" placeholder="Occupation" val-occupation data-parsley-trigger="keyup">
                    </div>
                </div>
            </div>
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
            <div class="row">
                <div class="col-md-12">
                    <Label for="dependentsO">Dependents:</Label>
                    <table class="table table-hover custab">
                        <thead>
                            <th>Name</th>
                            <th>Birthdate</th>
                            <th>
                                <div class="pull-right">
                                    <button type="button" class="btn btn-primary btn-sm btn-flat" onclick="addDependent()"><i class="fa fa-plus"></i> ADD DEPENDENT</button>
                                </div>
                            </th>
                        </thead>
                        <tbody id="childrens">
                        @if(old('children'))

                            @for($i = 0; $i < count(old('children')); $i++)
                                <tr>
                                    <td>
                                        <input value="{{old('children.'.$i)}}" name="children[]" type="text" placeholder="Name of Child" class="form-control" maxlength="120">
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input value="{{old('childrenBDay.'.$i)}}" name="childrenBDay[]" type="text" class="form-control date-mask" placeholder="mm/dd/yyyy" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="pull-right">
                                            @if(count(old('children')) > 1)
                                                <button type="button" onclick="event.srcElement.parentElement.parentElement.parentElement.remove();rmv()" class='btn btn-danger'>Delete</button>
                                            @else
                                                <button style="display: none;" type="button" onclick="event.srcElement.parentElement.parentElement.parentElement.remove();rmv()" class='btn btn-danger'>Delete</button>
                                            @endif
                                        </div>
                                    </td>

                                </tr>
                            @endfor
                        @elseif ($operator->children->first())
                            @foreach($operator->children as $child)
                                <tr>
                                    <td>
                                        <input value="{{$child->children_name}}" name="children[]" type="text" placeholder="Name of Child" class="form-control" maxlength="120">
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input value="{{$child->birthdate}}" name="childrenBDay[]" type="text" class="form-control date-mask" placeholder="mm/dd/yyyy" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="pull-right">
                                            <button style="display: none;" type="button" onclick="event.srcElement.parentElement.parentElement.parentElement.remove();rmv()" class='btn btn-danger'>Delete</button>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>
                                    <input name="children[]" type="text" placeholder="Name of Child" class="form-control" maxlength="120">
                                </td>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input name="childrenBDay[]" type="text" class="form-control date-mask" placeholder="mm/dd/yyyy" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask>
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