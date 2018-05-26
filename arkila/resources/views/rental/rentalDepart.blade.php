<h2><strong>STATUS: 
	<span class="text-aqua">PAID</span>
</strong></h2>
<div class="">
	<form action="{{route('rental.updateStatus', $rental->rent_id)}}" method="POST" class="form-horizontal">
    {{ csrf_field() }} {{ method_field('PATCH') }}
        <div class="padding-side-15" style="margin-top: 10%">
            <div class="text-center">	
                <a href="{{route('rental.index')}}" class="btn btn-default">Back</a>
                <button type="submit" name="status" value="Departed" class="btn bg-navy">Depart</button> 
            </div>
        </div>
    </form>
</div>