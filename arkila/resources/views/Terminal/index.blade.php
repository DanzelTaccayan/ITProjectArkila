@extends('layouts.master')
@section('title', 'Settings')
@section('content')
<div class="box">
    <div class="box-body" style="box-shadow: 0px 5px 10px gray;">
       <div class="table-responsive">
        <div class="col col-md-6">
            <a href="#" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> ADD TERMINAL/ROUTE</a>
        </div>
 
        <div class="tab-pane" id="terminal">
	        <table id="operatorList" class="table table-bordered table-striped">
	            <thead>
	                <tr>
	                    <th>ID</th>
	                    <th>Terminal Name</th>
	                    <th>Number of Routes</th>
	                    <th class="text-center">Actions</th>
	                </tr>
	            </thead>

	            <tbody>
	               
	                <tr>
	                    <td></td>
	                    <td></td>
	                    <td></td>
	                    <td>
	                        <div class="text-center">
	                            <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> VIEW</a>       
	                        </div>
	                    </td>
	                </tr>
	            </tbody>
	        </table>
    	</div>

    	<div class="tab-pane" id="route">
    		<table id="route" class="table table-bordered table-striped">
	            <thead>
	                <tr>
	                    <th>ID</th>
	                    <th>Route</th>
	                    <th>Contact Number</th>
	                    <th class="text-center">Actions</th>
	                </tr>
	            </thead>

	            <tbody>
	               
	                <tr>
	                    <td></td>
	                    <td></td>
	                    <td></td>
	                    <td>
	                        <div class="text-center">
	                            <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> VIEW</a>       
	                        </div>
	                        <!-- /.text -->
	                    </td>
	                </tr>
	            </tbody>
        	</table>
    	</div>
    </div>
    <!-- /.box-body -->
</div>

@endsection
@section('scripts') 
@parent

@endsection