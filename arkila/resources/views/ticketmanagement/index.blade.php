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
                    <tr>
                      <td style="width: 390px">Destination Reg 1</td>
                        <td id="regViewQty" class="text-right" style="width: 100px ">100</td>
                        <td id="regViewAction" style="width:200px">
                          <div class="text-center">
                            <button id="regEditBtn" class="btn btn-primary btn-sm">ADD/REMOVE</button>
                          </div>
                        </td>
                        <td id="regEditQty" style="width: 100px; background: #feeedb;" colspan="2">
                          <div class="col-md-6">
                            <input type="number" class="form-control" min="0" step="1">
                          </div>
                          <div class="col-md-6 text-center" style="margin-top: 4px">
                            <button id="regViewBtn" class="btn btn-default btn-sm">CANCEL</button>
                            <button class="btn btn-primary btn-sm">SAVE</button>
                          </div>
                        </td><!-- 
                        <td id="regEditAction" style="width:200px">
                          <div class="text-center">
                            <button class="btn btn-primary btn-sm">SAVE</button>
                            <button id="regViewBtn" class="btn btn-default btn-sm">CANCEL</button>
                          </div>
                        </td> -->
                    </tr>
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
                    <tr>
                      <td style="width: 390px">Destination Disc 1</td>
                        <td id="discViewQty" class="text-right" style="width: 100px ">24</td>
                        <td id="discViewAction" style="width:200px">
                          <div class="text-center">
                            <button id="discEditBtn" class="btn btn-primary btn-sm">ADD/REMOVE</button>
                          </div>
                        </td>
                        <td id="discEditQty" colspan="2" style="width: 100px; background: #feeedb;">
                          <div class="col-md-6">
                            <input type="number" class="form-control discInput" min="0" step="24">
                          </div>
                          <div class="col-md-6 text-center" style="margin-top: 4px;">
                            <button id="discViewBtn" class="btn btn-default btn-sm">CANCEL</button>
                            <button class="btn btn-primary btn-sm">SAVE</button>
                          </div>
                        </td>
                    </tr>
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
</script>

@stop