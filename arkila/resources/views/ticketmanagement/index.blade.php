@extends('layouts.master') 
@section('title', 'List of Drivers') 
@section('content-header', 'List of Drivers') 
@section('content')
<div class="row">
        <div class="col-md-8">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#regular" data-toggle="tab">Regular Tickets</a></li>
              <li><a href="#discounted" data-toggle="tab">Discount Tickets</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="regular">
                <h4 class="text-center">REGULAR TICKETS</h4>
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th class="text-center">Destination</th>
                      <th class="text-center">Ticket Qty</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($routes as $route)
                    <tr>
                      <td class="text-center" style="width: 390px">{{$route->destination_name}}</td>
                        <td id="regViewQty{{$route->destination_id}}" class="text-right" style="width: 100px ">{{$route->number_of_tickets}}</td>
                        <td id="regViewAction{{$route->destination_id}}" style="width:200px">
                          <div class="text-center">
                            <button id="regEditBtn{{$route->destination_id}}" class="btn btn-primary btn-sm">ADD/REMOVE</button>
                          </div>
                        </td>
                        <td id="regEditQty{{$route->destination_id}}" class="hidden" style="width: 100px; background: #feeedb;" colspan="2">
                          <div class="col-md-6">
                            <input type="number" id="regEditInput{{$route->destination_id}}" class="form-control" min="0" step="1" value="{{$route->number_of_tickets}}">
                          </div>
                          <div class="col-md-6 text-center" style="margin-top: 4px">
                            <button id="regViewBtn{{$route->destination_id}}" class="btn btn-default btn-sm">CANCEL</button>
                            <button id="regSaveBtn{{$route->destination_id}}" name="regSaveBtn" data-val="{{$route->destination_id}}" class="btn btn-primary btn-sm">SAVE</button>
                          </div>
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="discounted">
                <h4 class="text-center">DISCOUNT TICKETS</h4>
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th class="text-center">Destination</th>
                      <th class="text-center">Ticket Qty</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($routes as $route)
                    <tr>
                      <td style="width: 390px">{{$route->destination_name}}</td>
                        <td id="discViewQty{{$route->destination_id}}" class="text-right" style="width: 100px ">{{$route->tickets->where('type', 'Discount')->count()}}</td>
                        <td id="discViewAction{{$route->destination_id}}" style="width:200px">
                          <div class="text-center">
                            <button id="discEditBtn{{$route->destination_id}}" class="btn btn-primary btn-sm">ADD/REMOVE</button>
                          </div>
                        </td>
                        <td id="discEditQty{{$route->destination_id}}" class="hidden" colspan="2" style="width: 100px; background: #feeedb;">
                          <div class="col-md-6">
                            <input type="number" class="form-control discInput" min="0" step="26" value="{{$route->tickets->where('type', 'Discount')->count()}}">
                          </div>
                          <div class="col-md-6 text-center" style="margin-top: 4px;">
                            <button id="discViewBtn{{$route->destination_id}}" class="btn btn-default btn-sm">CANCEL</button>
                            <button class="btn btn-primary btn-sm">SAVE</button>
                          </div>
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
      </div>
@endsection
@section('scripts') 
@parent
<script>
@foreach ($routes as $route)
  $(document).ready(function(){
    $("#regEditQty{{$route->destination_id}}").hide();
    $("#regEditBtn{{$route->destination_id}}").click(function(){
      $("#regEditQty{{$route->destination_id}}").show();
      $("#regViewQty{{$route->destination_id}}").hide();
      $("#regViewAction{{$route->destination_id}}").hide();
      $("#regEditQty{{$route->destination_id}}").removeClass("hidden");
    })
    $("#regViewBtn{{$route->destination_id}}").click(function(){
      $("#regViewQty{{$route->destination_id}}").show();
      $("#regViewAction{{$route->destination_id}}").show();
      $("#regEditQty{{$route->destination_id}}").hide();
    })
  });

  $(document).ready(function(){
    $("#discEditQty{{$route->destination_id}}").hide();
    $("#discEditBtn{{$route->destination_id}}").click(function(){
      $("#discEditQty{{$route->destination_id}}").show();
      $("#discViewQty{{$route->destination_id}}").hide();
      $("#discViewAction{{$route->destination_id}}").hide();
      $("#discEditQty{{$route->destination_id}}").removeClass("hidden");

    })
    $("#discViewBtn{{$route->destination_id}}").click(function(){
      $("#discViewQty{{$route->destination_id}}").show();
      $("#discViewAction{{$route->destination_id}}").show();
      $("#discEditQty{{$route->destination_id}}").hide();
    })
  });
@endforeach
  $(".discInput").keydown(function (e) {
    var key = e.keyCode || e.charCode;
    if (key == 8 || key == 46) {
        e.preventDefault();
        e.stopPropagation();
    }
  });

  $(".discInput").keypress(function (evt) {
    evt.preventDefault();
  });
</script>

<script>
    $(function() {
        $('#regulatTickets').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            'order': [[ 0, "desc" ]]
        });

        $('#discountTickets').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            'order': [[ 0, "desc" ]]
        });
    })

                $('button[name="regSaveBtn"]').on('click',function() {
                var quantityId = $(this).data('val');

                $.ajax( {
                        method:'PATCH',
                        url: '/home/ticket-management/'+quantityId,
                        data:
                            {
                                '_token': '{{csrf_token()}}',
                                'numberOfTicket' : $('#regEditInput'+quantityId).val()
                            },
                        success: function(response) {
                            new PNotify({
                                title: "Success!",
                                text: "Successfully update ticket",
                                animate: {
                                    animate: true,
                                    in_class: 'slideInDown',
                                    out_class: 'fadeOut'
                                },
                                animate_speed: 'fast',
                                nonblock: {
                                    nonblock: true
                                },
                                cornerclass: "",
                                width: "",
                                type: "success",
                                stack: {"dir1": "down", "dir2": "right", "push": "top", "spacing1": 0, "spacing2": 0}
                            });

                              $("#regViewQty" + quantityId).html(response)

                              $("#regViewQty" + quantityId).show();
                              $("#regViewAction" + quantityId).show();
                              $("#regEditQty" + quantityId).hide();
                        console.log(response);
                        }

                    });

               

            });

</script>

@stop