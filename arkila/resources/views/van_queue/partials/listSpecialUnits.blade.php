@foreach($queue as $specializedVanOnQueue)
    <li>
                                    <span class="list-border">
                                        <div id="item-sp1">
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
                                                            <a id="ondeckBtn1" class="btn btn-menu btn-sm btn-flat btn-block">On Deck</a>
                                                            <a id="deleteSpBtn1" class="btn btn-menu btn-sm btn-flat btn-block">Remove</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="ondeck-sp1" class="hidden">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                  <p>Are you sure you want {{$specializedVanOnQueue->van->plate_number}} to be on deck?</p>
                                                </div>
                                                <div class="col-xs-12">
                                                    <div class="pull-right">
                                                        <form action="" method="POST">
                                                            {{method_field('PATCH')}}
                                                            {{csrf_field()}}
                                                            <a class="btn btn-default btn-xs itemSpBtn1">NO</a>
                                                            <button type="submit" class="btn btn-primary btn-xs">YES</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="delete-sp1" class="hidden">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                  <p>Are you sure you want to <i class="text-red">delete</i> <strong>{{$specializedVanOnQueue->van->plate_number}}</strong>?</p>
                                                </div>
                                                <div class="col-xs-12">
                                                    <div class="pull-right">
                                                        <form method="POST" action="">
                                                             {{method_field('DELETE')}}
                                                            {{csrf_field()}}
                                                            <a class="btn btn-default btn-xs itemSpBtn1"> NO</a>
                                                            <button class="btn btn-danger btn-xs">YES</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </span>
    </li>
@endforeach