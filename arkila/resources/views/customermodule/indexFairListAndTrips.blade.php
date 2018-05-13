<div id="accordionFour">
  @foreach($terminals as $terminal)
    <div class="card" style="background-color: #a0b6ff;">
        <div id="FareList{{$terminal->terminal_id}}Head" class="card-header">
            <h5 class="mb-0"><a data-toggle="collapse" href="#FareList{{$terminal->terminal_id}}Body" aria-expanded="true">Fare List {{$terminal->description}}</a></h5>
        </div>
        <div id="FareList{{$terminal->terminal_id}}Body" data-parent="#accordionFour" class="collapse">
            <div class="card-body">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th>Destination</th>
                            <th>Fare</th>
                        </tr>
                    </thead>
                    @foreach($farelist as $fare)
                      @if($fare->terminal_id == $terminal->terminal_id)
                        <tr>
                          <td>{{$fare->description}}</td>
                          <td>{{$fare->amount}}</td>
                        </tr>
                      @endif
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="card" style="background-color: #dce4ff">
        <div id="CurrentTrip{{$terminal->terminal_id}}Head" class="card-header">
            <h5 class="mb-0"><a data-toggle="collapse" href="#CurrentTrip{{$terminal->terminal_id}}Body" aria-expanded="false">Current Trip {{$terminal->description}}</a></h5>
        </div>
        <div id="CurrentTrip{{$terminal->terminal_id}}Body" data-parent="#accordionFour" class="collapse">
            <div class="card-body">

                <table class="table text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Plate No.</th>
                        </tr>
                    </thead>
                  @if($trips->where('terminal_id', $terminal->terminal_id)->count() > 0 )
                    @foreach($trips as $trip)
                    <tr>
                          <td>{{$trip->queue_number}}</td>
                          <td>{{$trip->plate_number}}</td>
                    </tr>
                    @endforeach
                 @else
                   <tr>
                     <td>No van on deck</td>
                     <td></td>
                   </tr>
                 @endif
                </table>
            </div>
        </div>
    </div>
    @endforeach
</div>
