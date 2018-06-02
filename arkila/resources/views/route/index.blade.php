@extends('layouts.master') 
@section('title', 'Terminals and Routes') 
@section('links')
@parent

@endsection
@section('content')

@if($terminals->count() == 0)
<div class="padding-side-5">
    <div class="padding-side-10">
        <div class="box box-solid" style="height: 300px; padding: 50px;">
          <div class="box-body">
              <div class="text-center">
                <h1>NO TERMINAL/DESTINATION FOUND.</h1>
                <a href="{{route('terminalCreate.create')}}" class="btn btn-success btn-flat btn-lg">CREATE TERMINAL</a>
            </div>
          </div>
        </div>
    </div>
</div>
@else
<div class="row">
    <div class="col-md-3">
        <div class="box box-solid">
            <div class="box-body">
                <h3>ROUTES</h3>
                <div style="height:300px; overflow-y: scroll;" class="scrollbar-info thin">
                    <ul class="nav nav-stacked" style="padding-right:5px;">
                    @foreach ($terminals as $terminal)
                        <li class="@if($terminals->first() == $terminal){{'active'}}@endif"><a href="#terminal{{$terminal->destination_id}}" style="background: #f6f6f6; margin-bottom: 3px;" data-toggle="tab">{{strtoupper($mainTerminal->destination_name)}} <i class="fa fa-long-arrow-right"></i> {{strtoupper($terminal->destination_name)}}<span class="badge badge-pill bg-aqua pull-right" style="margin-top: 1%;">{{count($terminal->routeFromDestination)}}</span></a></li>
                    @endforeach
                    </ul>
                </div>
            </div>
            <div class="box-footer">
                <a href="{{route('terminalCreate.create')}}" class="btn btn-block bg-maroon btn-flat"> <i class="fa fa-plus"></i> ADD TERMINAL DESTINATION</a>
            </div>
        </div>
    </div>
    <div class="col-md-9"> 
        <div class="nav-tabs-custom">
            <div class="tab-content">
                @foreach ($terminals as $terminal)
                <div class="tab-pane @if($terminals->first() == $terminal){{'active'}}@endif" id="terminal{{$terminal->destination_id}}">
                    <div class="box box-solid" style="height: 550px;">
                        <div class="box-header">
                            <h3 class="" style="padding: 10px 0px 10px 0px; border-bottom: 1px solid lightgray;"><strong class="fa fa-map-marker text-red"></strong> {{strtoupper($mainTerminal->first()->destination_name)}} <i class="fa fa-long-arrow-right"></i> {{strtoupper($terminal->destination_name)}}<small> LIST OF DESTINATIONS</small></h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <div class="col-md-6">
                                    <a href="{{route('route.create')}}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-plus"></i> ADD DESTINATION</a>
                                </div>
                                <table id="van" class="table table-bordered table-striped table-responsive datatablesRoute">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Regular Fee</th>
                                            <th>Discounted Fee</th>  
                                            <th>Regular Tickets</th>
                                            <th>Discounted Tickets</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($terminal->routeFromDestination as $routes)
                                          <tr>
                                            <td>{{$routes->destination_name}}</td>
                                            @foreach($fareReg->where('destination_id', $routes->destination_id) as $regular)
                                            <td class="text-right">{{$regular->fare}}</td>
                                            @endforeach
                                            @foreach($fareDis->where('destination_id', $routes->destination_id) as $discounted)
                                            <td class="text-right">{{$discounted->fare}}</td>
                                            @endforeach
                                            <td class="text-right">{{$routes->number_of_tickets}}</td>
                                            <td class="text-right">{{$routes->tickets->where('type', 'Discount')->count()}}</td>
                                            <td>
                                                <div class="text-center">
                                                    <a href="{{route('route.edit', [$routes->destination_id])}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>EDIT</a>
                                                    <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#{{'route'.$routes->destination_id}}"><i class="fa fa-trash"></i> DELETE</button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @foreach($terminal->routeFromDestination as $routes)
                        <div class="modal" id="{{'route'.$routes->destination_id}}">
                            <div class="modal-dialog" style="margin-top: 10%;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span></button>
                                        <h4 class="modal-title"></h4>
                                    </div>
                                    <div class="modal-body">
                                        <h1 class="text-center text-red"><i class="fa fa-trash"></i> DELETE</h1>
                                        <p class="text-center">ARE YOU SURE YOU WANT TO DELETE</p>             
                                        <h4 class="text-center "><strong class="text-red">{{$routes->destination_name}}</strong>?</h4>
                                    </div>
                                    <div class="modal-footer">
                                        <form method="POST" action="{{route('route.destroy', [$routes->destination_id])}}">
                                            {{csrf_field()}}
                                            {{method_field('DELETE')}}
                                            <div class="text-center">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                                                <button type="submit" class="btn btn-danger">DELETE</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div> 
@endif
@endsection
@section('scripts') 
@parent
<script>
$(function(){
 var url = window.location.href;
 var activeTab = document.location.hash;

 if(!activeTab){
        activeTab = @if($terminals->first()->destination_id ?? null)
            "{{'#terminal'.$terminals->first()->destination_id}}";
    @else
            "{{''}}";
    @endif
}
 
 $
 $(".tab-pane").removeClass("active in"); 
 $(".tab-menu").removeClass("active in"); 
 $(activeTab).addClass("active");
 $(activeTab + "-menu").addClass("active");

 $('a[href="#'+ activeTab +'"]').tab('show');
 window.location.hash = activeTab;

});

$(function(){
  var hash = window.location.hash;
  hash && $('ul.nav a[href="' + hash + '"]').tab('show');

  $('.nav-stacked a').click(function (e) {
  $(this).tab('show');
  var scrollmem = $('body').scrollTop() || $('html').scrollTop();
  window.location.hash = this.hash;
  $('html,body').scrollTop(scrollmem);
  });
});
</script>
<!-- DataTables -->
<script src="{{ URL::asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
    $(function() {
        $('.datatablesRoute').DataTable({
            'pageLength': 5,
            'paging': true,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': true,
            'order': [[ 1, "desc" ]],
            'aoColumnDefs': [{
                'bSortable': false,
                'aTargets': [-1] /* 1st one, start by the right */
            }]
        })
    
    });

</script>

@endsection