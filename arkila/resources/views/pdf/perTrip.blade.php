<<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Trip</title>
</head>
    <body>
   <style>
        div#summary
        {
            padding: 15px;
            text-align: center;
        }
        h1, h2, h3, h4, h5
        {
            text-align: center;
        }
    </style>

    <h1>Ban Trans</h1>
    <h2>{{ $date->formatLocalized('%A %d %B %Y') }}</h2>
        <h3>Destination</h3>
        <div>
          @php $totalPassengers = 0; @endphp
            @foreach($destinations as $key => $values)
                @if($trip->trip_id == $values->tripid)
                    @php $innerRoutesArr[$key] = $values; @endphp
            <div>
                        <label for="">{{$values->destdesc}}</label>
                            <input type="text" id="qty{{$trip->trip_id}}" value="{{$values->counts}}" disabled>
                                @php $totalPassengers = $totalPassengers + $values->counts; @endphp
            </div>
                @endif
            @endforeach
            </div>
                                <label for="">Total</label>
                                <input id="" type="text" id="total" style="width:30%;" value="{{$totalPassengers}}" disabled>
                        <div id="summary">
                        <div>
                            <h4>Summary</h4>
                        </div>
                         <div>
                            <label>Driver:</label>
                            <name>{{$trip->driver->first_name . " " . $trip->driver->middle_name . " " . $trip->driver->last_name}}</name>
                        </div>
                        <div>
                            <label>Van:</label>
                            <name>{{$trip->plate_number}}</name>
                        </div> 
                        <div>
                            <label>Origin:</label>
                            <name>{{$superAdmin->description}}</name>
                        </div>
                        <div>
                            <label>Destination:</label>
                            <name>{{$trip->terminal->description}}</name>
                        </div>
                        <div>
                            <label>Date:</label>
                            <name>{{$trip->date_departed}}</name>
                        </div>
                        <div>
                            <label>Time:</label>
                            <name>{{$trip->time_departed}}</name>
                        </div> 
                        </div>
        
                            <div>
                                <h4>Shares</h4>
                            </div>
                            <div id="share">
                                <div>
                                    <label for="">BanTrans: </label>
                                    @php $bantrans = 0; @endphp
                                    @if($trip->SOP == null)
                                        @php $bantrans = $trip->total_booking_fee + $trip->community_fund  @endphp
                                    @else
                                        @php $bantrans = $trip->total_booking_fee + $trip->SOP + $trip->community_fund  @endphp
                                    @endif
                                    
                                    @php $totalfare = 0; @endphp
                                    @foreach($destinations as $key => $values)
                                        @php $totalfare = $totalfare + ($values->amount * $values->counts); @endphp
                                    @endforeach
                                    <input type="text" value="{{floatval($bantrans)}}" disabled>
                                </div>

                                <label for="">Driver:</label>
                                <input type="text" value="{{$totalfare}}" disabled>
                                
                            </div>
                        
  
    </body>
</html>