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
                    <ul class="nav justify-content-end pull-right d-none">
                        @auth('client')
                            <li class="nav-item"><a class="nav-link btn btn-link" href="#">Minha conta</a></li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sair</a>
                                <form id="logout-form" action="{{ route('web.clients.logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link btn btn-link" href="{{ route('web.clients.register') }}">Cadastre-se</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-link" href="{{ route('web.clients.login') }}">Login</a>
                            </li>
                        @endauth
                    </ul>
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

    <div class="container d-none d-lg-block">
        <ul class="social-footer list-inline">
            @if(setting('social_network.facebook'))
                <li class="facebook">
                    <a href="{{ setting('social_network.facebook') }}" target="_blank">
                        <i class="fa fa-facebook"></i>
                        <h3>Facebook</h3>
                        <span>Siga-nos no Facebook</span>
                    </a>
                </li>
            @endif

            @if(setting('social_network.twitter'))
                <li class="twitter">
                    <a href="{{ setting('social_network.twitter') }}" target="_blank">
                        <i class="fa fa-twitter"></i>
                        <h3>Twitter</h3>
                        <span>Siga-nos no Twitter</span>
                    </a>
                </li>
            @endif

            @if(setting('social_network.gplus'))
                <li class="googlep">
                    <a href="{{ setting('social_network.gplus') }}" target="_blank">
                        <i class="fa fa-google-plus"></i>
                        <h3>Google+</h3>
                        <span>Siga-nos no Google</span>
                    </a>
                </li>
            @endif

            @if(setting('social_network.instagram'))
                <li class="instagram">
                    <a href="{{ setting('social_network.instagram') }}" target="_blank">
                        <i class="fa fa-instagram"></i>
                        <h3>Instagram</h3>
                        <span>Siga-nos no Instagram</span>
                    </a>
                </li>
            @endif

            @if(setting('social_network.pinterest'))
                <li class="pinterest">
                    <a href="{{ setting('social_network.pinterest') }}" target="_blank">
                        <i class="fa fa-pinterest"></i>
                        <h3>Pinterest</h3>
                        <span>Siga-nos no Pinterest</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>

    <footer class="footer">
        <div class="top">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="container">
                        <div class="collapse navbar-collapse">
                            @include('partials.menu.footer.item')
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <img src="{{ image_resize('filemanager/logo-w.png', 60, NULL, 100) }}" height="50">
        <div class="copyright">
            <div class="container">
                <span>© {{ date('Y') }} - {!! config('dashboard.logo', '') !!} - Todos os direitos reservados</span>
            </div>
        </div>
    </footer>

@stop
