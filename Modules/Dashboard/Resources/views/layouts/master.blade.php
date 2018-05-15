@extends('fonik::layouts.master')

@section('css')

    @yield('dashboard_css')

@stop

@section('js')

    <!-- Global variables  -->
    <script type="text/javascript">

        var app = {};

        app.urlManager = '{{ route('admin.media.modal') }}';
        app.request    = '{{ http_build_query(Request::all()) }}';
        app.token      = $('meta[name="csrf-token"]').attr('content');

        var manager = app.urlManager;

    </script>
    @yield('dashboard_js')

@stop
