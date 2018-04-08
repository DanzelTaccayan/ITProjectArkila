@extends('layouts.driver') 
@section('title', 'Driver Home') 
@section('content-title', 'Driver Home') 
@section('content')
<div id="announcements" class="col-md-6">
</div>
<div id="van-queue" class="col-md-6">
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