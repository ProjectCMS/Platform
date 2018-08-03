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
<div class="loader-content">
    <div class="loader"></div>
</div>

@yield('layout')

<script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5b28232fa7603d0012fa8517&product=inline-share-buttons' async='async'></script>
<!-- jQuery  -->
<script type="text/javascript" src="{{ Theme::assets('js/libs.min.js') }}?v={{ time() }}"></script>

<div id="fb-root"></div>
<script>
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js     = d.createElement(s);
        js.id  = id;
        js.src = 'https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v3.1&appId=1668193149919105&autoLogAppEvents=1';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

<script type="text/javascript">

    var web = {};

    web.urlPublishers = '{{ route('web.publishers') }}';
    web.request       = '{{ http_build_query(Request::all()) }}';
    web.token         = $('meta[name="csrf-token"]').attr('content');

</script>

<script type="text/javascript" src="{{ Theme::assets('js/core.min.js') }}?v={{ time() }}"></script>
<script type="text/javascript" src="{{ Theme::assets('js/modules.min.js') }}?v={{ time() }}"></script>

<!-- Custom js -->
@yield('js')


</body>
</html>
