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
                    <button onclick="window.open('{{route('pdf.van')}}')" class="btn btn-default btn-sm btn-flat"> <i class="fa fa-print"></i> PRINT VAN LIST</button>
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
        							<td>{{$van->plate_number}}</td>
        							<td>
        							{{ $van->driver()->first()->full_name ?? null }}
        							</td>
        							<td>{{ $van->operator()->first()->full_name ??  null }}</td>
        							<td>{{$van->model->description}}</td>
        							<td class="pull-right">{{$van->seating_capacity}}</td>
        							<td>
        								<div class="text-center">

                                            <a href="{{ route('vans.edit',[$van->van_id] ) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>EDIT</a>
                                            <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#{{ 'deleteWarning'. $van->van_id }}"><i class="fa fa-trash"></i> DELETE</button>
        		                        </div>

        							</td>
        						</tr>
                                
                                
        					@endforeach
                    </tbody>
                </table>
                </div>
                @foreach($vans->where('status', 'Active') as $van)
                <!-- MODAL DELETION -->
                    <div class="modal fade" id="{{ 'deleteWarning'. $van->van_id }}">
                        <div class="modal-dialog">
                            <div class="col-md-offset-2 col-md-8">
                                <div class="modal-content">
                                    <div class="modal-header bg-red">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                        <h4 class="modal-title"> Confirm</h4>
                                    </div>
                                    <div class="modal-body">
                                        <h3>  
                                           <i class="fa fa-exclamation-triangle pull-left text-yellow"></i>
                                        </h3>
                                        <p>Are you sure you want to delete <strong>{{$van->plate_number}}</strong>?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form method="POST" action="{{route('vans.archiveVan',[$van->van_id])}}">
                                            {{csrf_field()}}
                                            {{method_field('PATCH')}}
                                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                            <button type="submit" class="btn btn-danger">Delete</button>
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