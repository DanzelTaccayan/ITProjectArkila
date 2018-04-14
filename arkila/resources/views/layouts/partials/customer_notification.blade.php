<button type="button" data-toggle="collapse" data-target="#style-switch" id="style-switch-button" class="btn btn-default hidden-xs hidden-sm" aria-expanded="true"><i class="fa fa-bell-o fa-2x"></i></button>
<div id="style-switch" class="collapse" style="">
  <div class="list-group">
    <div class="list-group-header">
      <h4 class="text-center">NOTIFICATIONS</h4>
    </div>
    {{Auth::user()->unreadNotifications}}
    @foreach(auth()->user()->unreadNotifications as $notification)
    <a href="" class="list-group-item">
          <p><span class="text-green fa fa-check-circle"></span> Accepted {{$notification->type}} </p>
          <small>10/10/2018 01:00 PM</small>
    </a>

    @endforeach
    <!-- <a href="" class="list-group-item">
      <p><span class="text-red fa fa-times-circle"></span> Deleted/Cancelled</p>
      <small>10/10/2018 01:00 PM</small>
    </a>
    <a href="" class="list-group-item">
      <p><span class="text-blue fa fa-info-circle"></span> Information </p>
      <small>10/10/2018 01:00 PM</small>
    </a>
    <a href="" class="list-group-item">
      <p><span class="text-yellow fa fa-truck"></span> Departed </p>
      <small>10/10/2018 01:00 PM</small>
    </a> -->
  </div>
</div>
