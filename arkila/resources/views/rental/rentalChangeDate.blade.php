<h2><strong>CHANGE DEPARTURE
</strong></h2>
<div class="">
	<form action="{{route('rental.updateStatus', $rental->rent_id)}}" method="POST" class="form-horizontal">
    {{ csrf_field() }} {{ method_field('PATCH') }}
            <div class="padding-side-15">
                <div class="form-group">
                    <label>Departure Date: <span class="text-red">*</span></label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control" name="date" id="date" value="{{ old('date') }}" placeholder="mm/dd/yyyy" data-inputmask="'alias': 'mm/dd/yyyy'" data-parsley-errors-container="#errDepartureDate" data-mask val-book-date data-parsley-valid-departure required>
                    </div>
                    <p id="errDepartureDate"></p>
                </div>
                <div class="form-group">
                    <label>Departure Time: <span class="text-red">*</span></label>
                    <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-clock-o"></i>
                        </div>
                        <input type="text" class="form-control" name="time" value="{{ old('time') }}" id = "timepicker" data-parsley-errors-container="#errDepartureTime" val-book-time required>
                    </div>
                    <p id="errDepartureTime"></p>
                </div>
                <div class="text-center">
                    <button type="submit" name="status" value="Paid" class="btn btn-info"><i class="fa fa-money"></i>Save Changes</button> 
                </div>
            </div>
        </div>
    </form>
</div>