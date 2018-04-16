<div id="home-slider" class="carousel slide box-trip" data-ride="carousel">
    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        <div class="item  active">
            <div class="box">
                <div class="box-header with-border text-center">
                    <h4 class="title-limit">{{$announcements->first()->title}}</h4>
                </div>
                <div class="box-body text-center" style="height:200px;">
                    <div style="width:70%; margin-left:15%;">
                        <p class="text-limit-8">{{$announcements->first()->description}}</p>
                    </div>
                </div>
                <div class="box-footer text-center">
                    <button type="button" class="see-more btn btn-primary" data-toggle="modal" data-target="#seeMoreAnnouncements" data-title="{{$announcements->first()->title}}" data-announcement="{{$announcements->first()->description}}">See more</button>
                </div>
            </div>
        </div>
        @foreach($announcements as $announcement) @if($announcement == $announcements->first()) @continue @else
        <div class="item">
            <div class="box">
                <div class="box-header with-border text-center">
                    <h4 class="title-limit-5">{{$announcement->title}}</h4>
                </div>
                <div class="box-body text-center" style="height:200px;">
                    <div style="width:70%; margin-left:15%;">
                        <p  class="text-limit-8">{{$announcement->description}}</p>
                    </div>
                </div>
                <div class="box-footer text-center">
                    <button type="button" class="see-more btn btn-primary" data-toggle="modal" data-target="#seeMoreAnnouncements" data-title="{{$announcement->title}}" data-announcement="{{$announcement->description}}">See more</button>
                </div>
            </div>
        </div>
        @endif @endforeach
    </div>
    <!-- /.carousel-inner -->
</div>
<!-- /.home-slider -->
<!-- Controls -->
<a class="left carousel-control" href="#home-slider" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left text-blue" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
</a>
<a class="right carousel-control" href="#home-slider" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right text-blue" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
</a>

<!--See More Announcements Modal-->
<div class="modal fade" id="seeMoreAnnouncements">
    <div class="modal-dialog modal-lg" style="margin-top:20%">
        <div class="col-md-offset-2 col-md-8">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                    <h4 class="announcement-title"></h4>
                </div>
                <!-- /.modal-header -->
                <div class="modal-body row" style="margin: 0% 1%;">
                    <p class="announcement-body" style="font-size: 110%; text-align: justify;"></p>
                </div>
                <!-- /.modal-body -->
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                    
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
    $(".see-more").click(function() {
        $(".announcement-title").text($(this).data("title"));
        $(".announcement-body").text($(this).data("announcement"));
    });
</script>