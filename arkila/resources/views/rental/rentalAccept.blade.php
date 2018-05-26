<h2><strong>STATUS: <span class="text-orange">PENDING</span>
</strong></h2>
<div class="">
    <form action="{{route('rental.updateStatus', $rental->rent_id)}}" method="POST" class="form-horizontal">
    {{ csrf_field() }} {{ method_field('PATCH') }}
        <div class="padding-side-15" style="margin-top: 10%">
            <h4>CHOOSE SERVICE PROVIDER:</h4>
            <table class="table table-striped table-bordered">
                <tbody>
                    <tr>
                        <th>Van Unit</th>
                        <td>
                            <select name="" id="" class="form-control">
                                <option value=""></option>
                                <option value=""></option>
                                <option value=""></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Driver</th>
                        <td>
                            <select name="" id="" class="form-control">
                                <option value="">HALULUO DELA CRUZ</option>
                                <option value=""></option>
                                <option value=""></option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center">   
                <a href="{{route('rental.index')}}" class="btn btn-default">Back</a> 
                <button type="submit" name="status" value="Unpaid" class="btn btn-success">Accept</button> 
            </div>
        </div>
    </form>
</div>