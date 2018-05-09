<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Drivers</title>
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
            <td width="50%" align="right">Operator:</td>
        <td>{{$driver->operator->full_name ?? 'None'}}</td>
        </tr>

        <tr>
            <td width="50%" align="right">Full Name:</td>
        <td>{{$driver->full_name}}</td>
        </tr>
        <tr>
            <td align="right">Contact Number:</td>
            <td>{{$driver->contact_number}}</td>
        </tr>
        <tr>
            <td align="right">Address:</td>
            <td>{{$driver->address}}</td>
        </tr>
        <tr>
            <td align="right">Provincial Address:</td>
            <td>{{$driver->provincial_address}}</td>
        </tr>
        <tr>
            <td align="right">Gender:</td>
            <td>{{$driver->gender}}</td>
        </tr>
        <tr>
            <td align="right">SSS Number:</td>
            <td>{{$driver->SSS}}</td>
        </tr>
        <tr>
            <td align="right">License Number:</td>
            <td>{{$driver->license_number}}</td>
        </tr>
        <tr>
            <td align="right">License Expiry Date:</td>
            <td>{{$driver->expiry_date}}</td>
        </tr>
        <tr>
            <td align="right">Contact Person:</td>
            <td>{{$driver->person_in_case_of_emergency}}</td>
        </tr>
        <tr>
            <td align="right">Address:</td>
            <td>{{$driver->emergency_address}}</td>
        </tr>
        <tr>
            <td align="right">Contact Number:</td>
            <td>{{$driver->emergency_contactno}}</td>
        </tr>
    </table>

</body>
</html>
