
@extends('layouts.form') 
@section('title', 'Add Van Driver')

@if(session()->get('opLink'))
    @section('back-link',session()->get('opLink'))
@else
    @section('back-link',route('vans.index') )
@endif
@section('form-action',route('vans.update',[$van->plate_number]))

@section('form-title', 'Edit Van')
@section('method_field',method_field("PATCH"))
@section('form-body')
    @include('message.error')

    <div class="form-group">
        <label for="">Operator:</label> <span>{{ $van->operator()->first()->full_name }}</span>
    
    </div>
    
	<div class="form-group">
        <label for="">Plate Number:</label>
        <input value="{{$van->plate_number}}" name="plateNumber" type="text" class="form-control" placeholder="Plate Number" disabled>
    </div>
    <div class="form-group">
        <label for="">Van Model</label>
        <input value="{{$van->model}}" name="vanModel" type="text" class="form-control" placeholder="Van Model" disabled>
    </div>

    <div class="form-group">
        <label for="">Seating Capacity</label>
        <input value="{{$van->seating_capacity}}" name="seatingCapacity" type="number" class="form-control" placeholder="Seating Capacity" max="16" min="1" disabled>
      
    </div>
    
    <div class="form-group">
    <label for="">Driver</label>

        <select name="driver" id="driver" class="form-control select2">
            <option value="">None</option>
            @foreach($van->operator()->first()->drivers()->doesntHave('van')->get() as $driver)
                <option value="{{$driver->member_id}}">{{$driver->full_name}}</option>
            @endforeach

        </select>
        
    </div>
@endsection 

@section('others')
<div class="form-group">
       <span id ="checkBox">
           <input name="addDriver" type="checkbox" class="minimal"> <span>Add new driver to this van unit</span>

       </span>


@endsection

@section('form-btn')
<button class="btn btn-primary" type="submit">Add Driver</button>
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

	</script>
@endsection


