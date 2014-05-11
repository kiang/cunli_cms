@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ $title }}} :: @parent
@stop

@section('keywords')Candidates administration @stop
@section('author')Laravel 4 Bootstrap Starter SIte @stop
@section('description')Candidates administration index @stop

{{-- Content --}}
@section('content')
<div class="page-header">
    <h3>
        {{{ $title }}}

        <div class="pull-right">
            <a href="{{{ URL::to('admin/candidates/create') }}}" class="btn btn-small btn-info iframe"><span class="glyphicon glyphicon-plus-sign"></span> Create</a>
        </div>
    </h3>
</div>

<table id="candidates" class="table table-striped table-hover">
    <thead>
        <tr>
            <th class="col-md-4">{{{ Lang::get('admin/candidates/table.county') }}}</th>
            <th class="col-md-4">{{{ Lang::get('admin/candidates/table.town') }}}</th>
            <th class="col-md-4">{{{ Lang::get('admin/candidates/table.cunli') }}}</th>
            <th class="col-md-4">{{{ Lang::get('admin/candidates/table.name') }}}</th>
            <th class="col-md-2">{{{ Lang::get('table.actions') }}}</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
@stop

{{-- Scripts --}}
@section('scripts')
<script type="text/javascript">
    var oTable;
    $(document).ready(function() {
        oTable = $('#candidates').dataTable({
            "sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
            "sPaginationType": "bootstrap",
            "oLanguage": {
                "sLengthMenu": "_MENU_ records per page"
            },
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "{{ URL::to('admin/candidates/data') }}",
            "fnDrawCallback": function(oSettings) {
                $(".iframe").colorbox({iframe: true, width: "80%", height: "80%"});
            }
        });
    });
</script>
@stop