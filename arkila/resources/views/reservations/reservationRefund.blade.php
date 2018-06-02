<h2><strong>STATUS: 
    <span class="text-aqua">PAID</span>
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
                <td class="text-right">₱{{$rules->reservation_fee}}</td>
            </tr>
            <tr>
                <th>Refund</th>
                <td class="text-right">₱{{number_format($reservation->fare - $rules->reservation_fee, 2)}}</td>
            </tr>
        </tbody>
    </table>
    <p class=""><strong>REFUNDABLE UNTIL: </strong>{{$reservation->reservationDate->reservation_date->subDays(2)->formatLocalized('%d %B %Y')}}</p>
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