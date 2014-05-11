@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')

<!-- Tabs -->
<ul class="nav nav-tabs">
    <li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
</ul>
<!-- ./ tabs -->
{{-- Delete Candidate Form --}}
<form id="deleteForm" class="form-horizontal" method="post" action="@if (isset($candidate)){{ URL::to('admin/candidates/' . $candidate->id . '/delete') }}@endif" autocomplete="off">

    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
    <input type="hidden" name="id" value="{{ $candidate->id }}" />
    <!-- <input type="hidden" name="_method" value="DELETE" /> -->
    <!-- ./ csrf token -->

    <!-- Form Actions -->
    <div class="control-group">
        <div class="controls">
            Delete Candidate
            <element class="btn-cancel close_popup">Cancel</element>
            <button type="submit" class="btn btn-danger">Delete</button>
        </div>
    </div>
    <!-- ./ form actions -->
</form>
@stop