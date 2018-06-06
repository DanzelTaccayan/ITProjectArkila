<<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Operators</title>
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

    <h1>Ban Trans List of Operators</h1>
    <h2>{{ $date->formatLocalized('%A %d %B %Y') }}</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Contact Number</th>
                <th>No. of Van</th>
                <th>No. of Driver</th>
                <th>Archived Date</th>
            </tr>
        </thead>

        <tbody>
        @foreach ($operators->sortBy('last_name') as $operator)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $operator->last_name }}, {{ $operator->first_name }}</td>
                <td>{{ $operator->contact_number }}</td>
                <td class="text-right">{{count($operator->van)}}</td>
                <td class="text-right">{{count($operator->drivers)}}</td>
                <td>{{$operator->updated_at->format('h:i A')." of ".$operator->updated_at->format('M d, Y')}}</td>

            </tr>
        @endforeach
        </tbody>
    </table>

</body>
</html>
