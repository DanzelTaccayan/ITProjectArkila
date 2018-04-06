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
<div class="form-group">
    <label for="">Operator:</label>
    <select name="operator" id="" class="form-control select2">
        @foreach($operators as $operator)
            <option value="{{$operator->member_id}}">{{$operator->full_name}}</option>
        @endforeach
    </select>
</div>
@else

<div class="form-group">
    <label for="">Operator:</label> <span>{{$operator->full_name}}</span>
</div>
@endif

<div class="form-group">
    <label for="">Plate Number:</label>
    <input value="{{old('plateNumber')}}" name="plateNumber" type="text" class="form-control"placeholder="Plate Number" required val-platenum>
</div>
<div class="form-group">
    <label for="">Van Model</label>
    <input list="models" value="{{old('vanModel')}}" name="vanModel" type="text" class="form-control" maxlength="50" placeholder="Van Model" val-van-model required>
    <datalist id="models">
        @foreach($models as $model)
        <option value="{{$model->description}}">
        @endforeach
    </datalist>
</div>

<div class="form-group">
    <label for="">Seating Capacity</label>
    <input value="{{old('seatingCapacity')}}" name="seatingCapacity" type="number" class="form-control" placeholder="Seating Capacity" val-seatingcapacity required>
</div>

<div class="form-group">
    <label for="">Driver</label> 
    @if(isset($operators))
        <select name="driver" id="driver" class="form-control select2"></select> @else
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
           <input name="addDriver" type="checkbox" class="minimal"> <span>Add new driver to this van unit</span>

        </span>

@endsection

@section('form-btn')
    <button type="submit" class="btn btn-primary">Add unit</button>
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
@endsection


