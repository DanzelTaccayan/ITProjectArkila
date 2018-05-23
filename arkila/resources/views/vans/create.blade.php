@extends('layouts.form') 
@section('title', 'Add Van')
@if(isset($operators))
    @section('form-action',route('vans.store'))
    @section('back-link',route('vans.index'))
@else
    @section('form-action',route('vans.storeFromOperator',[$operator->member_id]))
    @section('back-link', route('operators.showProfile',[$operator->member_id]))
@endif
@section('form-title', 'ADD VAN')
@section('form-body')



@if(isset($operators))
    @if(count($operators) == 0)
        <p class ='notice-container' ><strong>Notice:</strong>Cannot add a van without an operator. Please add an operator first.</p>
    @endif

<div class="form-group">
    <label for="">Operator:</label>
    @if(count($operators) > 0)
        <select name="operator" id="" class="form-control select2">
            @foreach($operators as $operator)
                <option value="{{$operator->member_id}}">{{$operator->full_name}}</option>
            @endforeach
        </select>
    @else
        <select class="form-control select2" disabled>
                <option value="">None</option>
        </select>
    @endif
</div>
@else

<div class="form-group">
    <label for="">Operator:</label> <span>{{$operator->full_name}}</span>
</div>
@endif


<div class="form-group">
    <label for="">Plate Number:</label>
    <input value="{{old('plateNumber')}}" name="plateNumber" type="text" class="form-control"placeholder="Plate Number" required val-platenum @if(isset($operators)) @if(count($operators) == 0) disabled @endif @endif >
</div>

<div class="form-group">
    <label for="">Van Model</label>
    <input list="models" value="{{old('vanModel')}}" name="vanModel" type="text" class="form-control" maxlength="50" placeholder="Van Model" val-van-model required @if(isset($operators)) @if(count($operators) == 0) disabled @endif @endif>
    <datalist id="models">
        @foreach($models as $model)
        <option value="{{$model->description}}">
        @endforeach
    </datalist>
</div>

<div class="form-group">
    <label for="">Seating Capacity</label>
    <input value="{{old('seatingCapacity')}}" name="seatingCapacity" type="number" class="form-control" placeholder="Seating Capacity" val-seatingcapacity required @if(isset($operators)) @if(count($operators) == 0) disabled @endif @endif>
</div>

<div class="form-group">
    <label for="">Driver</label> 
    @if(isset($operators))
        <select name="driver" id="driver" class="form-control select2"@if(count($operators) == 0) disabled @endif></select>
    @else
        <select name="driver" id="driver" class="form-control select2">
        <option value="">None</option>
        @foreach($drivers as $driver)
            <option value="{{$driver->member_id}}">{{$driver->full_name}}</option>
        @endforeach
    </select> 
    @endif
</div>
@endsection
@section('others')
    <div class="form-group">
        <span id="checkBox">
            @if(isset($operators))
                @if(count($operators) > 0)
                    <input name="addDriver" type="checkbox" class="minimal"> <span>Add new driver to this van unit</span>
                @endif
            @else
                <input name="addDriver" type="checkbox" class="minimal"> <span>Add new driver to this van unit</span>
            @endif
        </span>

@endsection
        @section('form-btn')
            @if(isset($operators))
                @if(count($operators) > 0)
                <div class="" id="addVanBtn">
                    <button type="submit" class="btn btn-primary">Add unit</button>
                </div>
                @endif
            @else
            <div class="" id="addVanBtn">
                <button type="submit" class="btn btn-primary">Add unit</button>
            </div>
            @endif
            <div class="modal" id="driverWithVan-modal">
        <div class="modal-dialog modal-sm" style="margin-top: 10%;">
            <div class="modal-content">
                <div class="modal-header bg-yellow">
                    <h4 class="modal-title">WARNING</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    
                </div>
                <div class="modal-body">
                    <h4>There's already a van associated to this driver. If you wish to continue, the driver will be associated to this van instead.</h4>
                </div>
                <div class="modal-footer">
                    <div class="pull-right">    
                        <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
                        <button type="submit" class="btn btn-primary">Continue</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
        @endsection

@section('scripts')
	@parent
	<script>
        $(function () {
            $('.select2').select2();

            $('input[type="checkbox"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue'
            });

            checkBoxChecker();
            @if(isset($operators))
                $('select[name="driver"]').empty();
                listDrivers();
            @endif
    });

        $('#driver').on('change', function() {
            if(this.value.trim().length === 0 && $('#checkBox').is(':empty')){
                    $('#checkBox').append('<input name="addDriver" type="checkbox" class="minimal"> <span>Add new driver to this van unit</span>');
            }else{
                    $('#checkBox').empty();
            }
            $('input[type="checkbox"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue'
            });
            checkBoxChecker();
        });


        function checkBoxChecker(){
            $('input[name="addDriver"]').on('ifChecked', function(){
                $('#driver').prop('disabled', true);
            });

            $('input[name="addDriver"]').on('ifUnchecked', function(){
                $('#driver').prop('disabled', false);
            });
        }
@if(isset($operators))

$('select[name="operator"]').on('change',function(){
    $('select[name="driver"]').empty();
    listDrivers();
});

 function listDrivers(){
            $.ajax({
                method:'POST',
                url: '{{route("vans.listDrivers")}}',
                data: {
                    '_token': '{{csrf_token()}}',
                    'operator':$('select[name="operator"]').val()
                },
                success: function(drivers){
                    $('[name="driver"]').append('<option value="">None</option>');
                    drivers.forEach(function(driverObj){

                        $('[name="driver"]').append('<option value='+driverObj.id+'> '+driverObj.name+'</option>');
                    })
                }

            });
}
        @endif
	</script>
    <script>
        $('select[name="driver"]').on('change', function(){
            $.ajax({
                method: 'POST',
                url: '{{route("checkDriverVan")}}',
                data: {
                    '_token': '{{csrf_token()}}',
                    'driver': $('select[name="driver"]').val()
                },
                success: function(response){
                    if(response == 'modal'){
                        $( "#addVanBtn" ).replaceWith( "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#driverWithVan-modal'>Add unit</button>" );
                    }else if (response == 'submit'){
                        $( "#addVanBtn" ).replaceWith( "<button type='submit' class='btn btn-primary'>Add unit</button>" );
                    }
                }
            });
        });
    </script>
@endsection


