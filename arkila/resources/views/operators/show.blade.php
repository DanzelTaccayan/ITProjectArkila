@extends('layouts.master') 
@section('title', 'View Operator')  
@section('content')

<div class="box box-default with-shadow">
    <div class="box-header with-border text-center">
        <h4>
            <a href="{{route('operators.showProfile',[$operator->member_id])}}" class="pull-left"><i class="fa  fa-chevron-left"></i></a>
        </h4>
        <h3 class="box-title">
            View Operator Information
        </h3>
    </div>
    <div class="box-body">
        <button onclick="window.open('{{route('pdf.perOperator', [$operator->member_id])}}')" class="btn btn-default btn-sm btn-fla"> <i class="fa fa-print"></i> PRINT</button>

            <h4>Personal Information</h4>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="operatorLastName">Last Name:</label>
                        <p id="driverLastName" name="driverLastName"  class="info-container">{{$operator->last_name}} </p>
                    </div>
                    <div class="form-group">
                        <label for="contactNumberO">Contact Number:</label>
                        <p id="contactNumberO" name="contactNumberO" class="info-container">{{$operator->edit_contact_number}}</p>
                    </div>
                    <div class="form-group">
                        <label for="ageO">Age:</label>
                        <p id="ageO" name="ageO" class="info-container">{{$operator->age}}</p>
                    </div>
                    <div class="form-group">
                        <label for="genderO">Gender:</label>
                        <p id="genderO" name="genderO" class="info-container">{{$operator->gender}}</p>
                    </div>
                    <div class="form-group">
                        <label for="sssO">SSS No:</label>
                        <p id="sssO" name="sssO" type="text" class="info-container">{{$operator->SSS}}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="operatorFirstName">First Name:</label>
                        <p id="operatorFirstName" name="operatorFirstName" class="info-container">{{$operator->first_name}}</p>
                    </div>
                    <div class="form-group">
                        <label for="addressO">Address:</label>
                        <p id="addressO" name="addressO" class="info-container">{{$operator->address}}</p>
                    </div>
                    <div class="form-group">
                        <label for="birthdateO">Birthdate:</label>
                        <p id="birthdateO" name="birthdateO" class="info-container">{{$operator->birth_date}}</p>
                    </div>
                    <div class="form-group">
                        <label for="citizenshipO">Citizenship:</label>
                        <p id="citizenshipO" name="citizenshipO" class="info-container">{{$operator->citizenship}}</p>
                    </div>
                    <div class="form-group">
                        <label for="licenseNoO">License No:</label>
                        <p id="licenseNoO" name="licenseNoO" class="info-container">{{$operator->license_number}}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="operatorMiddleName">Middle Name:</label>
                        <p id="operatorMiddleName" name="operatorMiddleName" class="info-container">{{$operator->middle_name}}</p>
                    </div>
                    <div class="form-group">
                        <label for="provincialAddressO">Provincial Address:</label>
                        <p id="provincialAddressO" name="provincialAddressO" class="info-container">{{$operator->provincial_address}}</p>
                    </div>
                    <div class="form-group">
                        <label for="birthplaceO">Birthplace:</label>
                        <p id="birthplaceO" name="birthplaceO" class="info-container">{{$operator->birth_place}}</p>
                    </div>
                    <div class="form-group">
                        <label for="civilStatusO">Civil Status:</label>
                        <p id="civilStatusO" name="civilStatusO" class="info-container">{{$operator->civil_status}}</p>
                    </div>
                    <div class="form-group">
                        <label for="licenseExpiryDateO">License Expiry Date:</label>
                        <p id="licenseExpiryDateO" name="licenseExpiryDateO" class="info-container">{{$operator->expiry_date}}</p>
                    </div>
                </div>
            </div>
            <h4>Family Information</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="spouseNameO">Name of Spouse:</label>
                        <p id="spouseNameO" name="spouseNameO" class="info-container" placeholder="Name of Spouse">{{$operator->spouse}}</p>
                    </div>
                    <div class="form-group">
                        <label for="fathersNameO">Fathers Name:</label>
                        <p id="fathersNameO" name="fathersNameO" class="info-container" placeholder="Fathers Name">{{$operator->father_name}}</p>
                    </div>
                    <div class="form-group">
                        <label for="mothersNameO">Mothers Name:</label>
                        <p id="mothersNameO" name="mothersNameO" class="info-container" placeholder="Mothers Name">{{$operator->mother_name}}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="spouseBirthDateO">Birthdate of Spouse:</label>
                        <p id="spouseBirthDateO" name="spouseBirthDateO" class="info-container" placeholder="Spouse Birthday">{{$operator->spouse_birthdate}}</p>
                    </div>
                    <div class="form-group">
                        <label for="occupationFatherO">Occupation:</label>
                        <p id="occupationFatherO" name="occupationFatherO" class="info-container" placeholder="Occupation Father">{{$operator->father_occupation}}</p>
                    </div>
                    <div class="form-group">
                        <label for="occupationMotherO">Occupation:</label>
                        <p id="occupationMotherO" name="occupationMotherO" class="info-container" placeholder="Occupation Mother">{{$operator->mother_occupation}}</p>
                    </div>
                </div>    
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="contactPersonO">Contact Person</label>
                            <p id="contactPersonO" name="contactPersonO" class="info-container" placeholder="Contact Person In Case of Emergency">{{$operator->person_in_case_of_emergency}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="addressO">Address</label>
                            <p id="addressO" name="addressO" class="info-container" placeholder="Address">{{$operator->emergency_address}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="contactNumberO">Contact Number</label>
                            <p id="contactNumberO" name="contactNumberO" class="info-container" placeholder="Contact Number">{{$operator->emergency_contactno}}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @if($operator->children->first())
                        @foreach($operator->children as $child)
                    <div class="col-md-12">

                        <Label for="dependentsO">Dependents:</Label>
                        <table class="table table-hover custab">
                            <thead>
                                <th>Name</th>
                                <th>
                                    <div class="col-md-7">Birthdate</div>
                                </th>

                            </thead>
                            <tbody id="childrens">

                                <tr>
                                    <td>
                                        <p placeholder="Name of Child" class="info-container">{{$child->children_name}}</p>
                                    </td>
                                    <td>
                                        <div class="col-md-7">
                                            <p id="childBirthDateO" name="childBirthDateO" class="info-container" placeholder="Operator Child Birthday">{{$child->birthdate}}</p>
                                        </div>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                            @endif
                </div>
            </div>
    </div>
</div>
@endsection