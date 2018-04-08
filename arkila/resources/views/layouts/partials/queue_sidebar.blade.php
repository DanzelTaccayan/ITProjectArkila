<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li class="active"><a href="#control-sidebar-queue-tab" data-toggle="tab"><i class="fa fa-list-ol"></i></a></li>
        <li><a href="#control-sidebar-remarked-tab" data-toggle="tab"><i class="fa fa-ticket text-yellow"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
      <div class="tab-pane active" id="control-sidebar-queue-tab">
        <h3 class="">Add Unit to Queue</h3>
        <div class="form-group">
            <label for="">Van Unit</label>
            <select @if(count($vansSideBar) <= 0 && count($terminalsSideBar) <= 0 && count($driversSideBar) <= 0) {{'disabled'}} @endif  id="vanInputSideBar" class="form-control select2">
                @if(count($vansSideBar) > 0)
                    @foreach ($vansSideBar as $vanSideBar)
                        <option value="{{$vanSideBar->plate_number}}">{{ $vanSideBar->plate_number }}</option>
                    @endforeach
                @else
                    <option value=""> No Available Van Units</option>
                @endif
            </select>
        </div>
        <div class="form-group">
            <label for="">Destination</label>
            <select @if(count($vansSideBar) <= 0 && count($terminalsSideBar) <= 0 && count($driversSideBar) <= 0) {{'disabled'}} @endif id="destinationInputSideBar" class="form-control">
                @if(count($terminalsSideBar) > 0)
                    @foreach ($terminalsSideBar as $terminalSideBar)
                        <option value="{{$terminalSideBar->terminal_id}}">{{ $terminalSideBar->description }}</option>
                    @endforeach
                @else
                    <option value=""> No Available Destination</option>
                @endif

            </select>
        </div>
        <div class="form-group">
            <label for="">Driver</label>
            <select @if(count($vansSideBar) <= 0 && count($terminalsSideBar) <= 0 && count($driversSideBar) <= 0) {{'disabled'}} @endif name="driver" id="driverInputSideBar" class="form-control select2">
                @if(count($driversSideBar) > 0 )
                    @foreach ($driversSideBar as $driverSideBar)
                        <option value="{{$driverSideBar->member_id}}">{{ $driverSideBar->full_name }}</option>
                    @endforeach
                @else
                    <option value=""> No Available Driver</option>
                @endif
            </select>
        </div>
        <div class="pull-right">
            @if(count($vansSideBar) > 0 && count($terminalsSideBar) > 0 && count($driversSideBar) > 0)
                <button  id='addQueueSideBarButt' type=submit class="btn btn-primary btn-sm" ><i class="fa fa-plus"></i> ADD </button>
            @else
                <button  class="btn btn-primary btn-sm" title="Please add vans, destinations, or drivers before adding a van to the queue" disabled><i class="fa fa-plus"></i> ADD </button>
            @endif
        </div>
      </div>
        <!-- /.tab-pane -->
        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
        <!-- /.tab-pane -->
        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-remarked-tab">
        <h3 class="">Sell Ticket</h3>
        <div class="form-group">
          <label for="">Terminal</label>
            <select id="terminalTicketSideBar" class="form-control">
                @php $counterTicketSideBar = 0; @endphp
                @foreach($terminalsTicketSideBar as $terminalTicketSideBar)
                    @if($terminalTicketSideBar->trips->where('queue_number',1)->first()->plate_number ?? null)
                        @php $counterTicketSideBar++; @endphp
                        <option value="{{$terminalTicketSideBar->terminal_id}}">{{$terminalTicketSideBar->description}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="form-group">
          <label for="">Destination</label>
            <select id="destinationTicketSideBar" class="form-control"></select>
        </div>
        <div class="form-group">
          <label for="">Discount</label>
          <div class="input-group">
            <span class="input-group-addon">
              <input id="checkDiscountTicketSideBar" type="checkbox">
            </span>
            <select id="discountTicketSideBar" class="form-control"></select>
          </div>
        </div>
        <div class="form-group">
          <label for="">Ticket</label>
          <select id="ticketSellSideBar" class="form-control select2" multiple="multiple" data-placeholder="Select Ticket">
          </select>
        </div>
          <div id="sellButtContainerSideBar" class="pull-right">
              <button type="button" class="btn btn-primary btn-sm" @if($counterTicketSideBar) title="Please add atleast one destination for the specified terminal on the terminal field" @else title="Please Add a van from the queue to start selling tickets" @endif disabled>SELL</button>
          </div>
        </div>
        <!-- /.tab-pane -->
    </div>
</aside>
<div class="control-sidebar-bg"></div>