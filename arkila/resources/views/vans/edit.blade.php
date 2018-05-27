
@extends('layouts.form')
@section('title', 'Edit Van')

@if(session()->get('opLink'))
    @section('back-link',session()->get('opLink'))
@else
    @section('back-link',route('vans.index') )
@endif

@section('form-action',route('vans.update',[$van->van_id]))

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
        <p class="info-container">{{$van->model->description}}</p>
        <input type="hidden" value="{{$van->model->description}}">
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
<button id="editVanBtn" class="btn btn-primary" type="submit">Save Changes</button>
<div id="editVanBtnM" class="hidden">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#driverWithVan-modal">Save Changes</button>
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
    <script>
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
            $('[name="driver"]').append('<option value="" data-van="null">None</option>');
            drivers.forEach(function(driverObj){

                $('[name="driver"]').append('<option value='+driverObj.id+' data-van='+driverObj.van+'> '+driverObj.name+'</option>');
            })
        }

    });
}
@endif

$('select[name="driver"]').on('change', function(){
   var van = $(this).find(':selected').data('van');
   console.log(van);
   if(van !== null){
    console.log(van);
    $( "#addVanBtn" ).hide();
    $( "#addVanBtnM" ).show();
    $( "#addVanBtnM" ).removeClass("hidden");
   } else {
    console.log(van);
    $( "#addVanBtn" ).show();
    $( "#addVanBtnM" ).hide();
   }
});
</script>
@endsection
