@extends('layouts.master_simple')
@section('page-content')
    <div class="my-account">
        <div class="header-account">
            <h3 class="user-name">{{ $client->name }}</h3>
            {!! Form::open(['route' => 'web.clients.account.avatar', 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
            <label for="upload" class="avatar mb-0">
                <div class="box-image">
                    @if($client->avatar)
                        <img src="{{ asset('storage/'.$client->avatar) }}">
                    @endif
                    <div class="change-image">
                        <i class="fa fa-camera" aria-hidden="true"></i>
                    </div>
                </div>
                {{ Form::file('avatar', ['class' => 'd-none', 'id' => 'upload', 'onchange' => 'form.submit()']) }}
            </label>
            {!! Form::close() !!}
        </div>
        <nav class="nav-account navbar navbar-expand-lg">
            <div class="container">
                <ul class="navbar-nav justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('web.clients.account.home') }}"><i class="fa fa-address-card-o"></i>
                            Visão geral da conta</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('web.clients.account.profile') }}"><i class="fa fa-edit"></i>
                            Editar perfil</a></li>
                </ul>
                <ul class="navbar-nav justify-content-start">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('web.clients.account.password') }}"><i class="fa fa-key"></i>
                            Mudar senha</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('web.clients.account.historic') }}"><i class="fa fa-credit-card"></i> Histórico de pagamentos</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="content-account mt-5">
            @yield('content')
        </div>

    </div>
@stop
