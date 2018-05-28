<<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>List of Vans</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
                <th>Plate Number</th>
			    <th>Driver</th>
			    <th>Operator</th>
			    <th>Model</th>
			    <th>Seating Capacity</th>
            </tr>
        </thead>

        <tbody>
        @foreach($vans->where('status', 'Active')->sortBy('plate_number') as $van)
            <tr>
                 <td>{{$van->plate_number}}</td>
				 <td>{{ $van->driver()->first()->full_name ?? 'None' }}</td>
				 <td>{{ $van->operator()->first()->full_name ??  'None' }}</td>
				 <td>{{$van->model->description}}</td>
				 <td>{{$van->seating_capacity}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>