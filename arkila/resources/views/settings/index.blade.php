@extends('layouts.master')
@section('title', 'Settings')
@section('content')

<div class="row">
    <div class="col-md-4">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Advanced Features</h3>
                <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body no-padding">
                <ul class="nav nav-pills nav-stacked">
                  @foreach($features as $feature)
                    <li>
                        <a href="#">
                            {{$feature->description}}
                            <span class="label pull-right">
                                <label class="switch">
                                    <input type="checkbox" class="features" data-featureid="{{$feature->id}}" @if($feature->Status == 'enable') {{'checked'}} @endif>
                                    <span class="slider round"></span>
                                </label>
                            </span>
                        </a>
                    </li>
                  @endforeach
                </ul>
            </div>
        </div>
        
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Discounts</h3>
                <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="row text-center">
                    @foreach($discounts as $discount)
                    <div class="col-md-6">
                        <label>{{$discount->description}}</label>
                    </div>
                    <div class="col-md-6">
                        <p>{{$discount->amount}}</p>
                    </div>
                    @endforeach
                </div>
                
                <a href="{{ route('discounts.edit', [$discount->fad_id]) }}" class="btn btn-primary btn-sm btn-block btn-flat"> EDIT</a>         
            </div> 
        </div>
        
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Database</h3>
                <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <form method="POST" action="{{route('home.restoreDatabase')}}">
                    {{csrf_field()}}
                <p class="text-center">Click "Restore" to retreive all saved data.</p>
                <button type="submit" class="btn btn-primary btn-sm btn-flat btn-block pull-right">RESTORE</button>
                </form>
            </div>
        </div>
        
    </div>
    <div class="col-md-8">
        <row>
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs nav-justified">
                    <li class="active"><a href="#terminalTab" data-toggle="tab">Terminals</a></li>
                    <li><a href="#destinationTab" data-toggle="tab">Destinations</a></li>
                    <li><a href="#feeTab" data-toggle="tab">Fees</a></li>
                </ul>
                <div class="tab-content">
                    <!-- Terminal Tab -->
                    <div class="tab-pane active" id="terminalTab">
                       <div class="table-responsive">
                        <div class="col-md-6 pull-left">
                            <a href="/home/settings/terminal/create" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"> </i> CREATE TERMINAL</a>
                        </div>
                        <table class="table table-bordered table-striped dataTable">
                            <thead>
                                <tr>
                                    <th>Terminal Name</th>
                                    <th>Booking Fee</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($terminals as $terminal)
                                <tr>
                                    <td>{{$terminal->description}}</td>
                                    <td class="pull-right">{{$terminal->booking_fee}}</td>
                                    <td>
                                        <div class="text-center">                               
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#{{'deleteTerminal'.$terminal->terminal_id}}"><i class="fa fa-trash"></i> DELETE
                                            </button>
                                        </div>

                                    </td>

                                    <!-- Modal for Delete-->
                                    <div class="modal fade" id="{{'deleteTerminal'.$terminal->terminal_id}}">
                                        <div class="modal-dialog">
                                            <div class="col-md-offset-2 col-md-8">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-red">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title"> Confirm</h4>
                                                    </div>
                                                    <div class="modal-body row" style="margin: 0% 1%;">
                                                        <div class="col-md-2" style="font-size: 35px; margin-top: 7px;">
                                                            <i class="fa fa-exclamation-triangle pull-left" style="color:#d9534f;">  </i>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <p style="font-size: 110%;">Are you sure you want to delete "{{ $terminal->description }}" terminal?</p>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ route('terminal.destroy',[$terminal->terminal_id]) }}" method="POST">
                                                            {{csrf_field()}}
                                                            {{method_field('DELETE')}}

                                                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                                            <button type="submit" name="driverArc" value="Arch " class="btn btn-danger" style="width:22%;">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>
                    <!-- Destinations Tab -->
                    <div class="tab-pane" id="destinationTab">
                       <div class="table-responsive">
                        <div class="col-md-6 pull-left">
                            <a href="/home/settings/destinations/create" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"> </i> CREATE DESTINATION </a>
                        </div>
                        <table class="table table-bordered table-striped destination">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Fare</th>
                                    <th>Terminal</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($destinations as $destination)
                                <tr>
                                    <td>{{$destination->description}}</td>
                                    <td class="pull-right">{{$destination->amount}}</td>
                                    <td>{{$destination->terminal->description}}</td>
                                    <td>

                                            <div class="text-center">
                                                <a href="{{ route('destinations.edit', [$destination->destination_id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit" ></i> EDIT</a>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#{{'deleteDestination'.$destination->destination_id}}"><i class="fa fa-trash"></i> DELETE</button>
                                            </div>

                                    </td>
                                    <!-- Modal for Delete-->
                                    <div class="modal fade" id="{{'deleteDestination'.$destination->destination_id}}">
                                        <div class="modal-dialog">
                                            <div class="col-md-offset-2 col-md-8">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-red">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title"> Confirm</h4>
                                                    </div>
                                                    <div class="modal-body row" style="margin: 0% 1%;">
                                                        <div class="col-md-2" style="font-size: 35px; margin-top: 7px;">
                                                            <i class="fa fa-exclamation-triangle pull-left" style="color:#d9534f;">  </i>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <p style="font-size: 110%;">Are you sure you want to delete "{{ $destination->description }}"?</p>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ route('destinations.destroy', [$destination->destination_id]) }}" method="POST">
                                                            {{csrf_field()}}
                                                            {{method_field('DELETE')}}

                                                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                                            <button type="submit" name="driverArc" value="Arch " class="btn btn-danger" style="width:22%;">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->

                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                        </div>
                    </div>
                    <!-- Fee Tab -->
                    <div class="tab-pane" id="feeTab">
                       <div class="table-responsive">
                        <table class="table table-bordered table-striped dataTable">
                            <thead>
                                <tr>
                                    <th>Fee</th>
                                    <th>Amount</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fees as $fee)
                                <tr>
                                    <td>{{$fee->description}}</td>
                                    <td class="pull-right">{{$fee->amount}}</td>
                                    <td>
                                        <div class="text-center">    
                                            <a href="{{ route('fees.edit', [$fee->fad_id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> EDIT</a>
                                        </div>

                                    </td>
                                </tr>
                                @endforeach
                                @foreach($terminalsFee as $terminal)
                                <tr>
                                    <td>Booking Fee ({{$terminal->description}})</td>
                                    <td class="pull-right">{{$terminal->booking_fee}}</td>
                                    <td>
                                        <div class="text-center">
                                            <a href="{{ route('terminal.edit', [$terminal->terminal_id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> EDIT</a>
                                        </div>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </row>
            <!-- /.col -->
    </div>
</div>


    @endsection
    @section('scripts')
    @parent
    @include('message.success')
    @include('message.error')
    <script>
        $(document).ready(function() {
            $('.sidebar-menu').tree()
        })


      $(document).ready(function(){
        $('.status').on('click', function(event){
          id = $(this).data('id');
          $.ajax({
            type: 'POST',
            url: "{{ URL::route('changeAdminStatus') }}",
            data: {
              '_token': $('input[name=_token]').val(),
              'id': id
            },
            success: function(data){
              //empty
            },
          });
        });
      });

        $(document).ready(function(){
            $('.features').on('click', function(event){
                id = $(this).data('featureid');
                    $.ajax({
                    type: 'POST',
                    url: '/home/settings/changeFeature/'+id,
                    data: {
                      '_token': $('input[name=_token]').val(),
                      'id': id
                    },
                    success: function(data){
                      //empty
                    },
                });
            });
        });

    </script>
    <script>
        $(function() {
            $('.dataTable').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': true,
                'aoColumnDefs': [{
                    'bSortable': false,
                    'aTargets': [-1] /* 1st one, start by the right */
                }]
            }),
            
             $('.destination').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': true,
                'order': [[ 2, "desc" ]],
                'aoColumnDefs': [{
                    'bSortable': false,
                    'aTargets': [-1] /* 1st one, start by the right */
                }]
            })

        })

    </script>
    @endsection
