<div class="nav-tabs-custom">
    <ul class="nav nav-tabs nav-justified">
      @php $terminalName = null; @endphp
      @foreach($terminals as $key => $value)
      @php $terminalName[$key] = strtolower(preg_replace('/\s*/', '', $value->description)); @endphp
        <li @if($key == 0) {{ 'class=active' }} @endif><a href="#{{$terminalName[$key]}}" data-toggle="tab">{{$value->description}}</a></li>

      @endforeach
    </ul>
    <div class="tab-content">
      @php $counter = 0; @endphp
      @foreach($terminals as $key => $value)
        <div class="@if($key == 0) {{'active'}} @endif tab-pane" id="{{$terminalName[$counter]}}">
            <div class="box">
                <div class="box-header">
                    <h4>Van Queue {{$value->description}}</h4>

                </div>
                <div class="box-body">
                    <table class="table table-bordered dataTable text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Plate No.</th>
                                <th>Remark</th>

                            </tr>
                        </thead>
                        @foreach($trips as $trip)
                        <tr>
                            @if($trip->terminaldesc == $value->description)
                            <td>
                                @if($trip->queueId == 1 || $trip->queueId == 2 )
                                <i class="fa fa-star text-yellow"></i> @endif {{$trip->queueId}}
                            </td>
                            <td>{{$trip->plate_number}}</td>
                            <td>{{$trip->remarks}}</td>
                            @endif
                        </tr>

                        @endforeach
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.terminal_name -->
        @php $counter++; @endphp
        @endforeach
    </div>
    <!-- /.tab-content -->
</div>
<!-- /.nav-tabs -->