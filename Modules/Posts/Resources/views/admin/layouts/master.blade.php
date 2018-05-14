@extends('dashboard::layouts.master')

@section('dashboard_css')
    <link rel="stylesheet" href="{{ Module::asset('posts:css/posts.css') }}">
@endsection

@section('dashboard_js')
    <script type="text/javascript" src="{{ Module::asset('posts:js/posts.js') }}"></script>
@endsection
