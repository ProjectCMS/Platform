<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @yield('title_prefix', config('dashboard.title_prefix', 'Dashboard'))
        -
        @yield('title', config('dashboard.title', 'Dashboard'))
        @yield('title_postfix', config('dashboard.title_postfix', ''))
    </title>

    <!-- App css -->
    <link href="{{ Theme::assets('css/theme.css') }}" rel="stylesheet" type="text/css"/>

</head>
<body>

@include('partials.preloader')

<!-- Begin page -->
<div class="accountbg"></div>
<div class="wrapper-page">

    <div class="card">
        <div class="card-body">

            <h3 class="text-center m-0">
                <a href="{{ url(config('dashboard.dashboard_url', 'home')) }}" class="logo logo-admin">{{ config('dashboard.logo', '') }}</a>
            </h3>

            <div class="p-3">

                {!! Form::open(['url' => url(config('dashboard.login_url', 'login')), 'method' => 'post', 'class' => 'form-horizontal m-t-30']) !!}

                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    {{ Form::label('email', trans('dashboard::dashboard.form.email')) }}
                    {{ Form::text('email', NULL, ['class' => 'form-control']) }}
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                </div>

                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    {{ Form::label('password', trans('dashboard::dashboard.form.password')) }}
                    {{ Form::password('password', ['class' => 'form-control']) }}
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                </div>

                <div class="form-group row m-t-20">
                    <div class="col-sm-6">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customControlInline">
                            <label class="custom-control-label" for="customControlInline">{{ trans('dashboard::dashboard.form.remember_me') }}</label>
                        </div>
                    </div>
                    <div class="col-sm-6 text-right">
                        <button class="btn btn-primary w-md waves-effect waves-light" type="submit">{{ trans('dashboard::dashboard.form.sign_in') }}</button>
                    </div>
                </div>

                <div class="form-group m-t-10 mb-0 row">
                    <div class="col-12 m-t-20">
                        <a href="{{ url(config('dashboard.password_reset_url', 'password/reset')) }}" class="text-muted"><i class="mdi mdi-lock"></i> {{ trans('dashboard::dashboard.form.forgot_my_password') }}
                        </a>
                    </div>
                </div>

                {!! Form::close() !!}
            </div>

        </div>
    </div>

    <div class="m-t-40 text-center">
        <p>© {{ date('Y') }} {!! config('dashboard.logo', '') !!}</p>
    </div>

</div>

<!-- jQuery  -->
<script src="{{ Theme::assets('js/jquery.min.js') }}"></script>
<script src="{{ Theme::assets('js/popper.min.js') }}"></script>
<script src="{{ Theme::assets('js/bootstrap.min.js') }}"></script>
<script src="{{ Theme::assets('js/modernizr.min.js') }}"></script>
<script src="{{ Theme::assets('js/waves.js') }}"></script>
<script src="{{ Theme::assets('js/jquery.slimscroll.js') }}"></script>
<script src="{{ Theme::assets('js/jquery.nicescroll.js') }}"></script>
<script src="{{ Theme::assets('js/jquery.scrollTo.min.js') }}"></script>

<!-- App js -->
<script src="{{ Theme::assets('js/app.js') }}"></script>

</body>
</html>