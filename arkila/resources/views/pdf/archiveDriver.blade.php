<<!DOCTYPE html>
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

    <h1>Ban Trans List of Drivers</h1>
    <h2>{{ $date->formatLocalized('%A %d %B %Y') }}</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Address</th>
                <th>Contact Number</th>
                <th>Date Archived</th>
            </tr>
        </thead>

        <tbody>
        @foreach ($archivedDrivers->sortBy('last_name') as $archivedDriver)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$archivedDriver->full_name}}</td>
                <td>{{$archivedDriver->address}}</td>
                <td>{{$archivedDriver->contact_number}}</td>
                <td>{{$archivedDriver->updated_at->format('h:i A')." of ".$archivedDriver->updated_at->format('M d, Y')}}</td>

            </tr>
        @endforeach
        </tbody>
    </table>

</body>
</html>
