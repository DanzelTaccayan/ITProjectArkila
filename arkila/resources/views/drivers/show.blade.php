@extends('layouts.master') 
@section('title', 'View Driver')
@section('content')

<div class="box box-default with-shadow">
    <div class="box-header with-border text-center">
        <h4>
            <a href="@if(session()->get('opLink') && session()->get('opLink') == URL::previous())
            {{session()->get('opLink')}}
            @else
                @if($driver->status === 'Active')
                    {{route('drivers.index') }}
                @else
                    {{route(URL::previous())}}
                @endif
            @endif" class="pull-left"><i class="fa fa-chevron-left"></i></a>
        </h4>
        <h3 class="box-title">
            View Driver Information
        </h3>
    </div>
    <div class="box-body">
        <button onclick="window.open('{{route('pdf.perDriver', [$driver->member_id])}}')" class="btn btn-default btn-sm btn-fla"> <i class="fa fa-print"></i> PRINT</button>

        <h4>Personal Information</h4>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="driverLastName">Last Name:</label>
                    <p id="driverLastName" name="driverLastName" type="text" class="info-container">{{$driver->last_name}}</p>
                </div>
                <div class="form-group">
                    <label for="contactNumberD">Contact Number:</label>
                    <p id="contactNumberD" name="contactNumberD" type="text" class="info-container">{{$driver->contact_number}}</p>
                </div>
                <div class="form-group">
                    <label for="ageD">Age:</label>
                    <p id="ageD" name="ageD" type="number" class="info-container">{{$driver->age}}</p>
                </div>
                <div class="form-group">
                    <label for="genderD">Gender:</label>
                    <p id="genderD" name="genderD" type="text" class="info-container">{{$driver->gender}}</p>
                </div>
                <div class="form-group">
                    <label for="sssD">SSS No:</label>
                    <p id="sssD" name="sssD" type="text" class="info-container">{{$driver->SSS}}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="driverFirstName">First Name:</label>
                    <p id="driverFirstName" name="driverFirstName" type="text" class="info-container">{{$driver->first_name}}</p>
                </div>
                <div class="form-group">
                    <label for="addressD">Address:</label>
                    <p id="addressD" name="addressD" type="text" class="info-container">{{$driver->address}}</p>
                </div>
                <div class="form-group">
                    <label for="birthdateD">Birthdate:</label>
                    <p id="birthdateD" name="birthdateD" type="text" class="info-container">{{$driver->birth_date}}</p>
                </div>
                <div class="form-group">
                    <label for="citizenshipD">Citizenship:</label>
                    <p id="citizenshipD" name="citizenshipD" type="text" class="info-container">{{$driver->citizenship}}</p>
                </div>
                <div class="form-group">
                    <label for="licenseNoD">License No:</label>
                    <p id="licenseNoD" name="licenseNoD" type="text" class="info-container" >{{$driver->license_number}}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="driverMiddleName">Middle Name:</label>
                    <p id="driverMiddleName" name="driverMiddleName" type="text" class="info-container">{{$driver->middle_name}}</p>
                </div>
                <div class="form-group">
                    <label for="provincialAddressD">Provincial Address:</label>
                    <p id="provincialAddressD" name="provincialAddressD" type="text" class="info-container">{{$driver->provincial_address}}</p>
                </div>
                <div class="form-group">
                    <label for="birthplaceD">Birthplace:</label>
                    <p id="birthplaceD" name="birthplaceD" type="text" class="info-container">{{$driver->birth_place}}</p>
                </div>
                <div class="form-group">
                    <label for="civilStatusD">Civil Status:</label>
                    <p id="civilStatusD" name="civilStatusD" type="text" class="info-container">{{$driver->civil_status}}</p>
                </div>
                <div class="form-group">
                    <label for="licenseExpiryDateD">License Expiry Date:</label>
                    <p id="licenseExpiryDateD" name="licenseExpiryDateD" type="text" class="info-container">{{$driver->expiry_date}}</p>
                </div>
            </div>
        </div>
 

        <h4>Family Information</h4>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="spouseNameD">Name of Spouse:</label>
                    <p id="spouseNameD" name="spouseNameD" type="text" class="info-container">{{$driver->spouse}}</p>
                </div>
                <div class="form-group">
                    <label for="fathersNameD">Fathers Name:</label>
                    <p id="fathersNameD" name="fathersNameD" type="text" class="info-container">{{$driver->father_name}}</p>
                </div>
                <div class="form-group">
                    <label for="mothersNameD">Mothers Name:</label>
                    <p id="mothersNameD" name="mothersNameD" type="number" class="info-container">{{$driver->mother_name}}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="spouseBirthDateD">Birthdate of Spouse:</label>
                        <p id="spouseBirthDateD" name="spouseBirthDateD" type="text" class="info-container">{{$driver->spouse_birthdate}}</p>
                </div>
                <div class="form-group">
                    <label for="occupationFatherD">Occupation:</label>
                    <p id="occupationFatherD" name="occupationFatherD" type="text" class="info-container">{{$driver->father_occupation}}</p>
                </div>
                <div class="form-group">
                    <label for="occupationMotherD">Occupation:</label>
                    <p id="occupationMotherD" name="occupationMotherD" type="text" class="info-container">{{$driver->mother_occupation}}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="contactPersonD">Contact Person</label>
                    <p id="contactPersonD" name="contactPersonD" type="text" class="info-container">{{$driver->person_in_case_of_emergency}}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="addressD">Address</label>
                    <p id="addressD" name="addressD" type="text" class="info-container">{{$driver->emergency_address}}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="contactNumberD">Contact Number</label>
                    <p id="contactNumberD" name="contactNumberD" type="text" class="info-container">{{$driver->emergency_contactno}}</p>
                </div>
            </div>
        </div>
        <div class="row">
            @if($driver->children->first())
            <div class="col-md-12">
                <Label for="dependentsO">Dependents:</Label>
                <table class="table table-hover custab">
                    <thead>
                        <th>Name</th>
                        <th>Birthdate</th>
                    </thead>
                    <tbody id="childrens">
                         @foreach($driver->children as $child)
                        <tr>
                            <td>
                                <p type="text" class="info-container">{{$child->children_name}}</p>
                            </td>
                            <td>
                                <p type="text" class="info-container">{{$child->birthdate}}</p>
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
@endsection