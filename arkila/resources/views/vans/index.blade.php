@extends('layouts.master')
@section('title', 'List of Van') 
@if(session()->get('opLink')) {{ session()->forget('opLink') }} @endif

@section('content')
<div class="box">
    <!-- /.box-header -->
    <div class="box-body">
    <div class="table-responsive">
    	<div class="col-md-6">
    		<a href="{{route('vans.create')}}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> REGISTER VAN</a>
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
	                                 
                                    @if($van->driver()->first())
                                        <a href="{{ route('vans.edit',[$van->plate_number] ) }}" name="listDriver" data-driver="{{$van->driver->first()->member_id}}" data-val="{{ $van->operator()->first()->member_id ?? $van->operator()->first()}}" class="btn btn-primary btn-sm btn-driver"><i class="fa fa-exchange"></i> CHANGE DRIVER</a>
                                    @else
                                        <a href="{{ route('vans.edit',[$van->plate_number] ) }}" class="btn btn-primary btn-sm btn-driver"><i class="fa fa-user-plus"></i> ADD DRIVER</a>
                                    @endif
                                    
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
                                <form method="POST" action="{{route('vans.archiveDelete',[$van->plate_number])}}">
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


    $('a[name="listDriver"]').on('click',function(e){
        $('select[name="driver"]').empty();
        $.ajax({
            method:'POST',
            url: '{{route("vans.listDrivers")}}',
            data: {
                '_token': '{{csrf_token()}}',
                'operator':$(e.currentTarget).data('val'),
                'vanDriver': $(e.currentTarget).data('driver')
            },
            success: function(drivers){

                $('#OpName').text($(e.currentTarget).closest('tr').find('td')[2].textContent);
                $('#formChangeDriver').attr('action',"/home/vans/"+$(e.currentTarget).closest('tr').find('td')[0].textContent);
                $('select[name="driver"]').append('<option value="">None</option>');

                drivers.forEach(function(driverObj){
                    $('select[name="driver"]').append('<option value='+driverObj.id+'> '+driverObj.name+'</option>');
                });

            }

        });
    });

    $('a[name="vanInfo"]').on('click',function(e){
        $.ajax({
            method:'POST',
            url: '{{route("vans.vanInfo")}}',
            data: {
                '_token': '{{csrf_token()}}',
                'van':$(e.currentTarget).data('val')
            },
            success: function(vanInfo){
                $('#plateNumber').text(vanInfo.plateNumber);
                $('#vanModel').text(vanInfo.vanModel);
                $('#seatingCapacity').text(vanInfo.seatingCapacity);
                $('#vanOperator').text(vanInfo.operatorOfVan);
                $('#vanDriver').text(vanInfo.driverOfVan);
            }

        });
    });

    });
</script>

@endsection