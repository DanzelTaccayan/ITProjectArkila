<div class="nav-tabs-custom">
    <ul class="nav nav-tabs nav-justified">
      @php $terminalName = null; @endphp
      @foreach($terminals as $key => $value)
          @if($value->terminal_id == $superAdminTerminal)
                @continue
          @else  
      @php $terminalName[$key] = strtolower(preg_replace('/\s*/', '', $value->description)); @endphp
        <li @if($key == 1) {{ 'class=active' }} @endif>
            <a href="#{{$terminalName[$key]}}" data-toggle="tab">{{$value->description}}</a>
        </li>
      @endif  
      @endforeach
    </ul>
    <div class="tab-content">
      @php $counter = 0; @endphp
      @foreach($terminals as $key => $value)
        @if($value->terminal_id == $superAdminTerminal)
            
            @continue
        @endif
        <div class="@if($key == 1) {{'active'}} @endif tab-pane" id="{{$terminalName[$key]}}">
            <div class="box box-solid">
                <div class="col-md-6">
                    <h4>Baguio City to {{$value->description}}</h4>
                </div>

                <div class="box-body">
                    <table class="table table-bordered queueTable text-center">
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
                                {{$trip->queue_number}}
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

<script>
  $(function() {

        $('.queueTable').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': true
        })
    })
</script>