@extends('layouts.driver') 
@section('title', 'Driver Home') 
@section('content-title', 'Driver Home') 
@section('content')
<div class="row">
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
        <span class="info-box-icon bg-red"><i class="fa fa-automobile"></i></span>
        <div class="info-box-content">
          <h4 style="margin: 0;"><strong>AAA</strong></h4>
          <p style="margin: 0;">HIACE</p>
          <p style="color: gray;">12 seats</p>
        </div>
        <!-- /.info-box-content -->
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-maroon"><i class="fa fa-list-ol"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">CURRENT POSITION IN QUEUE:</span>
        <span class="info-box-number" style="font-size:25px; margin-top:10px;"># 1</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    <div class="info-box">
      <span class="info-box-icon bg-maroon"><i class="fa fa-list-ol"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">CURRENT POSITION IN QUEUE:</span>
        <span class="info-box-number" style=" margin-top:10px;">NOT LISTED</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
</div>
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