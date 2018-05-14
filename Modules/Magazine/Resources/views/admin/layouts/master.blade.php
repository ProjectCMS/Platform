@extends('dashboard::layouts.master')

@section('dashboard_css')
    <link rel="stylesheet" href="{{ Module::asset('magazine:css/magazine.css') }}">
    @endsection

@section('dashboard_js')
    <script type="text/javascript">
        var urlMagazine = '{{ route('admin.magazine.manager') }}'
    </script>
    <script type="text/javascript" src="{{ Module::asset('magazine:js/magazine.js') }}"></script>
@endsection
