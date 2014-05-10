@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
<!-- Tabs -->
<ul class="nav nav-tabs">
    <li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
    <li><a href="#tab-meta-data" data-toggle="tab">Meta data</a></li>
</ul>
<!-- ./ tabs -->

{{-- Edit Cunli Form --}}
<form class="form-horizontal" method="post" action="@if (isset($cunli)){{ URL::to('admin/cunlis/' . $cunli->id . '/edit') }}@endif" autocomplete="off">
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
    <!-- ./ csrf token -->

    <!-- Tabs Content -->
    <div class="tab-content">
        <!-- General tab -->
        <div class="tab-pane active" id="tab-general">
            
            <!-- Cunli id -->
            <div class="form-group {{{ $errors->has('id') ? 'error' : '' }}}">
                <div class="col-md-12">
                    <label class="control-label" for="id">Cunli ID</label>
                    <input class="form-control" type="text" name="id" id="id" value="{{{ Input::old('id', isset($cunli) ? $cunli->id : null) }}}" />
                    {{{ $errors->first('id', '<span class="help-inline">:message</span>') }}}
                </div>
            </div>
            <!-- ./ cunli id -->
            
            <!-- Cunli county_id -->
            <div class="form-group {{{ $errors->has('county_id') ? 'error' : '' }}}">
                <div class="col-md-12">
                    <label class="control-label" for="county_id">County</label>
                    {{ Form::select('county_id', $counties) }}
                    {{{ $errors->first('county_id', '<span class="help-inline">:message</span>') }}}
                </div>
            </div>
            <!-- ./ cunli county_id -->
            
            <!-- Cunli town_id -->
            <div class="form-group {{{ $errors->has('town_id') ? 'error' : '' }}}">
                <div class="col-md-12">
                    <label class="control-label" for="town_id">Town</label>
                    {{ Form::select('town_id', $towns) }}
                    {{{ $errors->first('town_id', '<span class="help-inline">:message</span>') }}}
                </div>
            </div>
            <!-- ./ cunli town_id -->

            <!-- Cunli Title -->
            <div class="form-group {{{ $errors->has('title') ? 'error' : '' }}}">
                <div class="col-md-12">
                    <label class="control-label" for="title">Cunli Title</label>
                    <input class="form-control" type="text" name="title" id="title" value="{{{ Input::old('title', isset($cunli) ? $cunli->title : null) }}}" />
                    {{{ $errors->first('title', '<span class="help-inline">:message</span>') }}}
                </div>
            </div>
            <!-- ./ cunli title -->
        </div>
        <!-- ./ general tab -->
    </div>
    <!-- ./ tabs content -->

    <!-- Form Actions -->
    <div class="form-group">
        <div class="col-md-12">
            <element class="btn-cancel close_popup">Cancel</element>
            <button type="reset" class="btn btn-default">Reset</button>
            <button type="submit" class="btn btn-success">Update</button>
        </div>
    </div>
    <!-- ./ form actions -->
</form>
@stop
