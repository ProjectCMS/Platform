@extends('dashboard::layouts.master')

@section('dashboard_js')

    <script type="text/javascript">

        app.urlMenuItem = '{{ route('admin.settings.menus.addItemMenu') }}';

    </script>

@stop