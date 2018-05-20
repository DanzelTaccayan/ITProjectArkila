@extends('layouts.master') 
@section('title', 'Announcements') 
@section('content-header','Announcements')
@section('content') 
<div class="padding-side-10">
    <div>
        <h2 class="text-white">ANNOUNCEMENTS</h2>
    </div>
    <div class="box box-solid">
        <div class="box-body" style="min-height: 300px;">
            <div class="row">
                <div class="col-md-12">
                @if ($announcements->count() > 0)
                <div>
                    <a type="button" href="create" class="btn btn-success btn-flat"><i class="fa fa-plus"></i> CREATE ANNOUNCEMENT</a>
                </div>
                <div style="margin-top: 2%">
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
                        </li>
                        @endforeach
                        <!-- /.content -->
                    </ul>
                </div>
                @foreach($announcements->sortByDesc('created_at') as $announcement)
                <!-- Modal for View-->
                    <div class="modal fade" id="view{{'announcement'.$announcement->announcement_id}}">
                        <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-yellow">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                        <h4 class="modal-title"> {{ $announcement->title }}</h4>
                                    </div>
                                    <div class="modal-body ">
                                        <div class="scrollbar scrollbar-info thin">
                                        <p class="padding-side-5">{{ $announcement->description }}</p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                            <div class="text-center">
                                                <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Close</button>
                                                <a href="{{route('announcements.edit', [$announcement->announcement_id])}}" class="btn btn-primary btn-create btn-sm"><i class="fa fa-edit"></i> EDIT</a>
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
                @endforeach
                @else
                <div style="margin-top: 5%">
                    <h1 class="text-center text-gray"><i class="fa fa-bullhorn"></i></h1>
                    <h2 class="text-center">No Announcement as of the moment.</h3>
                    <div class="text-center">
                        <a type="button" href="create" class="btn btn-success btn-flat"><i class="fa fa-plus"></i> CREATE ANNOUNCEMENT</a>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif 
@endsection