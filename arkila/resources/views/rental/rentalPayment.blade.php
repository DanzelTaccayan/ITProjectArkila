<h2><strong>STATUS: 
	<span class="text-green">UNPAID</span>
</strong></h2>
<div class="">
	<form action="" class="form-horizontal">
        <div class="padding-side-15" style="margin-top: 10%">
        	<h4>ENTER RENTAL FEE:</h4>
            <table class="table table-striped table-bordered">
                <tbody>
                    <th>Rental Fee</th>
                    <td>   
                    <input type="number" class="form-control" step="0.25">
                    </td> 
                </tbody>
            </table>
            <div class="text-center">	
                <a href="{{route('rental.index')}}" class="btn btn-default">Back</a> 
                <button type="submit" name="payment" value="Paid" class="btn btn-info"><i class="fa fa-money"></i> Receive Payment</button> 
            </div>
        </div>
    </form>
</div>