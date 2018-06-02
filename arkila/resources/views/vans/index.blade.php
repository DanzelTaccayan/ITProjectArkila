@extends('layouts.master')
@section('title', 'List of Van') 
@if(session()->get('opLink')) {{ session()->forget('opLink') }} @endif

@section('content')
<div class="padding-side-5">
    <div>
        <h2 class="text-white">LIST OF VAN UNITS</h2>
    </div>   
    <div class="box">
        <!-- /.box-header -->
        <div class="box-body with-shadow">
            <div class="table-responsive">
            	<div class="col-md-6">
                    @if(count(\App\Member::allOperators()->where('status','Active')->get()) > 0)
            		<a href="{{route('vans.create')}}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-plus"></i> REGISTER VAN</a>
                    @else
                        <button title="Please add an operator first" class="btn btn-success btn-sm btn-flat" disabled><i class="fa fa-plus"></i> REGISTER VAN</button>
                    @endif
                    <a href="{{route('archive.showAllArchivedVans')}}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-archive"></i> ARCHIVE</a>
                    <button onclick="window.open('{{route('pdf.van')}}')" class="btn btn-default btn-sm btn-flat"> <i class="fa fa-print"></i> PRINT</button>
            	</div>

                <table id="van" class="table table-bordered table-striped">
                    <thead>
                        <tr>
        				    <th>Plate Number</th>
        				    <th>Driver</th>
        				    <th>Operator</th>
        				    <th>Model</th>
        				    <th>Seating Capacity</th>
        				    <th class="text-center">Actions</th>
        				</tr>
                    </thead>
                    <tbody>
                        @foreach($vans->where('status', 'Active') as $van)
        						<tr>
        							<td class="text-uppercase">{{$van->plate_number}}</td>
        							<td class="text-uppercase">
        							{{ $van->driver()->first()->full_name ?? null }}
        							</td>
        							<td class="text-uppercase">{{ $van->operator()->first()->full_name ??  null }}</td>
        							<td class="text-uppercase">{{$van->model->description}}</td>
        							<td class="pull-right">{{$van->seating_capacity}}</td>
        							<td>
        								<div class="text-center">
                                            <a href="{{ route('vans.edit',[$van->van_id] ) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>EDIT</a>
                                            <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#{{ 'deleteWarning'. $van->van_id }}"><i class="fa fa-trash"></i>DELETE</button>
        		                        </div>

        							</td>
        						</tr>   
        					@endforeach
                    </tbody>
                </table>
                </div>
                @foreach($vans->where('status', 'Active') as $van)
                <div class="modal" id="{{ 'deleteWarning'. $van->van_id }}">
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
                                <h4 class="text-center "><strong class="text-red">{{$van->plate_number}}</strong>?</h4>
                            </div>
                            <div class="modal-footer">
                                <form method="POST" action="{{route('vans.archiveVan',[$van->van_id])}}">
                                    {{csrf_field()}}
                                    {{method_field('PATCH')}}
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
</div>
@endsection 
@section('scripts') 
@parent

<script>
    $(document).ready(function() {
        $('#van').DataTable({
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
                },
                { 
                "width": "13%", "targets": 4
                },
                {
                "width": "13%", "targets": 0 
                }
            ]
        });


    });
</script>

@endsection