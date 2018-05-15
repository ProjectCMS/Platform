@extends('dashboard::layouts.master')

@section('dashboard_js')
    <script type="text/javascript">
        var urlMagazine = '{{ route('admin.magazine.manager') }}'
    </script>
@stop
