@extends('layouts.includes')

@section('layout')
    <div class="main-content">

        <header class="header" data-header="simple">
            <div class="header-content">
                <div class="container">
                    <a href="{{ url('/') }}" class="logo pull-left" title="{{ setting('site_name') }} -  Página inicial">
                        <img src="{{ asset('storage/filemanager/logo.png') }}">
                    </a>
                    <div class="content">
                        <div class="account ml-auto">
                        @include('partials.client.account_menu')
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="page-content">
            @yield('page-content')
        </div>
    </div>

    @include('layouts.footer')
@stop