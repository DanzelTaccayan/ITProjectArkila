@extends('layouts.master') 
@section('title', 'Manage Tickets') 
@section('content-header', 'List of Drivers') 
@section('content')
<div class="row">
  <div class="col-md-12">
    <div>
        <h2 class="text-white">DESTINATION TICKETS MANAGEMENT</h2>
    </div>
  </div>
</div>
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
                <table id="regularTickets" class="table table-bordered table-striped ticketTable">
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
                            <input type="number" id="regEditInput{{$route->destination_id}}" class="form-control" min="0" step="1" value="{{$route->number_of_tickets}}" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
                          </div>
                          <div class="col-md-6 text-center" style="margin-top: 4px">
                            <button id="regViewBtn{{$route->destination_id}}" class="btn btn-default btn-sm">CANCEL</button>
                            <button id="regSaveBtn{{$route->destination_id}}" name="regSaveBtn" data-val="{{$route->destination_id}}" data-dest="{{$route->destination_name}}" class="btn btn-primary btn-sm">SAVE</button>
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
                <table id="discountTickets" class="table table-bordered table-striped ticketTable">
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
                      <td  class="text-center" style="width: 390px">{{$route->destination_name}}</td>
                        <td id="discViewQty{{$route->destination_id}}" class="text-right" style="width: 100px ">{{$route->tickets->where('type', 'Discount')->count()}}</td>
                        <td id="discViewAction{{$route->destination_id}}" style="width:200px">
                          <div class="text-center">
                            <button id="discEditBtn{{$route->destination_id}}" class="btn btn-primary btn-sm">ADD/REMOVE</button>
                          </div>
                        </td>
                        <td id="discEditQty{{$route->destination_id}}" class="hidden" colspan="2" style="width: 100px; background: #feeedb;">
                          <div class="col-md-6">
                            <input type="number" id="disEditInput{{$route->destination_id}}" class="form-control discInput" min="26" step="26" value="{{$route->tickets->where('type', 'Discount')->count()}}" required>
                          </div>
                          <div class="col-md-6 text-center" style="margin-top: 4px;">
                            <button id="discViewBtn{{$route->destination_id}}" class="btn btn-default btn-sm">CANCEL</button>
                            <button id="disSaveBtn{{$route->destination_id}}" name="disSaveBtn" data-val="{{$route->destination_id}}" class="btn btn-primary btn-sm">SAVE</button>
                          </div>
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <p><strong>NOTE:</strong> Make sure that all tickets have been returned before editing the number of tickets of a specific route.</p>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
  </div>
  <form action="{{route('ticket.rule')}}" method="POST">
  {{csrf_field()}}
  <div class="col-md-4">
    <div class="box box-solid">
      <div class="box-body">
        <table class="table table-striped table-bordered">
          <tbody>
            <tr>
              <th class="text-center" style="width: 35%;">Ticket Expiry</th>
                <td style="width: 55%;" class="viewExpiry">
                  @if($ticketRule)
                    @if($ticketRule->first()->usable_days == 0)
                    No expiry
                    @else
                    {{$ticketRule->first()->usable_days}} day after ticket sold
                    @endif
                  @else
                    No expiry
                  @endif
                </td>
                <td style="width: 15%;" class="viewExpiry">
                  <div class="text-center">
                    <button type="button" id="editExpiryBtn" class="btn btn-primary btn-sm">EDIT</button>
                  </div>
                </td>
              <td id="editExpiry" class="hidden" colspan="2">
                <select name="ticketExpiry" id="" class="form-control">
                  <option value="0"@if(!$ticketRule){{'selected'}} @elseif($ticketRule->usable_days == 0)@endif>No expiry</option>
                  <option value="1"@if($ticketRule) @if($ticketRule->usable_days == 1) {{'selected'}} @endif @endif>1 day after ticket has sold</option>
                  <option value="2"@if($ticketRule) @if($ticketRule->usable_days == 2) {{'selected'}} @endif @endif>2 days after ticket has sold</option>
                  <option value="3"@if($ticketRule) @if($ticketRule->usable_days == 3) {{'selected'}} @endif @endif>3 days after ticket has sold</option>
                  <option value="4"@if($ticketRule) @if($ticketRule->usable_days == 4) {{'selected'}} @endif @endif>4 days after ticket has sold</option>
                  <option value="5"@if($ticketRule) @if($ticketRule->usable_days == 5) {{'selected'}} @endif @endif>5 days after ticket has sold</option>
                  <option value="6"@if($ticketRule) @if($ticketRule->usable_days == 6) {{'selected'}} @endif @endif>6 days after ticket has sold</option>
                  <option value="7"@if($ticketRule) @if($ticketRule->usable_days == 7) {{'selected'}} @endif @endif>7 days after ticket has sold</option>
                </select>
                <div class="pull-right"  style="margin-top: 7%;">
                  <button type="button" id="viewExpiryBtn" class="btn btn-default btn-sm">CANCEL</button>
                  <button type="submit" id="saveExpiryBtn" class="btn btn-success btn-sm">SAVE</button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</form>  
</div>
@endsection
@section('scripts') 
@parent
<script>
$(document).ready(function () {
  $("#editExpiry").hide();
  $("#editExpiryBtn").click(function(){
    $("#editExpiry").show();
    $("#editExpiry").removeClass("hidden");
    $(".viewExpiry").hide();
  })
  $("#viewExpiryBtn").click(function(){
    $("#editExpiry").hide();
    $(".viewExpiry").show();
  })
});

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
              $('button[name="regSaveBtn"]').on('click',function() {
                var quantityId = $(this).data('val');
                var destName = $(this).data('dest');

                $.ajax( {
                        method:'PATCH',
                        url: '/home/ticket-management/'+quantityId,
                        data:
                            {
                                '_token': '{{csrf_token()}}',
                                'numberOfTicket' : $('#regEditInput'+quantityId).val()
                            },
                        success: function(response) {
                          if(response.success){
                              new PNotify({
                                title: "Success!",
                                text: response.success,
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
                              
                              
                            }else if(response.error){
                              $.notify({
                                  // options
                                  icon: 'fa fa-warning',
                                  message: response.error
                                },{
                                  // settings
                                  type: 'danger',
                                  delay: '999900',
                                  placement: {
                                    from: 'bottom',
                                    align: 'right'
                                  },
                                  icon_type: 'class',
                                  animate: {
                                    enter: 'animated bounceIn',
                                    exit: 'animated bounceOut'
                                  }
                                });
                            }
                              $("#regViewQty" + quantityId).show();
                              $("#regViewAction" + quantityId).show();
                              $("#regEditQty" + quantityId).hide();
                              $("#regViewQty" + quantityId).html(response.ticketqty)
                        },

                    });

               

            });
            $('button[name="disSaveBtn"]').on('click',function() {
                var quantityDisId = $(this).data('val');

                $.ajax( {
                        method:'PATCH',
                        url: '/home/ticket-management/'+quantityDisId+'/updateDiscount',
                        data:
                            {
                                '_token': '{{csrf_token()}}',
                                'numberOfTicket' : parseInt($('#disEditInput'+quantityDisId).val())
                            },
                        success: function(response) {
                            if(response.success){
                              new PNotify({
                                title: "Success!",
                                text: response.success,
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
                            }else if(response.error){
                              $.notify({
                                  // options
                                  icon: 'fa fa-warning',
                                  message: response.error
                                },{
                                  // settings
                                  type: 'danger',
                                  delay: '999900',
                                  placement: {
                                    from: 'bottom',
                                    align: 'right'
                                  },
                                  icon_type: 'class',
                                  animate: {
                                    enter: 'animated bounceIn',
                                    exit: 'animated bounceOut'
                                  }
                                });
                            }
                              $("#discViewQty" + quantityDisId).html(response.ticketqty)

                              $("#discViewQty" + quantityDisId).show();
                              $("#discViewAction" + quantityDisId).show();
                              $("#discEditQty" + quantityDisId).hide();
                        console.log(response);
                        }
                        
                    });

               

            });

  $(function() {
        $('.ticketTable').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': true
        });
    })
</script>

@stop