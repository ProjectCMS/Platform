<!doctype html>
<html lang="pt-br" class="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {!! SEO::generate() !!}

    <link href="{{ Theme::assets('css/libs.min.css') }}?v={{ time() }}" rel="stylesheet" type="text/css"/>
    <link href="{{ Theme::assets('css/core.min.css') }}?v={{ time() }}" rel="stylesheet" type="text/css"/>
    <link href="{{ Theme::assets('css/modules.min.css') }}?v={{ time() }}" rel="stylesheet" type="text/css"/>

    <!-- Custom css -->
    @yield('css')

</head>
<body>

<div class="overlay"></div>
<div class="loader"></div>
<div class="main-content">

    <header class="header">
        <div class="header-top"></div>

        <div class="nav-content">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container">

                    <div class="collapse navbar-collapse" id="navbar">
                        @include('partials.menu.top.item')
                        <div href class="user">
                            <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                            @if($client)
                                <span>Olá, {{ $client->name }}</span>
                                <span>
                                    <a href="#">Minha conta</a>
                                    @if(config('adminlte.logout_method') == 'GET' || !config('adminlte.logout_method') && version_compare(\Illuminate\Foundation\Application::VERSION, '5.3.0', '<'))
                                        <a href="#">Sair</a>
                                    @else
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sair</a>
                                        <form id="logout-form" action="{{ route('web.clients.logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    @endif
                            </span>
                            @else
                                <span>Olá, visitante!</span>
                                <span>
                                <a href="#" data-toggle="modal" data-target="#modal-login" data-event="register">Cadastre-se</a>
                                <a href="#" data-toggle="modal" data-target="#modal-login" data-event="login">Login</a>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </nav>
        </div>

        <div class="logo">
            <div class="container">
                <a href="{{ url('') }}"><img src="{{ asset('storage/logo.png') }}" height="40"></a>
                <i class="fa fa-bars sidebar-collapse"></i>
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

@if(!$client)
    @include('partials.modal_login')
@endif

<script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5b28232fa7603d0012fa8517&product=inline-share-buttons' async='async'></script>
<!-- jQuery  -->
<script type="text/javascript" src="{{ Theme::assets('js/libs.min.js') }}?v={{ time() }}"></script>
<script type="text/javascript" src="{{ Theme::assets('js/core.min.js') }}?v={{ time() }}"></script>
<script type="text/javascript" src="{{ Theme::assets('js/modules.min.js') }}?v={{ time() }}"></script>

<!-- Custom js -->
@yield('js')

</body>
</html>
