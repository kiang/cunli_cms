@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ $title }}} :: @parent
@stop

@section('keywords')Towns administration @stop
@section('author')Laravel 4 Bootstrap Starter SIte @stop
@section('description')Towns administration index @stop

{{-- Content --}}
@section('content')
<div class="page-header">
    <h3>
        {{{ $title }}}

        <div class="pull-right">
            <a href="{{{ URL::to('admin/towns/create') }}}" class="btn btn-small btn-info iframe"><span class="glyphicon glyphicon-plus-sign"></span> Create</a>
        </div>
    </h3>
</div>

<table id="towns" class="table table-striped table-hover">
    <thead>
        <tr>
            <th class="col-md-4">{{{ Lang::get('admin/towns/table.id') }}}</th>
            <th class="col-md-4">{{{ Lang::get('admin/towns/table.county') }}}</th>
            <th class="col-md-4">{{{ Lang::get('admin/towns/table.title') }}}</th>
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
        oTable = $('#towns').dataTable({
            "sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
            "sPaginationType": "bootstrap",
            "oLanguage": {
                "sLengthMenu": "_MENU_ records per page"
            },
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "{{ URL::to('admin/towns/data') }}",
            "fnDrawCallback": function(oSettings) {
                $(".iframe").colorbox({iframe: true, width: "80%", height: "80%"});
            }
        });
    });
</script>
@stop