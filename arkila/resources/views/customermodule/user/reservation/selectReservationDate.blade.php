@extends('layouts.customer_user')
@section('content')
<div id="content">
    <div class="container" style="height:600px;">
      <div class="row bar mb-0">
        <div id="customer-orders" class="col-md-8">
          <div class="heading text-center">
                <h2>RESERVATION DATES</h2>
           </div>
          <div class="box mt-0 mb-lg-0" style="box-shadow: 0px 5px 10px grey; background-color: white;">
            <div class="table-responsive">
              <table class="table table-hover table-bordered table-striped">
                <thead>
                  <tr>
                    <th class="text-center">Order</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Time</th>
                    <th class="text-center">Remaining Slots</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($destination->first()->routeDestination as $route)
                    @if($reservations->where('destination_terminal', $route->destination_id)->count() == 0)
                    <tr>
                    <td class="text-center" colspan="5">NO AVAILABLE DATE OF RESERVATION</td>    
                    </tr
                    @else
                        @foreach($reservations->where('destination_terminal', $route->destination_id) as $reserve)
                        <tr>
                            <th># 1735</th>
                            <td>{{$reserve->reservation_date->formatLocalized('%d %B %Y')}}</td>
                            <td class="text-right">{{ date('g:i A', strtotime($reserve->departure_time)) }}</td>
                            <td class="text-right">{{$reserve->number_of_slots}}</td>
                            <td>
                                @if($reserve->number_of_slots > 0)
                                <div class="text-center">
                                    <a href="{{route('customermodule.createReservation', $reserve->id)}}" class="btn btn-success btn-sm">RESERVE</a>
                                </div>
                                @elseif($reserve->status == 'CLOSED')
                                <p>Closed</p>
                                @else
                                <p>Fully Booked</p>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    @endforeach          
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-4 mt-4 mt-md-0">
          <!-- CUSTOMER MENU -->
          <div class="panel panel-default sidebar-menu">
            <div class="panel-heading text-center" style="margin-top: 10px;">
              <h2 class="h3 panel-title">SELECT DESTINATION</h2>
            </div>
            <div class="panel-body">
                <form action="{{route('customermodule.showDate')}}" class="contact100-form">
                    <div class="form-group">
                        <select name="destination" id="" class="form-control">
                            @foreach($destinations as $route)
                            <option value="{{$route->destination_id}}" @if($route->destination_id == $getDestination) {{'selected'}} @endif>{{$route->destination_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="container-contact100-form-btn">
                        <button type="submit" value="Update" name="submit" class="contact100-form-btn"><strong>SHOW RESERVATIONS</strong></button>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
@section('scripts')
@endsection