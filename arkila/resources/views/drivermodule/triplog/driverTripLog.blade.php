@extends('layouts.driver')
@section('title', 'Driver Profile')
@section('content-title', 'Driver Profile')
@section('content')
<div class="desktop">
    <div class="box">
        <div class="box-header with-border">
            <i class="fa fa-car"></i>
            <h3 class="box-title">Trip Log</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
                <table id="driverLog" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Trip No.</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Origin</th>
                        <th>Destination</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                  @php
                    $tripNo = 1;
                    $innerRoutesArr = null;
                  @endphp
                  @foreach($tripsMade->trips as $tripKey => $tripMade)
                    <tr>

                        <td>{{$tripNo}}</td>
                        <td>{{$tripMade->date_departed}}</td>
                        <td>{{$tripMade->time_departed}}</td>
                        <td>{{$tripMade->origin}}</td>
                        <td>{{$tripMade->destination}}</td>
                        <td>{{$tripMade->report_status}}</td>
                        <td>
                            <div class="text-center">
                                <a href="{{route('drivermodule.triplog.driverTripDetails', [$tripMade->trip_id])}}" type="button"
                                class="btn btn-primary btn-sm"
                                id="view-trip{{$tripMade->trip_id}}">
                                <i class="fa fa-eye"></i>
                                  VIEW
                                </a>
                            </div>
                        </td>

                    </tr>
                    @php $tripNo++; @endphp
                    @endforeach
                </tbody>
                </table>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>
<!-- /.desktop -->

<div class="mobile_device_480px">
    <div class="box">
        <div class="box-header with-border">
            <i class="fa fa-car"></i>
            <h3 class="box-title">Trip Log</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="list-group">
                @php $tripCount = 1; @endphp
                @foreach($tripsMade->trips as $tripMade)
                <li class="list-group-item">Trip {{$tripCount}} ({{$tripMade->date_departed}} || {{$tripMade->time_departed}})
                    <a href="{{route('drivermodule.triplog.driverTripDetails', [$tripMade->trip_id])}}" type="button" id="view-tripresp{{$tripMade->trip_id}}" class="btn btn-xs btn-primary pull-right">
                    <i class="fa fa-eye"></i>
                      View
                    </a>
                </li>
                @endforeach
            </div>
            <!-- /.list -->
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>
<!-- /.mobile -->
@endsection @section('scripts') @parent

<script>
$(function() {
    $('#driverLog').DataTable({
        'paging': true,
        'lengthChange': false,
        'searching': true,
        'ordering': true,
        'info': true,
        'autoWidth': true
    })
});
</script>

<style>
    /* if desktop */

    .mobile_device_380px {
        display: none;
    }

    .mobile_device_480px {
        display: none;
    }


    /* if mobile device max width 380px */

    @media only screen and (max-device-width: 380px) {
        .mobile_device_380px {
            display: block;
        }
        .desktop {
            display: none;
        }
    }

    /* if mobile device max width 480px */

    @media only screen and (max-device-width: 480px) {
        .mobile_device_480px {
            display: block;
        }
        .desktop {
            display: none;
        }
    }
</style>

@endsection
