@extends('layouts.layout')

@section('layout')

    <div class="main-content">

        <header class="header">
            <div class="header-top">
                <div class="container">
                    <ul class="nav pull-left">
                        <li class="nav-item">
                            <a class="nav-link btn btn-link" href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-link" href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-link" href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                        </li>
                    </ul>
                    <ul class="nav justify-content-end pull-right">
                        @if($client)
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
                                <a class="nav-link btn btn-link" href="{{ route('web.clients') }}">Login</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="header-content">
                <div id="app" class="container">
                    <div class="mobile">
                        <a href="{{ url('/') }}" title="{{ setting('site_name') }}" class="logo">
                            <img src="{{ asset('storage/logo.png') }}" height="50">
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
            <li class="facebook">
                <a href="">
                    <i class="fa fa-facebook"></i>
                    <h3>Facebook</h3>
                    <span>Siga-nos no Facebook</span>
                </a>
            </li>
            <li class="twitter">
                <a href="">
                    <i class="fa fa-twitter"></i>
                    <h3>Twitter</h3>
                    <span>Siga-nos no Twitter</span>
                </a>
            </li>
            <li class="googlep">
                <a href="">
                    <i class="fa fa-google-plus"></i>
                    <h3>Google+</h3>
                    <span>Siga-nos no Google</span>
                </a>
            </li>
            <li class="instagram">
                <a href="">
                    <i class="fa fa-instagram"></i>
                    <h3>Instagram</h3>
                    <span>Siga-nos no Instagram</span>
                </a>
            </li>
            <li class="pinterest">
                <a href="">
                    <i class="fa fa-pinterest"></i>
                    <h3>Pinterest</h3>
                    <span>Siga-nos no Pinterest</span>
                </a>
            </li>
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

        <img src="{{ asset('storage/logo-w.png') }}" height="50">
        <div class="copyright">
            <div class="container">
                <span>© {{ date('Y') }} - {!! config('dashboard.logo', '') !!} - Todos os direitos reservados</span>
            </div>
        </div>
    </footer>

@stop
