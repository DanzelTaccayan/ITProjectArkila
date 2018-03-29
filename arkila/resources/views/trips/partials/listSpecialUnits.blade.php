@foreach($trips as $trip)
    <li>
        <span class="list-border">
            <div id="item-sp{{$trip->trip_id}}">
                <div class="row">
                    <div class="col-xs-12">
                        {{$trip->plate_number}}
                        <div class="pull-right">
                            <i class="badge badge-pill badge-default ">{{$trip->remarks}}</i>
                            <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" style="border-radius: 100%;">
                                <i class="fa fa-gear"></i>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><button class="btn btn-menu btn-sm btn-flat btn-block">On Deck</button></li>
                                <li><button id="deleteSpBtn{{ $trip->trip_id}}"" class="btn btn-menu btn-sm btn-flat btn-block">Remove</button></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="delete-sp{{$trip->trip_id}}" class="hidden">
                <div class="row">
                    <div class="col-xs-12">  
                      <p>Are you sure you want to delete <strong>{{$trip->van->plate_number}}</strong>?</p>
                    </div>
                    <div class="col-xs-12">
                        <div class="pull-right">  
                            <button class="btn btn-default btn-xs itemSpBtn{{$trip->trip_id}}"> <i class="fa fa-times"></i></button>
                            <button class="btn btn-primary btn-xs"><i class="fa fa-check"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </span>
    </li>

    <script>
        $(document).ready(function(){
        $("#delete-sp{{$trip->trip_id}}").hide();
        $("#deleteSpBtn{{$trip->trip_id}}").click(function(){
            $("#item-sp{{$trip->trip_id}}").hide();
            $("#delete-sp{{$trip->trip_id}}").show();
            $("#delete-sp{{$trip->trip_id}}").removeClass("hidden");
        })
        $(".itemSpBtn{{$trip->trip_id}}").click(function(){
            $("#delete-sp{{$trip->trip_id}}").hide();
            $("#item-sp{{$trip->trip_id}}").show();
        })
    });
    </script>
    @endforeach