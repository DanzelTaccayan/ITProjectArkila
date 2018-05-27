<h2><strong>STATUS: 
    <span class="text-aqua">PAID</span>
</strong></h2>
<div>
    <div class="padding-side-10" style="margin-top: 10%;">
    <form action="{{route('reservation.refund', $reservation->id)}}" method="POST">
    {{ csrf_field() }} {{ method_field('PATCH') }}
    <table class="table table-striped table-bordered">
        <tbody>
            <tr>
                <th>Paid Fare</th>
                <td class="text-right">₱ </td>
            </tr>
            <tr style="border-bottom: 2px solid black">
                <th>Cancellation Fee</th>
                <td class="text-right"></td>
            </tr>
            <tr>
                <th>Refund</th>
                <td class="text-right"></td>
            </tr>
        </tbody>
    </table>
    <p class=""><strong>REFUNDABLE UNTIL: </strong>{{$reservation->expiry_date->formatLocalized('%d %B %Y')}}</p>
    <table class="table table-striped table-bordered">
        <tbody>
            <tr>
                <th>Enter Refund Code</th>
                <td>
                <input type="text" name="refundCode" class="form-control" required></td>
            </tr>
        </tbody>
    </table>
    </div>
    <div class="text-center">
        <button type="submit" name="refund" value="REFUNDED" class="btn btn-info">Refund</button>
    </div>
    </form>
</div>