<<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Vans</title>
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

    <h1>Ban Trans List of Vans</h1>
    <h2>{{ $date->formatLocalized('%A %d %B %Y') }}</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Plate Number</th>
                <th>Model</th>
                <th>Seating Capacity</th>
                <th>Date Archived</th>
            </tr>
        </thead>

        <tbody>
        @foreach ($archivedVans as $archivedVan)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$archivedVan->plate_number}}</td>
                <td>{{$archivedVan->model->description}}</td>
                <td>{{$archivedVan->seating_capacity}}</td>
                <td>{{$archivedVan->updated_at->format('h:i A')." of ".$archivedVan->updated_at->format('M d, Y')}}</td>

            </tr>
        @endforeach
        </tbody>
    </table>

</body>
</html>
