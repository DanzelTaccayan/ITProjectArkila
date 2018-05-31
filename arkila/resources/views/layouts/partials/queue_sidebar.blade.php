
<aside class="control-sidebar control-sidebar-dark" style="overflow-y: hidden">
    <div style="padding: 10px 0px 10px 0px;">
        <h3 class="text-center" style="background: black">VAN QUEUE</h3>
    </div>   
    <div style="padding: 0px 10px 0px 10px;">
    <!-- Tab panes -->
        <div id="home-slider" class="carousel box-trip" data-interval="false">
        <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                @foreach($terminalsSideBar as $terminalSidebar)
                <div class="item  @if($terminalsSideBar->first() === $terminalSidebar) active @endif">
                    <h4><i class="fa fa-home"></i> {{$terminalSidebar->destination_name}}</h4>
                    <div class="sidequeue-body"> 
                        <div class="sidequeue-body-color scrollbar scrollbar-info thin">
                            @if($terminalSidebar->vanQueue()->whereNotNull('queue_number')->count() == 0)
                                <h2 class="text-center">NO VAN FOUND ON QUEUE.</h2>
                            @else
                            <ol id ="queue" class="sidequeue-list sidequeue-ol">
                                @foreach($terminalSidebar->vanQueue()->whereNotNull('queue_number')->orderBy('queue_number','asc')->get() as $vanSideBar)
                                <li id="unit" data-vanid="" class="form-horizontal">
                                    <span id="trip" class="list-border">
                                        <div class="sidequeuenum">
                                            <p name="queueIndicator" id="queue">{{$vanSideBar->queue_number}}</p>
                                        </div>
                                        <div class=item id="item">
                                            <div  class="row">
                                                <div class="col-md-12">
                                                    <p class="hidden"></p>
                                                    {{$vanSideBar->van->plate_number}}
                                                    <div class="pull-right">
                                                        <i id="badge" class="badge badge-pill badge-default">{{$vanSideBar->remarks}}</i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </span>
                                </li>
                                @endforeach
                            </ol>
                            @endif
                        </div>
                    </div>
                </div>
               @endforeach
            </div>
        <!-- /.carousel-inner -->
        </div>
        <a href="{{route('vanqueue.index')}}" class="btn btn-success btn-sm btn-flat">GO TO VAN QUEUE PAGE</a>

        <div class="pull-right">
            <a class="previous round step-btn" href="#home-slider" role="button" data-slide="prev" tabindex="-1">
                <i class="fa fa-chevron-left"></i>
                <span class="sr-only">Previous</span>
            </a>
            <a class="next round step-btn" href="#home-slider" role="button" data-slide="next" tabindex="-1">
                <i class="fa fa-chevron-right"></i>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <div class="clearfix"></div>
    </div>
<!-- /.home-slider -->

</aside>
<div class="control-sidebar-bg"></div>