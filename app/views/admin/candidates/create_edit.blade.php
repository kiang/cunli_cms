@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
<!-- Tabs -->
<ul class="nav nav-tabs">
    <li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
    <li><a href="#tab-meta-data" data-toggle="tab">Meta data</a></li>
</ul>
<!-- ./ tabs -->

{{-- Edit Candidate Form --}}
<form class="form-horizontal" method="post" action="@if (isset($candidate)){{ URL::to('admin/candidates/' . $candidate->id . '/edit') }}@endif" autocomplete="off">
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
    <!-- ./ csrf token -->

    <!-- Tabs Content -->
    <div class="tab-content">
        <!-- General tab -->
        <div class="tab-pane active" id="tab-general">
            
            <!-- Candidate county_id -->
            <div class="form-group {{{ $errors->has('county_id') ? 'error' : '' }}}">
                <div class="col-md-12">
                    <label class="control-label" for="county_id">County</label>
                    {{ Form::select('county_id', $counties) }}
                    {{{ $errors->first('county_id', '<span class="help-inline">:message</span>') }}}
                </div>
            </div>
            <!-- ./ candidate county_id -->
            
            <!-- Candidate town_id -->
            <div class="form-group {{{ $errors->has('town_id') ? 'error' : '' }}}">
                <div class="col-md-12">
                    <label class="control-label" for="town_id">Town</label>
                    {{ Form::select('town_id', $towns) }}
                    {{{ $errors->first('town_id', '<span class="help-inline">:message</span>') }}}
                </div>
            </div>
            <!-- ./ candidate town_id -->
            
            <!-- Candidate cunli_id -->
            <div class="form-group {{{ $errors->has('cunli_id') ? 'error' : '' }}}">
                <div class="col-md-12">
                    <label class="control-label" for="cunli_id">Cunli</label>
                    {{ Form::select('cunli_id', $cunlis) }}
                    {{{ $errors->first('cunli_id', '<span class="help-inline">:message</span>') }}}
                </div>
            </div>
            <!-- ./ candidate cunli_id -->

            <!-- Candidate Name -->
            <div class="form-group {{{ $errors->has('name') ? 'error' : '' }}}">
                <div class="col-md-12">
                    <label class="control-label" for="name">Candidate Name</label>
                    <input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', isset($candidate) ? $candidate->name : null) }}}" />
                    {{{ $errors->first('name', '<span class="help-inline">:message</span>') }}}
                </div>
            </div>
            <!-- ./ candidate name -->
            
            <!-- Candidate Head -->
            <div class="form-group {{{ $errors->has('head') ? 'error' : '' }}}">
                <div class="col-md-12">
                    <label class="control-label" for="head">Candidate Head</label>
                    <input class="form-control" type="text" name="head" id="head" value="{{{ Input::old('head', isset($candidate) ? $candidate->head : null) }}}" />
                    {{{ $errors->first('head', '<span class="help-inline">:message</span>') }}}
                </div>
            </div>
            <!-- ./ candidate head -->
            
            <!-- Candidate gender -->
            <div class="form-group {{{ $errors->has('gender') ? 'error' : '' }}}">
                <div class="col-md-12">
                    <label class="control-label" for="gender">Gender</label>
                    {{ Form::select('gender', array('m' => 'Male', 'f' => 'Female'), isset($candidate) ? $candidate->gender : null) }}
                    {{{ $errors->first('gender', '<span class="help-inline">:message</span>') }}}
                </div>
            </div>
            <!-- ./ candidate gender -->
            
            <!-- Candidate dob -->
            <div class="form-group {{{ $errors->has('dob') ? 'error' : '' }}}">
                <div class="col-md-12">
                    <label class="control-label" for="dob">Candidate Dob</label>
                    <input class="form-control" type="text" name="dob" id="dob" value="{{{ Input::old('dob', isset($candidate) ? $candidate->dob : null) }}}" />
                    {{{ $errors->first('dob', '<span class="help-inline">:message</span>') }}}
                </div>
            </div>
            <!-- ./ candidate dob -->
            
            <!-- data -->
            <div class="form-group {{{ $errors->has('data') ? 'error' : '' }}}">
                <div class="col-md-12">
                    <label class="control-label" for="data">Data</label>
                    <textarea class="form-control full-width wysihtml5" name="data" value="data" rows="10">{{{ Input::old('data', isset($candidate) ? $candidate->data : null) }}}</textarea>
                    {{{ $errors->first('data', '<span class="help-inline">:message</span>') }}}
                </div>
            </div>
            <!-- ./ data -->
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
