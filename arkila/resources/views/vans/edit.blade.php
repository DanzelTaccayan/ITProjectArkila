
@extends('layouts.form')
@section('title', 'Edit Van')

@if(session()->get('opLink'))
    @section('back-link',session()->get('opLink'))
@else
    @section('back-link',route('vans.index') )
@endif
@section('form-action',route('vans.update',[$van->plate_number]))

@section('form-title', 'EDIT VAN')
@section('method_field',method_field("PATCH"))
@section('form-body')
    @include('message.error')

    <div class="form-group">
        <label for="">Operator:</label> <span></span>
        <select name="operator" id="" class="form-control select2">
        @foreach($operators as $operator)
            <option @if($operator->member_id == $van->operator->first()->member_id) {{'selected'}}@endif value="{{$operator->member_id}}">{{$operator->full_name}}</option>
        @endforeach
    </select>
    </div>

	<div class="form-group">
        <label for="">Plate Number:</label>
        <p class="info-container">{{$van->plate_number}}</p>
        <input type="hidden" value="{{$van->plate_number}}">
    </div>

    <div class="form-group">
        <label for="">Van Model</label>
        <p class="info-container">{{$van->vanModel->description}}</p>
        <input type="hidden" value="{{$van->vanModel->description}}">
    </div>

    <div class="form-group">
        <label for="">Seating Capacity</label>
        <p class="info-container">{{$van->seating_capacity}}</p>
        <input type="hidden" value="{{$van->seating_capacity}}">
    </div>

    <div class="form-group">
    <label for="">Driver</label>

        <select name="driver" id="driver" class="form-control select2">
            <option value="">None</option>
            @foreach($drivers as $driver)
                <option @if($van->driver->first()->member_id ?? null) @if($driver->member_id == $van->driver->first()->member_id) {{'selected'}} @endif @endif value="{{$driver->member_id}}">{{$driver->full_name}}</option>
            @endforeach

        </select>

    </div>
@endsection

@section('others')
<div class="form-group">

       <span id ="checkBox">
           @if($van->driver->first()->member_id ?? null)
               @else
               <input name="addDriver" type="checkbox" class="minimal"> <span>Add new driver to this van unit</span>
           @endif
       </span>



@endsection

@section('form-btn')
<button class="btn btn-primary" type="submit">@if( $van->driver->first()->member_id ?? null) Change Driver @else Add Driver @endif</button>
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

            @if($van->driver->first()->member_id ?? null)
                $('#checkBox').empty();
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

	</script>
@endsection
