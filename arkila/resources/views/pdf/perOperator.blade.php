<<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Operator</title>
</head>
<body>

    <style>
        table
        {
            width: 100%;
        }
        th, td
        {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        h1, h2
        {
            text-align: center;
        }
    </style>

    <h1>Ban Trans Bio-Data</h1>
    <h2>{{ $date->formatLocalized('%A %d %B %Y') }}</h2>
    <table width="800" border="0" align="center" cellpadding="5">
        <tr>
            <td colspan="2">Personal Data<hr/></td>
        </tr>
        <tr>
            <td width="50%" align="right">Full Name:</td>
        <td>{{$operator->full_name}}</td>
        </tr>
        <tr>
            <td align="right">Contact Number:</td>
            <td>{{$operator->contact_number}}</td>
        </tr>
        <tr>
            <td align="right">Address:</td>
            <td>{{$operator->address}}</td>
        </tr>
        <tr>
            <td align="right">Provincial Address:</td>
            <td>{{$operator->provincial_address}}</td>
        </tr>
        <tr>
            <td align="right">Age:</td>
            <td>{{$operator->age}}</td>
        </tr>
        <tr>
            <td align="right">Birthdate:</td>
            <td>{{$operator->birth_date}}</td>
        </tr>
        <tr>
            <td align="right">Birthplace:</td>
            <td>{{$operator->birth_place}}</td>
        </tr>
        <tr>
            <td align="right">Gender:</td>
            <td>{{$operator->gender}}</td>
        </tr>
        <tr>
            <td align="right">Citizenship:</td>
            <td>{{$operator->citizenship}}</td>
        </tr>
        <tr>
            <td align="right">Civil Status:</td>
            <td>{{$operator->civil_status}}</td>
        </tr>
        <tr>
            <td align="right">SSS Number:</td>
            <td>{{$operator->SSS}}</td>
        </tr>
        <tr>
            <td align="right">License Number:</td>
            <td>{{$operator->license_number}}</td>
        </tr>
        <tr>
            <td align="right">License Expiry Date:</td>
            <td>{{$operator->expiry_date}}</td>
        </tr>
        <tr>
            <td colspan="2">Family Information<hr/></td>
        </tr>
        <tr>
            <td align="right" valign="top">Name of Spouse:</td>
            <td>{{$operator->spouse}}</td>
        </tr>
        <tr>
            <td align="right">Birthdate of Spouse:</td>
            <td>{{$operator->spouse_birthdate}}</td>
        </tr>
        <tr>
            <td align="right">Father's Name:</td>
            <td>{{$operator->father_name}}</td>
        </tr>
        <tr>
            <td align="right">Occupation:</td>
            <td>{{$operator->father_occupation}}</td>
        </tr>
        <tr>
            <td align="right">Mother's Name:</td>
            <td>{{$operator->mother_name}}</td>
        </tr>
        <tr>
            <td align="right">Occupation:</td>
            <td>{{$operator->mother_occupation}}</td>
        </tr>
        <tr>
            <td align="right">Contact Person:</td>
            <td>{{$operator->person_in_case_of_emergency}}</td>
        </tr>
        <tr>
            <td align="right">Address:</td>
            <td>{{$operator->emergency_address}}</td>
        </tr>
        <tr>
            <td align="right">Contact Number:</td>
            <td>{{$operator->emergency_contactno}}</td>
        </tr>
        @if($operator->children->first())
            <tr>
            <td colspan="2">Dependents<hr/></td>
            </tr>
                @foreach($operator->children as $child)
                    <tr>
                        <td align="right">Name:</td>
                        <td>{{$child->children_name}}</td>
                    </tr>
                    <tr>
                        <td align="right">Birthdate:</td>
                        <td>{{$child->birthdate}}</td>
                    </tr>
                @endforeach
        @endif

    </table>

</body>
</html>
