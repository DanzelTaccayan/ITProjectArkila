@extends('layouts.form_lg') 
@section('title', 'Line Reservation') 
@section('form-id', 'regForm') 
@section('form-action', route('reservations.store')) 
@section('form-method', 'POST') 
@section('form-body') {{csrf_field()}}
<div class="margin-side-10">
    <div class="box box-success">
        <div class="box-header with-border text-center">
            <h4>
              <a href="{{ route('reservations.index') }}"><i class="pull-left fa fa-chevron-left"></i></a>
            </h4>
            <h4 class="box-title">
            CREATE RESERVATION DATE
            </h4>
        </div>
        <div class="box-body">
            <div class="padding-side-15"> 
                <table class="table table-bordered table-striped form-table">
                    <tbody>
                        <tr>
                            <th>Destination Terminal</th>
                            <td>
                                <select name="destination" id="" class="form-control select2" val-dest-term required>
                                    <option value="">Select Terminal</option>
                                    @foreach($destinations as $destination)
                                    <option value="{{$destination->destination_id}}" @if($destination->destination_id == old('destination')) {{'selected'}}@endif>{{$destination->destination_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td><input type="text" name="date" value="{{old('date')}}" class="form-control" data-inputmask=" 'alias': 'mm/dd/yyyy'" data-mask  placeholder="mm/dd/yyy" val-date-req required></td>
                        </tr>
                        <tr>
                            <th>Time</th>
                            <td><input type="time" name="time" value="{{old('time')}}" class="form-control" placeholder="00:00" val-time required></td>
                        </tr>
                        <tr>
                            <th>Number of Slot</th>
                            <td><input type="text" name="slot" value="{{old('slot')}}" class="form-control" placeholder="" val-num-slot required></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box box-footer text-center">
            <input type="submit" class="btn btn-primary">
        </div>
    </div>
</div>

@endsection @section('scripts') @parent
<script>
    
    $(function() {

        //Date picker
        $('#timepicker').timepicker({
            showInputs: false
            // startTime: new Time();
        })

    })
</script>



<script type="text/javascript">
        $(function () {
          var $sections = $('.form-section');

          function navigateTo(index) {
            // Mark the current section with the class 'current'
            $sections
              .removeClass('current')
              .eq(index)
                .addClass('current');
            // Show only the navigation buttons that make sense for the current section:
            $('.form-navigation .previous').toggle(index > 0);
            var atTheEnd = index >= $sections.length - 1;
            $('.form-navigation .next').toggle(!atTheEnd);
            $('.form-navigation [type=submit]').toggle(atTheEnd);
          }

          function curIndex() {
            // Return the current index by looking at which section has the class 'current'
            return $sections.index($sections.filter('.current'));
          }

          // Previous button is easy, just go back
          $('.form-navigation .previous').click(function() {
            navigateTo(curIndex() - 1);
          });

          // Next button goes forward iff current block validates
          $('.form-navigation .next').click(function() {
            $('.parsley-form').parsley().whenValidate({
              group: 'block-' + curIndex()
            })  .done(function() {
              navigateTo(curIndex() + 1);
            });
          });

          // Prepare sections by setting the `data-parsley-group` attribute to 'block-0', 'block-1', etc.
          $sections.each(function(index, section) {
            $(section).find(':input').attr('data-parsley-group', 'block-' + index);
          });
          navigateTo(0); // Start at the beginning
        });

    </script>

    <script>
        $('[data-mask]').inputmask()
    $('.date-mask').inputmask('mm/dd/yyyy',{removeMaskOnSubmit: true})
    </script>
@endsection