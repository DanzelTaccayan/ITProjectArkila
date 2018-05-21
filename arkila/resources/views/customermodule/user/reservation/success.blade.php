@extends('layouts.customer_user')
@section('content')
<section class="mainSection">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mx-auto" id="boxContainer">
                    <div class="contact100-form" style="background: lightgreen; margin-bottom: 0px;">
                        <h1 class="text-center" style="font-size: 60px; color: white;"><i class="fa fa-check-circle"></i> SUCCESS!</h1>
                    </div>
                    <div class="contact100-form">
                    	<table class="table table-striped table-bordered">
                    		<tbody>
                    			<tr>
                    				<th>Destination</th>
                    				<td>Asingan</td>
                    			</tr>
                    			<tr>
                    				<th>Expiry Date</th>
                    				<td>10/10/20</td>
                    			</tr>
                    			<tr>
                    				<th>Status</th>
                    				<td>UNPAID</td>
                    			</tr>
                    			<tr>
                    				<th>Ticket Qty</th>
                    				<td></td>
                    			</tr>
                    			<tr>
                    				<th>Total Amount to Pay</th>
                    				<td>1000</td>
                    			</tr>
                    		</tbody>
                    	</table>
                    	<p><strong>NOTE:</strong> Pay the total amount at the company office before the expiry date.</p>
                    	<div class="mx-auto">
                    		<button class="btn btn-primary btn-lg">OK</button>
                    	</div>
                    </div>
                </div>
                <!-- col-->
            </div>
            <!-- row-->
        </div>
        <!-- container-->
</section>
@endsection