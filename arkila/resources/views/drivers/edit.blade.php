@extends('layouts.form_lg') 
@section('title', 'Edit Driver Information') 
@section('form-id','regForm')
@section('form-action',route('drivers.update',[$driver->member_id]))
@section('form-body')
<div class="margin-side-10">
    <div class="box box-warning" style="box-shadow: 0px 5px 10px gray;">
        <div class="box-header with-border text-center">
            <h4>
                <a href="@if(session()->get('opLink') && session()->get('opLink') == URL::previous()) {{ session()->get('opLink') }} @else {{ route('drivers.index')}} @endif" class="pull-left"><i class="fa fa-chevron-left"></i></a>
            </h4>
            <h3 class="box-title">
                EDIT DRIVER INFORMATION
            </h3>
        </div>
        {{csrf_field()}} 
        {{method_field("PATCH")}}
        <div class="box-body">
            <div class="padding-side-15">
                <img class="profile-user-img img-responsive img-circle" src="{{ URL::asset('uploads/profilePictures/'.$driver->profile_picture) }}" alt="Operator profile picture">
                <h4 class="name-heading">{{trim(strtoupper($driver->full_name))}}</h4>
                <h4 class="form-heading-orange">Personal Information</h4>
                <table class="table table-bordered table-striped form-table">
                    <tbody>
                        <tr>
                            <th>Operator</th>
                            <td>
                                <select name="operator" id="" class="form-control select2">
                                    <option value=''>No Operator</option>
                                    @foreach($operators as $operator)
                                        <option value="{{$operator->member_id}}"
                                        @if(old('operator') == $operator->member_id)
                                            {{'selected'}}
                                                @elseif($driver->operator != null)
                                                @if($driver->operator->member_id == $operator->member_id)
                                                    {{'selected'}}
                                                @endif
                                                @endif
                                        >{{$operator->full_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Last Name: <span class="text-red">*</span></th>
                            <td><input value="{{ old('lastName') ?? $driver->last_name}}" type="text" id="lastNAmeO" name="lastName" class="form-control" placeholder="Last Name" val-name required></td>
                        </tr>0
                        <tr>
                            <th>First Name: <span class="text-red">*</span></th>
                            <td><input value="{{ old('firstName') ?? $driver->first_name}}" type="text" id="firstNameO" name="firstName" class="form-control" placeholder="First Name" val-name required></td>
                        </tr>
                        <tr>
                            <th>Middle Name:</th>
                            <td><input value="{{ old('middleName') ?? $driver->middle_name}}" type="text" id="middleNameO" name="middleName" class="form-control" placeholder="Middle Name" val-name></td>
                        </tr>
                        <tr>
                            <th>Contact Number <span class="text-red">*</span></th>
                            <td>
                                <input value="{{old('contactNumber') ?? $driver->contact_number }}" id="contactNumberO" name="contactNumber" type="text" class="form-control" placeholder="Contact Number" val-contact required>
                            </td>
                        </tr>
                        <tr>
                            <th>Address <span class="text-red">*</span></th>
                            <td>
                                <input id="addressO" value="{{old('address') ?? $driver->address }}" name="address" type="text" class="form-control" placeholder="Address" val-address required>
                            </td>
                        </tr>
                        <tr>
                            <th>Provincial Address <span class="text-red">*</span></th>
                            <td>
                                <input value="{{old('provincialAddress') ?? $driver->provincial_address }}" id="provincialAddress" name="provincialAddress" type="text" class="form-control" placeholder="Provincial Address" val-address required>
                            </td>
                        </tr>
                        <tr>
                            <th>SSS No.</th>
                            <td>
                                <input id="sssO" name="sss" value="{{  old('sss') ?? $driver->SSS }}" type="text" class="form-control" placeholder="SSS No."  val-sss>
                            </td>
                        </tr>
                        <tr>
                            <th>License No. <span class="text-red">*</span></th>
                            <td>
                                <input id="licenseNoO" value="{{  old('licenseNo') ?? $driver->license_number }}" name="licenseNo" type="text" class="form-control" placeholder="License No." val-license required>
                            </td>
                        </tr>
                        <tr>
                            <th>License Expiry Date <span class="text-red">*</span></th>
                            <td>
                                <input value="{{  old('licenseExpiryDate')  ?? $driver->expiry_date }}" id="licenseExpiryDateO" name="licenseExpiryDate" type="text" class="form-control date-mask" placeholder="mm/dd/yyyy" data-inputmask="'alias': 'mm/dd/yyyy'" val-license-exp required>
                            </td>
                        </tr>
                        <tr>
                            <th>Profile Picture<span class="text-red">*</span></th>
                            <td>
                                <input type="file" name="profilePicture" accept="image/*">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <h4 class="form-heading-orange">Contact Information</h4>
                <table class="table table-bordered table-striped form-table">
                    <tbody>
                        <tr>
                            <th>Name <span class="text-red">*</span></th>
                            <td>
                                <input value="{{ old('contactPerson') ?? $driver->person_in_case_of_emergency }}" id="contactPersonO" name="contactPerson" type="text" class="form-control" placeholder="Contact Person In Case of Emergency" val-cname required >
                            </td>
                        </tr>
                        <tr>
                            <th>Address <span class="text-red">*</span></th>
                            <td>
                                <input value="{{ old('contactPersonAddress') ?? $driver->emergency_address }}" id="addressO" name="contactPersonAddress" type="text" class="form-control" val-address required >
                            </td>
                        </tr>
                        <tr>
                            <th>Contact Number <span class="text-red">*</span></th>
                            <td>
                                <input value="{{ old('contactPersonContactNumber') ?? $driver->emergency_contactno }}" id="contactNumberO" name="contactPersonContactNumber" type="text" class="form-control" placeholder="Contact Number" val-contact required >
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-footer">
            <div class="pull-right">
                <a href="{{route('drivers.show',[$driver->member_id])}}" class="btn btn-default">Cancel</a>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Changes</button>
            </div>
        </div>
    </div>
</div>

@stop @section('scripts') @parent

<script>
    $(document).ready(function() {
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

        $(document).ready(function() {
            cloneDateMask();
            switch ($('select[name="civilStatus"]').val()) {
                case "Single":
                    $('input[name="nameOfSpouse"]').prop('disabled', true);
                    $('input[name="spouseBirthDate"]').prop('disabled', true);
                    break;
                case "Divorced":
                    $('input[name="nameOfSpouse"]').prop('disabled', true);
                    $('input[name="spouseBirthDate"]').prop('disabled', true);
                    break;
                default:
                    $('input[name="nameOfSpouse"]').prop('disabled', false);
                    $('input[name="spouseBirthDate"]').prop('disabled', false);
                    break;
            }


            $('select[name="civilStatus"]').change(function() {
                switch ($('select[name="civilStatus"]').val()) {
                    case "Single":
                        $('input[name="nameOfSpouse"]').prop('disabled', true);
                        $('input[name="spouseBirthDate"]').prop('disabled', true);
                        break;
                    case "Divorced":
                        $('input[name="nameOfSpouse"]').prop('disabled', true);
                        $('input[name="spouseBirthDate"]').prop('disabled', true);
                        break;
                    default:
                        $('input[name="nameOfSpouse"]').prop('disabled', false);
                        $('input[name="spouseBirthDate"]').prop('disabled', false);
                        break;
                }
            });
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