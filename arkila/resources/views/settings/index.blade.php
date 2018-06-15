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
                                    <input type="checkbox" class="features" data-featureid="{{$feature->id}}" @if($feature->status == 'enable') {{'checked'}} @endif>
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
                <h3 class="box-title">Ticket Queue</h3>
                <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body"> 
                <a type="button" onclick=" window.open('/live-queue')" class="btn btn-primary btn-sm btn-flat btn-block pull-right">TICKET QUEUE</a>
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
                <form name="restoreBackupForm" method="POST" action="{{route('home.restoreDatabase')}}">
                    {{csrf_field()}}
                <p class="text-center">Click "Restore" to retrieve all saved data.</p>
                <button type="submit" class="btn btn-primary btn-sm btn-flat btn-block pull-right">RESTORE</button>
                </form>
            </div>
        </div>

    </div>
    <div class="col-md-8">
        <div class="box">
            <div class="box-body">
               <div class="table-responsive">
                    <div class="col col-md-6">
                       <h4><strong>FEES</strong></h4>
                    </div>
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
                                        <a href="{{ route('fees.edit', [$fee->fee_id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> EDIT</a>
                                    </div>

                                </td>
                            </tr>
                            @endforeach
                            @foreach($terminals as $terminal)
                            <tr>
                                <td>Booking Fee ({{$terminal->destination_name}})</td>
                                <td class="pull-right">{{$terminal->booking_fee}}</td>
                                <td>
                                    <div class="text-center">
                                        <a href="{{route('bookingfee.edit', $terminal->destination_id)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> EDIT</a>
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
    @include('layouts.partials.preloader_div')
</div>


    @endsection
    @section('scripts')
    @parent
    @include('message.success')
    @include('message.error')
    <script>
        $(document).ready(function() {
            $('.sidebar-menu').tree();

            $('form[name="restoreBackupForm" ]').on('submit', function(){
                        $('#submit-loader').removeClass('hidden');
                        $('#submit-loader').css("display","block");
                        $(this).find('button[type="submit"]').prop('disabled',true);
            });
        });


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
                      new PNotify({
                        title: "Success!",
                        text: data.success,
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
