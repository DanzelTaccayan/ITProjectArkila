<h2><strong>STATUS: 
    <span class="text-green">UNPAID</span>
</strong></h2>
<div class="padding-side-10" style="margin-top: 10%;">
    <h4>RESERVATION FARE</h4>
    <div style="border: 1px solid lightgray; margin-bottom: 5%;">
        <h3 class="text-center" style="padding: 3%; font-size: 40px;"><strong class="text-green">₱ {{number_format($reservation->fare + $reservation->reservation_fee, 2)}}</strong></h3>
        <p class="text-center"><strong>EXPIRE DATE:</strong> {{$reservation->expiry_date->formatLocalized('%d %B %Y')}}</p>
    </div>
    <div class="text-center">
    	<form action="{{route('reservation.payment', $reservation->id)}}" method="post">
    		{{ csrf_field() }} {{ method_field('PATCH') }}
        <button type="submit" name="status" value="PAID" class="btn btn-success"><i class="fa fa-money"></i> Receive Payment</button>
        </form>
    </div>
</div>