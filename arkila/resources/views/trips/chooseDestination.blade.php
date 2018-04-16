@extends('layouts.master')
@section('title', 'Create Report')
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
                          @foreach($terminals as $terminal)
                          
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


@endsection

@section('scripts')
@parent

<script type="text/javascript">
  $('#selectDestination').on('change', function(){
    var terminalId = $(this).val();
    $('#createReport').click(function(){
      window.location.href = '/home/terminal/'+terminalId+'/create-report';
      return false;
    });
  });
</script>

@endsection
