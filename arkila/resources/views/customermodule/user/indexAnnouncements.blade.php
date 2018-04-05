<div id="accordion" class="mb-5">
  @if($announcements->count() > 0)
    @foreach($announcements as $announcement)
    <div class="card" style="background-color: #f1faa1;">
        <div id="AnnouncementHead{{$announcement->announcement_id}}" class="card-header">
            <h5 class="mb-0"><a data-toggle="collapse" href="#AnnouncementBody{{$announcement->announcement_id}}" aria-expanded="true">{{$announcement->title}}</a></h5>
        </div>
        <div id="AnnouncementBody{{$announcement->announcement_id}}" data-parent="#accordion" class="collapse">
            <div class="card-body">
                <p>{{$announcement->description}}</p>
            </div>
        </div>
    </div>
    @endforeach
    <a href="{{route('customermodule.user.indexAllAnnouncements')}}" class="btn btn-default">View All Announcements</a>
  @else
    <p>There are no announcements as of now</p>
  @endif
</div>
