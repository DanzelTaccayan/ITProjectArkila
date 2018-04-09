@extends('layouts.master')
@section('title', 'List of Van') 
@if(session()->get('opLink')) {{ session()->forget('opLink') }} @endif

@section('content')
<div class="box">
    <!-- /.box-header -->
    <div class="box-body">
    <div class="table-responsive">
    	<div class="col-md-6">
            @if(count(\App\Member::allOperators()->where('status','Active')->get()) > 0)
    		<a href="{{route('vans.create')}}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> REGISTER VAN</a>
            @else
                <button title="Please add an operator first" class="btn btn-primary btn-sm btn-flat" disabled><i class="fa fa-plus"></i> REGISTER VAN</button>
            @endif
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
							<td>{{$van->plate_number}}</td>
							<td>
							{{ $van->driver()->first()->full_name ?? null }}
							</td>
							<td>{{ $van->operator()->first()->full_name ??  null }}</td>
							<td>{{$van->vanModel->description}}</td>
							<td class="pull-right">{{$van->seating_capacity}}</td>
							<td>
								<div class="text-center">

                                    <a href="{{ route('vans.edit',[$van->plate_number] ) }}" class="btn btn-primary btn-sm btn-driver"><i class="fa fa-user-plus"></i>EDIT</a>
                                    <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#{{ 'deleteWarning'. $van->plate_number }}"><i class="fa fa-trash"></i> DELETE</button>
		                        </div>

							</td>
						</tr>
                        
                        
					@endforeach
            </tbody>
        </table>
        </div>
        @foreach($vans->where('status', 'Active') as $van)
        <!-- MODAL DELETION -->
            <div class="modal fade" id="{{ 'deleteWarning'. $van->plate_number }}">
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
                                <p>Are you sure you want to delete "{{ $van->model }}" with plate number of "{{$van->plate_number}}"</p>
                            </div>
                            <div class="modal-footer">
                                <form method="POST" action="{{route('vans.archiveVan',[$van->plate_number])}}">
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
            }]
        });


    });
</script>

@endsection