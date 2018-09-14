@extends('layouts.includes')

@section('layout')

    @include('partials.menu.sidebar.item')

    <div class="main-content">

        <header class="header">
            <div class="header-top">
                <div class="container">
                    <div class="pull-left">
                        <div class="nav-search">
                            {!! Form::open(['route' => 'web.posts', 'method' => 'get']) !!}
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i></span>
                                </div>
                                {{ Form::text('s', Request::get('s'), ['class' => 'form-control', 'placeholder' => 'Buscar', 'autocomplete' => 'off']) }}
                            </div>
                            {!! Form::close() !!}
                           </div>
                    </div>

                    <div class="account pull-right">
                        @auth('client')
                            @include('partials.client.account_menu')
                        @else
                            <ul class="nav justify-content-end">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('web.clients.register') }}">Cadastre-se</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('web.clients.login') }}">Login</a>
                                </li>
                            </ul>
                        @endauth
                    </div>
                </div>
            </div>

            <div class="header-content">
                <div id="app" class="container">
                    <div class="mobile">
                        <a href="{{ url('/') }}" title="{{ setting('site_name') }}" class="logo">
                            <img src="{{ image_resize('filemanager/logo.png') }}" height="50">
                        </a>
                        <a href="#" class="nav sidebar-collapse">
                            <i class="fa fa-bars" aria-hidden="true"></i>
                        </a>
                    </div>
                    <nav class="navbar navbar-expand-lg navbar-light" id="nav-top">
                        <div id="navbarNavDropdown" class="navbar-collapse collapse">
                            @include ('partials.menu.top.item')
                        </div>
                    </nav>
                </div>
            </div>
        </header>

        <div class="page-content">
            @yield('content')
        </div>

    </div>

    @include('layouts.footer')

@stop
