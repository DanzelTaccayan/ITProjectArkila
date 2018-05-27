@extends('layouts.form_lg')
@section('title', 'Edit Operator Information')
@section('form-id','regForm')
@section('form-action', route('operators.update',[$operator->member_id]))
@section('form-body')
<div class="margin-side-10">  
    <div class="box box-primary with-shadow">
        <div class="box-header with-border text-center">
            <h4>
            <a href="{{route('operators.show',[$operator->member_id])}}" class="pull-left"><i class="fa fa-chevron-left"></i></a>
            </h4>
            <h3 class="box-title">
                EDIT OPERATOR INFORMATION
            </h3>
        </div>
            {{csrf_field()}}
            {{method_field("PATCH")}}
        <div class="box-body">
            <div class="padding-side-15">
                <img class="profile-user-img img-responsive img-circle" src="{{ URL::asset('uploads/profilePictures/'.$operator->profile_picture) }}" alt="Operator profile picture">
                <h4 class="name-heading">{{trim(strtoupper($operator->full_name))}}</h4>
                <h4 class="form-heading-blue">Personal Information</h4>
                <table class="table table-bordered table-striped form-table">
                    <tbody>
                        <tr>
                            <th>Contact Number <span class="text-red">*</span></th>
                            <td>
                                <input  value="{{old('contactNumber') ?? $operator->contact_number }}" id="contactNumberO" name="contactNumber" type="text" class="form-control" placeholder="Contact Number" val-phone required>
                            </td>
                        </tr>
                        <tr>
                            <th>Address <span class="text-red">*</span></th>
                            <td>
                                <input id="addressO" value="{{old('address') ?? $operator->address }}" name="address" type="text" class="form-control" placeholder="Address" val-address required>
                            </td>
                        </tr>
                        <tr>
                            <th>Provincial Address <span class="text-red">*</span></th>
                            <td>
                                <input value="{{old('provincialAddress') ?? $operator->provincial_address }}"  id="provincialAddress" name="provincialAddress" type="text" class="form-control" placeholder="Provincial Address" val-address required>
                            </td>
                        </tr>
                        <tr>
                            <th>SSS No</th>
                            <td>
                                <input id="sssO" name="sss" value="{{  old('sss') ?? $operator->SSS }}" type="text" class="form-control" placeholder="SSS No." val-sss>
                            </td>
                        </tr>
                        <tr>
                            <th>License No</th>
                            <td>
                                <input id="licenseNoO" value="{{  old('licenseNo') ?? $operator->license_number }}"  name="licenseNo" type="text" class="form-control" placeholder="License No." val-license>
                            </td>
                        </tr>
                        <tr>
                            <th>License Expiry Date</th>
                            <td>
                                <input value="{{old('licenseExpiryDate') ?? $operator->expiry_date }}" name="licenseExpiryDate" type="text" class="form-control date-mask" placeholder="mm/dd/yyyy" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask data-parsley-errors-container="#errExpireDate" val-license-exp data-parsley-expire-date>
                          </td>
                        </tr>
                        <tr>
                            <th>Profile Picture</th>
                            <td>
                                <input type="file" name="profilePicture" accept="image/*">
                            </td>
                        </tr>

                    </tbody>
                </table>

                <h4 class="form-heading-blue">Contact Person</h4>
                <table class="table table-bordered table-striped form-table">
                    <tbody>
                        <tr>
                            <th>Contact Person <span class="text-red">*</span></th>
                            <td>
                                <input value="{{ old('contactPerson') ?? $operator->person_in_case_of_emergency }}" id="contactPersonO" name="contactPerson" type="text" class="form-control" placeholder="Contact Person In Case of Emergency" val-fullname required>
                            </td>
                        </tr>
                        <tr>
                            <th>Address <span class="text-red">*</span></th>
                            <td>
                                <input  value="{{ old('contactPersonAddress') ?? $operator->emergency_address }}" id="addressO" name="contactPersonAddress" type="text" class="form-control" placeholder="Address" val-address required>
                            </td>
                        </tr>
                        <tr>
                            <th>Contact Number <span class="text-red">*</span></th>
                            <td>
                                <input value="{{ old('contactPersonContactNumber') ?? $operator->emergency_contactno }}" id="contactNumberO" name="contactPersonContactNumber" type="text" class="form-control" placeholder="Contact Number" val-phone required>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-footer">
            <div class="pull-right">
                <a href="{{route('operators.show',[$operator->member_id])}}" class="btn btn-default">Cancel</a>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Changes</button>
            </div>
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