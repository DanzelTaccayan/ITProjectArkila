<h2><strong>STATUS: 
    @if($reservation->status == 'OPEN')
    <span class="text-aqua">PAID</span>
    @elseif($reservation->status == 'CANCELLED')
    <span class="text-red">CANCELLED</span>
    @endif
</strong></h2>
<div>
    <div class="padding-side-10" style="margin-top: 10%;">
    <table class="table table-striped table-bordered">
        <tbody>
            <tr>
                <th>Paid Fare</th>
                <td class="text-right">₱{{$reservation->fare}} </td>
            </tr>
            <tr style="border-bottom: 2px solid black">
                <th>Reservation Fee</th>
                <td class="text-right">₱{{$rules->fee}}</td>
            </tr>
            <tr>
                <th>Refund</th>
                <td class="text-right">₱{{number_format($reservation->fare - $rules->fee, 2)}}</td>
            </tr>
        </tbody>
    </table>
    <p class=""><strong>REFUNDABLE UNTIL: </strong>@if($reservation->status == 'PAID'){{$reservation->reservationDate->reservation_date->subDays(2)->formatLocalized('%d %B %Y')}}@elseif($reservation->status == 'CANCELLED' && $reservation->is_refundable == true) {{$reservation->updated_at->addDays($rules->refund_expiry)->formatLocalized('%d %B %Y')}} @endif</p>
    <form action="{{route('reservation.refund', $reservation->id)}}" method="POST">
    {{ csrf_field() }} {{ method_field('PATCH') }}
    <table class="table table-striped table-bordered">
        <tbody>
            <tr>
                <th>Enter Refund Code</th>
                <td>
                <input type="text" name="refundCode" class="form-control" required></td>
            </tr>
        </tbody>
    </table>
    <div class="text-center">
        <button type="submit" name="refund" value="REFUNDED" class="btn btn-info">Refund</button>
    </div>
    </form>
</div>