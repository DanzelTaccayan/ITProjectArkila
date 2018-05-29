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
                            <select name="van" id="van" class="form-control select2">
                                <option value="">Choose Van</option>
                            @foreach($vans as $van)
                                <option value="{{$van->van_id}}">{{$van->plate_number}}</option>
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Driver</th>
                        <td>
                            <select name="driver" id="driver" class="form-control select2">
                                <option value="">Choose Driver</option>
                                @foreach($drivers as $driver)
                                <option value="{{$driver->member_id}}">{{$driver->full_name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center">
                <button type="submit" name="status" value="Decline" class="btn btn-danger">Decline</button> 
                <button type="submit" name="status" value="Unpaid" class="btn btn-success">Accept</button> 
            </div>
        </div>
    </form>
</div>