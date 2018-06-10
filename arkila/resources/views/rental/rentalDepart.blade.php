<h2><strong>STATUS: 
@if($rental->status == 'Paid')
	<span class="text-aqua">PAID</span>
@elseif($rental->status == 'Cancelled')
    <span class="text-red">CANCELLED</span>
@endif
</strong></h2>
<div class="">
	<form action="{{route('rental.updateStatus', $rental->rent_id)}}" method="POST" class="form-horizontal">
    {{ csrf_field() }} {{ method_field('PATCH') }}
        <div class="padding-side-15" style="margin-top: 10%">
            @if($rental->is_refundable == false)
            <p>The transaction has already expired and cannot be refunded.</p>
            @else
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Paid Fare</th>
                        <td class="text-right">₱{{$rental->rental_fare}}</td>
                    </tr>
                    <tr>
                        <th>Cancellation Fee</th>
                        <td class="text-right">₱{{$rental->cancellation_fee}}</td>
                    </tr>
                    @if($destination)
                    <tr>
                        <th>Refund Amount</th>
                        <td class="text-right"><strong>₱{{number_format($rental->rental_fare - $rental->cancellation_fee, 2)}}</strong></td>
                    </tr>
                    @else
                    <tr style="border-bottom: 2px solid black">
                        <th>Rental Fee</th>
                        <td class="text-right">₱{{$rental->rental_fee}}</td>
                    </tr>
                    <tr>
                        <th>Refund Amount</th>
                        <td class="text-right"><strong>₱{{number_format(($rental->rental_fare - $rental->cancellation_fee) - $rental->rental_fee, 2)}}</strong></td>
                    </tr>
                    @endif
                </table>
                <p><strong>REFUNDABLE UNTIL: @if($rental->status == 'Paid') {{$rental->departure_date->subDays(2)->formatLocalized('%d %B %Y')}} @elseif ($rental->status == 'Cancelled' && $rental->is_refundable == true) {{$rental->updated_at->addDays($rules->refund_expiry)->formatLocalized('%d %B %Y')}} @endif</strong></p>
                <table class="table table-striped table-bordered">
                    <tbody>
                        <tr>
                            <th>Enter Refund Code:</th>
                            <td><input type="text" name="refund" class="form-control"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center">
                    <button type="submit" name="status" value="Refunded" class="btn btn-info">Refund</button>
                @endif
                @if($rental->status == 'Paid')
                    <button type="submit" name="status" value="Departed" class="btn bg-navy">Depart</button>
                </div>
                @endif
        </div>
    </form>
</div>