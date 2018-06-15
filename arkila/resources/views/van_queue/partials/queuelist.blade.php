<div class="row">
  <div id="van-queue" class="col-md-7">  
    <div class="queue-heading">
      <h4> <i class="fa fa-list-ol "></i> {{$terminal->destination_name}}</h4>
    </div>
    <div class="input-group">
      <span class="input-group-addon"><i class="fa fa-search"></i></span>
      <input type="text" id="queueSearch{{$terminal->destination_id}}" class="form-control" placeholder="Search in queue" onkeyup="search{{$terminal->destination_id}}()">
    </div>
    <div class="queue-body"> 
      <div class="queue-body-color scrollbar scrollbar-info thin">
        <ol id ="queue-list{{$terminal->destination_id}}" data-number="{{$key}}" class="rectangle-list serialization arrow-drag">
            @foreach ($queue->where('destination_id',$terminal->destination_id) as $vanOnQueue)
              <li id="unit{{$vanOnQueue->van_queue_id}}" data-vanid="{{$vanOnQueue->van_id}}" class="queue-item form-horizontal">
                <span id="trip{{$vanOnQueue->van_queue_id}}" class="list-border">
                  <div class="queuenum">
                      <p name="queueIndicator" id="queueIndicator{{$vanOnQueue->van_queue_id}}">{{ $vanOnQueue->queue_number }}</p>
                  </div>
                  <div class=item id="item{{$vanOnQueue->van_queue_id}}">
                    <div  class="row">
                      <div class="col-md-12">
                        <p class="hidden hidden_plateNo">{{ $vanOnQueue->van->plate_number }}</p>
                        {{ $vanOnQueue->van->plate_number }}
                        <div class="pull-right">
                            <i id="badge{{$vanOnQueue->van_queue_id}}" class="badge badge-pill badge-default">{{ $vanOnQueue->remarks }}</i>
                            <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" style="border-radius: 100%">
                              <i class="fa fa-gear"></i>
                            </button>
                            <div class="dropdown-menu" role="menu">
                              <a name="remarkBtn" data-val="{{$vanOnQueue->van_queue_id}}" class="btn btn-menu btn-sm btn-flat btn-block"><i class="glyphicon glyphicon-asterisk"></i> Update Remark</a>
                              <a name="posBtn" data-val="{{$vanOnQueue->van_queue_id}}" class="btn btn-menu btn-sm btn-flat btn-block"><i class="glyphicon glyphicon-move"></i> Change Position</a>
                              <a name="destBtn" data-val="{{$vanOnQueue->van_queue_id}}" class="btn btn-menu btn-sm btn-flat btn-block"><i class="glyphicon glyphicon-map-marker"></i> Change Destination</a>
                              <a name="moveToSpecialUnitsList" data-val="{{$vanOnQueue->van_queue_id}}" class="btn btn-menu btn-sm btn-flat btn-block"><i class="glyphicon glyphicon-star"></i> Move to Special Units</a>
                              <a name="deleteBtn" data-val="{{$vanOnQueue->van_queue_id}}" class="btn btn-menu btn-sm btn-flat btn-block"><i class="glyphicon glyphicon-trash"></i> Remove</a>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div id="remarkitem{{$vanOnQueue->van_queue_id}}" class="hidden remarkitem">
                    <div class="form-group">
                      <label for="" class="col-sm-2 control-label">Remark:</label>
                       <div class="col-sm-3">
                        <select name="remark" id="remark{{$vanOnQueue->van_queue_id}}" class="form-control">
                          <option @if($vanOnQueue->remarks == "CC") selected @endif value="CC">CC</option>
                          <option @if($vanOnQueue->remarks == "ER") selected @endif value="ER">ER</option>
                          <option @if($vanOnQueue->remarks == "OB") selected @endif value="OB">OB</option>
                          <option @if($vanOnQueue->remarks == null) selected @endif value="NULL">None</option>
                        </select>
                       </div>
                     </div>
                     <div class="pull-right"> 
                        <button data-val="{{$vanOnQueue->van_queue_id}}" class="btn btn-default btn-sm itemBtn">CANCEL</button>
                        <button name="updateRemarksButton" data-val="{{$vanOnQueue->van_queue_id}}" class="btn btn-primary btn-sm">UPDATE</button>
                       </div>
                       <div class="clearfix"> </div>
                  </div>
                  <div id="positem{{$vanOnQueue->van_queue_id}}" class="hidden positem">
                    <div class="form-group">
                      <label for="" class="col-sm-2 control-label">Position:</label>
                       <div class="col-sm-3">
                        <select name="changePosition" id="posOption{{$vanOnQueue->van_queue_id}}" class="form-control">
                            @foreach($terminals->where('destination_id',$vanOnQueue->destination_id)->first()
                          ->vanQueue()
                          ->whereNotNull('queue_number')
                          ->orderBy('queue_number')->get() as $queueNumber)
                                <option value="{{$queueNumber->queue_number}}" @if($queueNumber->queue_number === $vanOnQueue->queue_number) {{'selected'}} @endif>{{$queueNumber->queue_number}}</option>
                            @endforeach
                        </select>
                       </div>
                     </div>
                     <div class="pull-right"> 
                        <button data-val="{{$vanOnQueue->van_queue_id}}" class="btn btn-default btn-sm itemBtn">CANCEL</button>
                        <button name="changePosButton" data-vanqueue="{{$vanOnQueue->van_queue_id}}" data-destination = "{{$vanOnQueue->destination_id}}" class="btn btn-primary btn-sm">CHANGE</button>
                       </div>
                       <div class="clearfix"> </div>
                  </div>
                  <div id="destitem{{$vanOnQueue->van_queue_id}}" class="destitem hidden">
                      <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Destination:</label>
                         <div class="col-sm-8">
                            <select id="destOption{{$vanOnQueue->van_queue_id}}" class="form-control">
                            @foreach($terminals as $term)
                            <option @if($term->destination_id == $vanOnQueue->destination_id) {{'selected'}} @endif value="{{$term->destination_id}}">{{$term->destination_name}}</option>
                            @endforeach
                            </select>
                         </div>
                       </div>
                      <div class="pull-right">
                        <button data-val="{{$vanOnQueue->van_queue_id}}" class="btn btn-default btn-sm itemBtn">CANCEL</button>
                        <button name="destBtn" data-val="{{$vanOnQueue->van_queue_id}}" class="btn btn-primary btn-sm">CHANGE</button>
                      </div>
                      <div class="clearfix">  </div>
                  </div>
                  <div id="deleteitem{{$vanOnQueue->van_queue_id}}" class="deleteitem hidden">
                          <p><strong>{{ $vanOnQueue->van->plate_number }}</strong> will be deleted. Do you want to continue?</p>
                      <div class="pull-right">
                          <form name="deleteForm" data-type="normal" data-van="{{$vanOnQueue->van_queue_id}}" method="POST" action="{{route('vanqueue.destroy',[$vanOnQueue->van_queue_id])}}">
                              {{method_field('DELETE')}}
                              {{csrf_field()}}
                            <a data-val="{{$vanOnQueue->van_queue_id}}" class="btn btn-default btn-sm itemBtn"> CANCEL</a>
                            <button type="submit" name="deleteBtn" data-val="{{$vanOnQueue->van_queue_id}}" class="btn btn-primary btn-sm"> YES</button>
                          </form>
                      </div>
                      <div class="clearfix"></div>
                  </div>
                </span>
              </li>
            @endforeach
        </ol>
      </div>
    </div>
  </div>
  <div class="col-md-5">
    <div class="well">
      <div class="text-center">
        @if($terminal->vanQueue()->whereNotNull('queue_number')->whereNull('remarks')->where('queue_number',1)->first() ?? null)
            <button name="boardPageBtn" data-terminal="{{$terminal->destination_id}}" type="button" class="btn btn-primary btn-lg">BOARD PASSENGERS <i class="fa fa-arrow-circle-o-right"></i></button>
        @elseif ($vanOnQueue = $terminal->vanQueue()->where('queue_number',1)->where('remarks','OB')->orderBy('queue_number')->first() ?? null)
                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#ondeckOB-modal{{$vanOnQueue->van_queue_id}}">BOARD PASSENGERS <i class="fa fa-arrow-circle-o-right"></i></button>
                <div class="modal" id="ondeckOB-modal{{$vanOnQueue->van_queue_id}}">
                    <div class="modal-dialog" style="margin-top: 10%;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body">
                                <h1 class="text-center text-aqua"><i class="fa fa-exclamation-circle"></i> CONFIRMATION</h1>
                                <p class="text-center"><strong class="text-blue" style="font-size: 20px">{{$vanOnQueue->van->plate_number}}</strong> IS ON DECK AND HAS A REMARK OF <strong class="text-green" style="font-size: 20px">OB</strong>. WILL IT REMAIN ON DECK?</p>
                            </div>
                            <div class="modal-footer">
                                <div class="text-center">
                                    <button data-van="{{$vanOnQueue->van_queue_id}}" name="moveToSpecialUnits" type="button" class="btn btn-default"><i class="text-yellow fa fa-star"></i> MOVE TO SPECIAL UNITS</button>
                                    <button data-van="{{$vanOnQueue->van_queue_id}}" name="remainOnDeck" type="button" class="btn btn-primary ">REMAIN ON DECK</button>
                                </div>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
        @elseif($vanOnQueue = $terminal->vanQueue()->where('queue_number',1)->where('remarks','ER')->orWhere('remarks','CC')->orderBy('queue_number')->first() ?? null)
                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#ondeckERCC-modal{{$vanOnQueue->van_queue_id}}">BOARD PASSENGERS <i class="fa fa-arrow-circle-o-right"></i></button>

                <div class="modal" id="ondeckERCC-modal{{$vanOnQueue->van_queue_id}}">
                    <div class="modal-dialog" style="margin-top: 10%;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body">
                                <h1 class="text-center text-aqua"><i class="fa fa-exclamation-circle"></i> CONFIRMATION</h1>
                                <p class="text-center"><strong class="text-blue" style="font-size: 20px">{{$vanOnQueue->van->plate_number}}</strong> IS ON DECK AND HAS A REMARK OF <strong class="text-green" style="font-size: 20px">{{$vanOnQueue->remarks}}</strong>. THEREFORE IT CANNOT DEPART AND MUST BE MOVED TO THE SPECIAL UNITS</p>
                            </div>
                            <div class="modal-footer">
                                <div class="text-center">
                                    <button data-van="{{$vanOnQueue->van_queue_id}}" name="moveToSpecialUnits" type="button" class="btn btn-default"><i class="text-yellow fa fa-star"></i> MOVE TO SPECIAL UNITS</button>
                                    <button data-van="{{$vanOnQueue->van_queue_id}}" name="remainOnDeck" type="button" class="btn btn-primary ">REMOVE REMARK</button>
                                </div>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
        @else
                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#novan-modal{{$terminal->destination_id}}">BOARD PASSENGERS <i class="fa fa-arrow-circle-o-right"></i></button>
                <div class="modal" id="novan-modal{{$terminal->destination_id}}">
                  <div class="modal-dialog" style="margin-top: 10%;">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">×</span></button>
                              <h4 class="modal-title"></h4>
                          </div>
                          <div class="modal-body">
                              <h1 class="text-center text-danger"><i class="fa fa-ban"></i> NOT ALLOWED</h1>
                              <div class="padding-side-5">
                              <p class="text-center"><strong class="text-gray" style="font-size: 20px">UNABLE TO BOARD PASSENGERS BECAUSE THERE IS NO VAN ON DECK</strong></p>
                              </div>
                          </div>
                          <div class="modal-footer">
                              <div class="text-center">
                                  <button type="button" class="btn btn-default"  data-dismiss="modal" >CLOSE</button>
                              </div>
                          </div>
                      </div>
                      <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
        @endif
      </div>
    </div>
    {{-- Special Unit --}}
    <div id="special-unit" class="special-unit-heading">
        <h4><i class="fa fa-star"></i> SPECIAL UNITS</h4>
    </div>
    <div class="well scrollbar scrollbar-info  thin special-unit-body">
      <ol id='specialUnitList{{$terminal->destination_id}}' class="special-list">
          @foreach($terminal->vanQueue()->where('has_privilege',1)->whereNull('queue_number')->get() as $specializedVanOnQueue)
              <li>
            <span class="list-border">
                <div id="item-sp{{$specializedVanOnQueue->van_queue_id}}">
                    <div class="row">
                        <div class="col-xs-12">
                            <!--plate number here-->
                            {{$specializedVanOnQueue->van->plate_number}}
                            <div class="pull-right">
                                <!--remark here -->
                                <i class="badge badge-pill badge-default ">{{$specializedVanOnQueue->remarks}}</i>
                                <!--/ remark here -->
                                <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" style="border-radius: 100%;">
                                    <i class="fa fa-gear"></i>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <a name="ondeckBtn" data-val="{{$specializedVanOnQueue->van_queue_id}}" class="btn btn-menu btn-sm btn-flat btn-block">On Deck</a>
                                    <a name="deleteSpBtn" data-val="{{$specializedVanOnQueue->van_queue_id}}" class="btn btn-menu btn-sm btn-flat btn-block">Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="ondeck-sp{{$specializedVanOnQueue->van_queue_id}}" class="ondeck-sp hidden">
                    <div class="row">
                        <div class="col-xs-12">
                          <p>Are you sure you want <strong>{{$specializedVanOnQueue->van->plate_number}}</strong> to be on deck?</p>
                        </div>
                        <div class="col-xs-12">
                            <div class="pull-right">
                                <form name="formPutOnDeck" data-van="{{$specializedVanOnQueue->van_queue_id}}" action="{{route('vanqueue.putOnDeck',[$specializedVanOnQueue->van_queue_id])}}" method="POST">
                                    {{method_field('PATCH')}}
                                    {{csrf_field()}}
                                    <a class="btn btn-default btn-sm itemSpBtn" data-val="{{$specializedVanOnQueue->van_queue_id}}">NO</a>
                                    <button type="submit" class="btn btn-primary btn-sm">YES</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="delete-sp{{$specializedVanOnQueue->van_queue_id}}" class="delete-sp hidden">
                    <div class="row">
                        <div class="col-xs-12">
                          <p>Are you sure you want to <i class="text-red">delete</i> <strong>{{$specializedVanOnQueue->van->plate_number}}</strong>?</p>
                        </div>
                        <div class="col-xs-12">
                            <div class="pull-right">
                                <form name="deleteForm" data-van="{{$specializedVanOnQueue->van_queue_id}}" action="{{route("vanqueue.destroy",[$specializedVanOnQueue->van_queue_id])}}" method="POST">
                                     {{method_field('DELETE')}}
                                    {{csrf_field()}}
                                    <a class="btn btn-default btn-sm itemSpBtn" data-val="{{$specializedVanOnQueue->van_queue_id}}"> NO</a>
                                    <button type="submit" class="btn btn-danger btn-sm">YES</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </span>
              </li>
          @endforeach
      </ol>
    </div>
  </div>
</div>