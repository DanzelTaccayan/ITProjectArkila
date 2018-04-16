@extends('layouts.master') 
@section('title', 'Announcements') 
@section('content-header','Announcements')
@section('content') 

<div class="box box-solid">
    <div class="box-body">
        <div class="row">
            <div class="col-md-9 mx-auto">
            <div class="box box-warning box-solid with-shadow">   

                    <div class="box-header with-border text-center">
                        <h3 class="box-title">
                            Create Announcement
                        </h3>

                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <form method="post" action="{{ route('announcements.index') }}">
                        {{ csrf_field() }}
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Title: <span class="text-red">*</span></label>
                                    <input type="text" name="title" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group pull-right">
                                    <label>Viewer: <span class="text-red">*</span></label>
                                    <select name="viewer" class="form-control">
                                        <option value="Public">Public</option>
                                        <option value="Driver Only">Driver Only</option>
                                        <option value="Customer Only">Customer Only</option>
                                        <option value="Only Me">Only Me</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Content: <span class="text-red">*</span></label>
                            <textarea name="announce" width="30%" class="form-control" rows="5"></textarea>
                        </div>
                        
                    </div>

                    <div class="box-footer">
                        <div style="overflow:auto;">
                            <div style="float:right;">
                                <button type="submit" class="btn btn-primary btn-sm">POST</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            @if ($announcements->count() > 0) 
            <div class="text-center">
                <h3>ANNOUNCEMENTS</h3>
            </div>
                <ul class="list-group">
                @foreach ($announcements->sortByDesc('created_at') as $announcement)

                <li class="list-group-item">
                    <div class="with-border">
                        <div>
                            <h4 class="pull-left title-limit">{{ $announcement->title }}
                            </h4>
                            <a class="btn btn-box-tool pull-right" data-toggle="modal" data-target="#delete{{'announcement'.$announcement->announcement_id}}"><i class="fa fa-times"></i></a>
                        </div>
                        <div class="clearfix"></div>
                        <h6><i class="fa fa-eye"></i> {{ $announcement->viewer }}
                            <span>
                                <i>| <strong>Created:</strong> 
                                {{ $announcement->created_at->format('Y-m-d h:i:s A') }}
                                    <span>
                                        @if ($announcement->created_at->ne($announcement->updated_at))
                                                | <strong>Updated:</strong> 
                                                {{ $announcement->updated_at->format('Y-m-d h:i:s A') }}
                                        @endif
                                    </span>
                                </i>
                            </span>
                        </h6>
                    </div>
                    <div class="">
                        <div><p class="title-limit">{{ $announcement->description }}</p></div>
                    </div>

                    <div class="">
                        <div class="pull-right">
                            <a href class="btn btn-primary btn-create btn-sm" data-toggle="modal" data-target="#view{{'announcement'.$announcement->announcement_id}}"><i class="fa fa-eye"></i> SEE MORE</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <!-- Modal for Edit-->
                    <div class="modal fade" id="view{{'announcement'.$announcement->announcement_id}}">
                        <div class="modal-dialog">
                            
                                <div class="modal-content">
                                    <div class="modal-header bg-yellow">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                        <h4 class="modal-title"> ANNOUNCEMENT</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>{{ $announcement->description }}</p>
                                    </div>
                                    <div class="modal-footer">
                                            <div class="text-center">
                                                <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Close</button>
                                                <a href="{{route('announcements.edit', [$announcement->announcement_id])}}" class="btn btn-primary btn-create btn-sm"><i class="fa fa-pencil"></i> EDIT</a>
                                            </div>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->  
                    <!-- Modal for Delete-->
                    <div class="modal fade" id="delete{{'announcement'.$announcement->announcement_id}}">
                        <div class="modal-dialog modal-sm">
                            
                                <div class="modal-content">
                                    <div class="modal-header bg-red">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                        <h4 class="modal-title"> Confirm</h4>
                                    </div>
                                    <div class="modal-body">
                                       <h1>
                                           <i class="fa fa-exclamation-triangle pull-left text-yellow" style="color:#d9534f;"></i>
                                       </h1>
                                        <p>Are you sure you want to delete this Announcement?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form method="POST" action="/home/announcements/{{$announcement->announcement_id}}">
                                            {{csrf_field()}} 
                                            {{method_field('DELETE')}}

                                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                            <button type="submit" name="driverArc" value="Arch" class="btn btn-danger">Delete</button>

                                        </form>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->  
                </li>

                @endforeach
                <!-- /.content -->
                </ul>
            @else
            </div>
        </div>
    </div>
</div>
<div class="container text-center" style="margin-top: 18%">
    <h1>No Announcement as of the moment</h1>
    <p>To add announcement click on the Megaphone icon located at top right corner of the page. (beside the profile icon)</p>
</div>
@endif 
@endsection