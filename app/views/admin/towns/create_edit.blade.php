@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
<!-- Tabs -->
<ul class="nav nav-tabs">
    <li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
    <li><a href="#tab-meta-data" data-toggle="tab">Meta data</a></li>
</ul>
<!-- ./ tabs -->

{{-- Edit Town Form --}}
<form class="form-horizontal" method="post" action="@if (isset($town)){{ URL::to('admin/towns/' . $town->id . '/edit') }}@endif" autocomplete="off">
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
    <!-- ./ csrf token -->

    <!-- Tabs Content -->
    <div class="tab-content">
        <!-- General tab -->
        <div class="tab-pane active" id="tab-general">
            <!-- Town Title -->
            <div class="form-group {{{ $errors->has('title') ? 'error' : '' }}}">
                <div class="col-md-12">
                    <label class="control-label" for="title">Town Title</label>
                    <input class="form-control" type="text" name="title" id="title" value="{{{ Input::old('title', isset($town) ? $town->title : null) }}}" />
                    {{{ $errors->first('title', '<span class="help-inline">:message</span>') }}}
                </div>
            </div>
            <!-- ./ town title -->
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
