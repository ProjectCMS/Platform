<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @yield('title_prefix', config('dashboard.title_prefix', ''))
        -
        @yield('title', config('dashboard.title', 'Dashboard'))
        @yield('title_postfix', config('dashboard.title_postfix', ''))
    </title>

    <link href="{{ asset('admin/css/libs.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ Theme::assets('css/theme.css') }}" rel="stylesheet" type="text/css"/>

    <!-- Custom css -->
    @yield('css')

</head>
<body>

@include('partials.preloader')

<div class="header-bg">
    <!-- Navigation Bar-->
    <header id="topnav">
        <div class="topbar-main">
            <div class="container-fluid">

                <!-- Logo container-->
                <div class="logo">
                    <!-- Text Logo -->
                    <a href="{{ url(config('dashboard.dashboard_url', 'home')) }}" class="logo">{!! config('dashboard.logo', '') !!}</a>
                </div>
                <!-- End Logo container-->

                @include('partials.toolbar')

                <div class="clearfix"></div>

            </div> <!-- end container -->
        </div>
        <!-- end topbar-main -->

        @include('partials.menu.master')
    </header>
    <!-- End Navigation Bar-->

    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <form class="float-right app-search">
                        <input type="text" placeholder="Search..." class="form-control">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
                    <h4 class="page-title">
                        <i class="@yield('title_icon', 'dripicons-device-desktop')"></i> @yield('title_prefix')</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        @yield('content_header')
    </div>
</div>

@yield('content')

<!-- Footer -->
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                © {{ date('Y') }} {!! config('dashboard.logo', '') !!}
            </div>
        </div>
    </div>
</footer>
<!-- End Footer -->

<!-- jQuery  -->
<script type="text/javascript" src="{{ asset('admin/js/libs.min.js') }}"></script>
<script type="text/javascript" src="{{ Theme::assets('js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ Theme::assets('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ Theme::assets('js/modernizr.min.js') }}"></script>
<script type="text/javascript" src="{{ Theme::assets('js/waves.js') }}"></script>
<script type="text/javascript" src="{{ Theme::assets('js/jquery.slimscroll.js') }}"></script>
<script type="text/javascript" src="{{ Theme::assets('js/jquery.nicescroll.js') }}"></script>
<script type="text/javascript" src="{{ Theme::assets('js/jquery.scrollTo.min.js') }}"></script>

<script type="text/javascript" src="{{ Theme::assets('plugins/tinymce/tinymce.min.js') }}"></script>

<!-- App js -->
<script type="text/javascript" src="{{ Theme::assets('js/app.js') }}"></script>

<!-- Custom js -->
@yield('js')

</body>
</html>
