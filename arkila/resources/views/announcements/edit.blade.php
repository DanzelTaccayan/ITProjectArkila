@extends('layouts.form_lg')
@section('title', 'Edit Announcement')
@section('back-link', route('announcements.index'))
@section('form-action', route('announcements.update', [$announcement->announcement_id]))
@section('method_field', method_field('PATCH'))
@section('form-id','regForm')
@section('form-title', 'Edit Announcement')
@section('form-body')

<div class="box box-warning with-shadow" style = " margin: 7% auto;">   

    <div class="box-header with-border text-center">
        <h4>
            <a href="{{route('announcements.index')}}" class="pull-left"><i class="fa  fa-chevron-left"></i></a>
        </h4>
        <h3 class="box-title">
            Edit Announcement
        </h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Title: <span class="text-red">*</span></label>
                    <input type="text" name="title" value="{{ $announcement->title }}" class="form-control" val-announcement-title required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group pull-right">
                    <label>Viewer: <span class="text-red">*</span></label>
                    <select name="viewer" class="form-control">
                        <option value="Public"{{ $announcement->viewer == 'Public' ? 'selected="selected"' : '' }}>Public</option>
                        <option value="Driver Only"{{ $announcement->viewer == 'Driver Only' ? 'selected="selected"' : '' }}>Driver Only</option>
                        <option value="Customer Only"{{ $announcement->viewer == 'Customer Only' ? 'selected="selected"' : '' }}>Customer Only</option>
                        <option value="Only Me"{{ $announcement->viewer == 'Only Me' ? 'selected="selected"' : '' }}>Only Me</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label for="">Content: <span class="text-red">*</span></label>
            <textarea width="30%" class="form-control" rows="10" name="announce" val-announcement required>{{ $announcement->description }}</textarea>
        </div>
        
    </div>

    <div class="box-footer">
        <div style="overflow:auto;">
            <div style="float:right;">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
    
</div>
  

@endsection

