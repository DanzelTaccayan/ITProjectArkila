@extends('layouts.form_lg')
@section('title', 'Create Announcement')
@section('back-link', route('announcements.index'))
@section('form-action', route('announcements.store'))
@section('method_field', method_field('POST'))
@section('form-id','regForm')
@section('form-title', 'Create Announcement')
@section('form-body')

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
    <form method="post" action="{{ route('announcements.index') }}">
        {{ csrf_field() }}
        <div class="box-body">
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
@endsection