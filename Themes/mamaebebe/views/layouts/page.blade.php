@extends('layouts.master')
@section('content')
    <div class="global-title">
        <h1>@yield('page_title')</h1>
    </div>
    <nav aria-label="breadcrumb" class="cm-breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Library</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
        </div>
    </nav>
    <div class="container">
        @yield('page_content')
    </div>
@stop