@extends('layouts.driver') 
@section('title', 'Driver Home') 
@section('content-title', 'Driver Home') 
@section('content')
<div class="">
<div class="container mx-auto">

  <div class="row">
    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-red"><i class="fa fa-automobile"></i></span>
        <div class="info-box-content">
            @if (auth()->user()->member->van->count() == 1)
            <h4 style="margin: 0;"><strong>{{auth()->user()->member->van->first()->plate_number ?? 'None'}}</strong></h4>
            <p style="margin: 0;">{{auth()->user()->member->van->first()->model->description  ?? 'None'}}</p>
            <p style="color: gray;">{{auth()->user()->member->van->first()->seating_capacity  ?? 'None'}} seats</p>
            @else
            <h4 style="margin: 0;"><strong>No Van</strong></h4>
            @endif
          </div>
          <!-- /.info-box-content -->
      </div>
    </div>
    @if (auth()->user()->member->van->count() == 1)
    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-maroon"><i class="fa fa-list-ol"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">ON QUEUE:</span>
          @if($queueNumber !== null)
          <span class="info-box-number" style="font-size:25px; margin-top:10px;">#{{auth()->user()->member->van->first()->vanQueue->first()->queue_number}}</span>
          @else
          <span class="info-box-number" style=" margin-top:10px;">NOT LISTED</span>
          @endif
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      @endif
    </div>
    @if($queueNumber !== null)
    @if(auth()->user()->member->van->first()->vanQueue->first()->driver_id !== auth()->user()->member->member_id)
    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>

        <div class="info-box-content">
          
          <span class="info-box-text">SUBSTITUTE DRIVER:</span>
          <span class="info-box-number" style="margin-top:10px;">{{auth()->user()->member->van->first()->vanQueue->first()->driver->full_name}}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
  @endif
  @endif
  </div>

  <div class="mx-auto">
    <div id="" class="padding-side-5">
    <hr>
<h2 class="text-center">ANNOUNCEMENTS</h2>
@if($announcements->count() == 0)
<div class=" box box-solid">
  <div class="box-body">
    <h4 class="text-center" style="margin: 5% 0% 5% 0%;">NO ANNOUNCEMENTS.</h4>
  </div>
</div>
@else
<div id="home-slider" class="carousel slide box-trip" data-ride="carousel">
    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">  
        @foreach($announcements as $announcement) 
        <div class="item @if($announcements->first() == $announcement){{'active'}}@endif">
            <div class="box box-solid">
                <div class="box-header with-border bg-aqua" style="height:100px;">
                    <h4 class="text-limit-2" style="text-align: center;">{{$announcement->title}}</h4>
                    <h5 class="text-center"><i class="fa fa-calendar"></i> {{$announcement->created_at->formatLocalized('%B %d %Y')}}</h5>
                </div>
                <div class="box-body text-center" style="height:200px;">
                    <div>
                        <p  class="text-limit-8">{{$announcement->description}}</p>
                    </div>
                </div>
                <div class="box-footer text-center">
                    <button type="button" class="see-more btn btn-primary" data-toggle="modal" data-target="#{{'seeMoreAnnouncements'.$announcement->announcement_id}}">See more</button>
                </div>
            </div>
        </div>
        <div class="modal fade" id="{{'seeMoreAnnouncements'.$announcement->announcement_id}}">
          <div class="modal-dialog modal-lg" style="margin-top:15%">
              <div class="col-md-offset-2 col-md-8">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                          <h4 class="text-center"><strong>{{$announcement->title}}</strong></h4>
                          <h5 class="text-center"><i class="fa fa-calendar"></i> {{$announcement->created_at->formatLocalized('%B %d %Y')}}</h5>
                      </div>
                      <!-- /.modal-header -->
                      <div class="modal-body row" style="margin: 0% 1%;">
                          <p class="" style="font-size: 110%; text-align: justify;">{{$announcement->description}}</p>
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
      @endforeach
    </div>
    <!-- /.carousel-inner -->
</div>
<!-- /.home-slider -->
<!-- Controls -->
<div class="text-center">
  <a class="round btn btn-default btn-lg text-white" href="#home-slider" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left text-blue" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
  </a>
  <a class="round btn btn-default btn-lg" href="#home-slider" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right text-blue" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
  </a>
</div>
@endif

<!--See More Announcements Modal-->

<!-- /.modal -->
    </div>
  </div>
</div>
</div>

@endsection
@section('scripts')
@parent
<script type="text/javascript">
$(document).ready(function(){
  $("#announcements").load("{{route('drivermodule.indexAnnouncements')}}");
  $("#van-queue").load("{{route('drivermodule.vanQueue')}}");
});

</script>
<script>
  $(function() {

        $('.queueTable').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': true
        })
    })
</script>
@endsection