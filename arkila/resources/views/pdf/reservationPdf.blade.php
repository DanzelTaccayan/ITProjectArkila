<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Receipt</title>
</head>
<body>   
    <style>
        table
        {
            width: 30%;
        }
        th, td
        {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

    </style>
 
    <h4>RESERVATION DETAILS</h4>
        <table>
            <tbody>
                <tr>
                    <th>Date Issued:</th>
                    <td>{{$date->formatLocalized('%d %B %Y')}}</td>
                </tr>

                <tr>
                    <th>Reservation Code:</th>
                    <td>{{$reservation->rsrv_code}}</td>
                </tr>
                <tr>
                    <th>Destination:</th>
                    <td>{{$reservation->destination_name}}</td>
                </tr>
                <tr>
                    <th>Expiry Date:</th>
                    <td>{{$reservation->expiry_date->formatLocalized('%d %B %Y')}}</td>
                </tr>
                <tr>
                    <th>Status:</th>
                    <td>{{$reservation->status}}</td>
                </tr>
                <tr>
                    <th>Ticket Qty:</th>
                    <td>{{$reservation->ticket_quantity}}</td>
                </tr>
                <tr>
                    <th>Total Fee:</th>
                    <td>{{$reservation->fare}}</td>
                </tr>
                <tr>
                    <th>Refund Code:</th>
                    <td>{{$reservation->refund_code}}</td>
                </tr>
            </tbody>
        </table>
</body>
</html>