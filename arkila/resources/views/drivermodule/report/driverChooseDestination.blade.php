@extends('layouts.driver')
@section('title', 'Driver Report')
@section('content-title', 'Driver Report')
@section('content')
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="box">
          @include('message.success')
            <div class="box-header text-center">
                <h3>Choose Origin:</h3>
            </div>
            <form>
            <div class="box-body">
                <div class="form-group">
                      {{csrf_field()}}
                      <div class="list-group">
                        <select id="selectDestination" class="form-control" name="chooseTerminal">
                          <option>Choose Terminal</option>
                          @foreach($origins as $origin)
                            <option value="{{$origin->destination_id}}">{{$origin->destination_name}} to {{$mainTerminal->destination_name}}</option>
                          @endforeach
                        </select>
                      </div>
                      <!-- /.list-group -->
                </div>
                <!-- /.form-group -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="text-center">
                <button type="button" id="createReport" class="btn btn-primary">Proceed <i class="fa fa-chevron-right"></i></button>
              </div>

            </div>
            <!-- /.box-footer -->
            </form>
            <!-- /.form -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

@endsection
@section('scripts')
@parent
<script type="text/javascript">
  $('#selectDestination').on('change', function(){
    var terminalId = $(this).val();
    $('#createReport').click(function(){
      window.location.href = '/home/create-report/'+terminalId;
      return false;
    });
  });
</script>
@endsection
