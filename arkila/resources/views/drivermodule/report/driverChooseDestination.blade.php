 @extends('layouts.driver')
 @section('title', 'Driver Report')
 @section('content-title', 'Driver Report')
 @section('content')
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="box">
          @include('message.success')
            <div class="box-header">
                <h3>Choose Terminal</h3>
            </div>
            <form>
            <div class="box-body">
                <div class="form-group">
                      {{csrf_field()}}
                      <div class="list-group">
                        <select id="selectDestination" class="form-control" name="chooseTerminal">
                          <option>Choose your Terminal</option>
                          @foreach($terminals as $terminal)
                          @if($terminal->description == $superAdminTerminal)
                            @continue
                          @endif
                            <option value="{{$terminal->terminal_id}}">{{$terminal->description}}</option>
                          @endforeach
                        </select>
                      </div>
                      <!-- /.list-group -->
                </div>
                <!-- /.form-group -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="button" id="createReport" class="btn btn-primary btn-group-justified">Select Terminal</button>
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
