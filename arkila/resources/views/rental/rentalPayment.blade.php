<h2><strong>STATUS: 
	<span class="text-green">UNPAID</span>
</strong></h2>
<div class="">
	<form action="{{route('rental.updateStatus', $rental->rent_id)}}" method="POST" class="form-horizontal">
    {{ csrf_field() }} {{ method_field('PATCH') }}
        <div class="padding-side-15" style="margin-top: 10%">
        	<h4>ENTER RENTAL FEE:</h4>
            <table class="table table-striped table-bordered">
                <tbody>
                    <th>Rental Fare</th>
                    <td>   
                    <input type="number" name="fare" class="form-control" step="0.25">
                    </td> 
                </tbody>
            </table>
            <div class="text-center">
                <button type="submit" name="status" value="Paid" class="btn btn-info"><i class="fa fa-money"></i> Receive Payment</button> 
            </div>
        </div>
    </form>
</div>