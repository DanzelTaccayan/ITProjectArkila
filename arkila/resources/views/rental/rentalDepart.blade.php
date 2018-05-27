<h2><strong>STATUS: 
	<span class="text-aqua">PAID</span>
    <span class="text-gray">CANCELLED</span>
</strong></h2>
<div class="">
	<form action="{{route('rental.updateStatus', $rental->rent_id)}}" method="POST" class="form-horizontal">
    {{ csrf_field() }} {{ method_field('PATCH') }}
        <div class="padding-side-15" style="margin-top: 10%">
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Paid Fare</th>
                    <td class="text-right">₱ 200</td>
                </tr>
                <tr style="border-bottom: 2px solid black">
                    <th>Cancellation Fee</th>
                    <td class="text-right">₱ 100</td>
                </tr>
                <tr>
                    <th>Refund</th>
                    <td class="text-right"><strong>₱ 100</strong></td>
                </tr>
            </table>
            <p><strong>REFUNDABLE UNTIL:</strong></p>
            <table class="table table-striped table-bordered">
                <tbody>
                    <tr>
                        <th>Enter Refund Code:</th>
                        <td><input type="text" class="form-control"></td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center">
                <button class="btn btn-info">Refund</button>
                <button type="submit" name="status" value="Departed" class="btn bg-navy">Depart</button> 
            </div>
        </div>
    </form>
</div>