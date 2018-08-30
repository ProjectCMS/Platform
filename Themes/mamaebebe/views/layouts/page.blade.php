@extends('layouts.master')
@section('content')
    <div class="global-title">
        <h1>@yield('page_title')</h1>
    </div>
    <div class="container">
        <div class="page-content mt-4">
                @yield('page_content')
        </div>
    </div>
@stop