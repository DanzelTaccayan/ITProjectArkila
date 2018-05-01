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

    <h1>Ban Trans Drivers List</h1>
    <h2>{{ $date->formatLocalized('%A %d %B %Y') }}</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Contact Number</th>
                <th>Operator</th>
            </tr>
        </thead>

        <tbody>
        @foreach ($drivers->where('status', 'Active')->sortBy('last_name') as $driver)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $driver->last_name }}, {{ $driver->first_name }}</td>
                <td>{{ $driver->contact_number }}</td>
                <td>{{ $driver->operator->full_name ?? 'None' }}</td>

            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
