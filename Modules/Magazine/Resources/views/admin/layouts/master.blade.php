@extends('dashboard::layouts.master')

@section('dashboard_js')
    <script type="text/javascript">
        let urlMagazine = '{{ route('admin.magazine.manager') }}'
    </script>
@stop
