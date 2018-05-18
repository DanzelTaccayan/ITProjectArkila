@extends('layouts.master')
@section('title', 'Create Report')
@section('content')

<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="box">
          @include('message.success')
            <div class="box-header text-center">
                <h3>Choose Route:</h3>
            </div>
            <form>
            <div class="box-body">
                <div class="form-group">
                      {{csrf_field()}}
                      <div class="list-group">
                        <select id="selectDestination" class="form-control text-uppercase" name="chooseTerminal">
                          <option class="text-uppercase">Choose Route</option>
                          @foreach($terminals as $terminal)
                            @php $findTerminalDown = $terminal->terminalOrigin()->groupBy('terminal_origin')->get(); @endphp
                            @foreach($findTerminalDown as $fKeys => $fValues)
                              @php
                                $origin = \App\Destination::where('destination_id', $fValues->pivot->terminal_origin)->first();
                                $destination = \App\Destination::where('destination_id', $fValues->pivot->terminal_destination)->first();
                              @endphp
                            <option class="text-uppercase" value="{{$origin->destination_id}} {{$destination->destination_id}}">{{$origin->destination_name}} - {{$destination->destination_name}}</option>
                            @endforeach
                            @php $findTerminalUp = $terminal->terminalOrigin()->groupBy('terminal_destination')->get(); @endphp
                            @foreach($findTerminalUp as $fKeys => $fValues)
                              @php
                                $origin = \App\Destination::where('destination_id', $fValues->pivot->terminal_destination)->first();
                                $destination = \App\Destination::where('destination_id', $fValues->pivot->terminal_origin)->first();
                              @endphp
                              <option  class="text-uppercase" value="{{$origin->destination_id}} {{$destination->destination_id}}">{{$origin->destination_name}} - {{$destination->destination_name}}</option>
                              @endforeach
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
    var originDestinationId = $(this).val();
    originDestinationId = originDestinationId.split(/(\s+)/);
    // console.log(originDestinationId);
    // idArray = [];
    // for(var i = 0; i < originDestinationId.length; i++){
    //   idArray.push(originDestinationId[i]);
    //   if(i != originDestinationId.length-1){
    //     idArray.push(" ");
    //   }
    // }
    // console.log(idArray);
    $('#createReport').click(function(){
      window.location.href = '/home/terminal/'+originDestinationId[0]+'/'+originDestinationId[2]+'/create-report';
      return false;
    });
  });
</script>

@endsection
