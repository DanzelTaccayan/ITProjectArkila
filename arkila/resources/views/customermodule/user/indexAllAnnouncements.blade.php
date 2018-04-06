@extends('layouts.customer_user') @section('content')
<section class="mainSection">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div id="accordionThree" class="mb-5">
              @foreach($announcements as $announcement)
                <div class="card card-primary">
                    <div id="AnnouncementHead{{$announcement->announcement_id}}" class="card-header">
                        <h5 class="mb-0"><a data-toggle="collapse" href="#AnnouncementBody{{$announcement->announcement_id}}" aria-expanded="true"><strong style="color:black;">{{$announcement->title}}</strong></a></h5>
                    </div>
                    <div id="AnnouncementBody{{$announcement->announcement_id}}" data-parent="#accordionThree" class="collapse show">
                        <div class="card-body">
                            <p>{{$announcement->description}}</p>
                        </div>
                    </div>
                </div>
              @endforeach
            </div>
        </div>
        <!-- col-->
    </div>
    <!-- row-->
</section>
<!--    main section-->
@stop
