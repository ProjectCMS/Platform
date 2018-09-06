@extends('layouts.master_simple')

@section('page-content')
    <div class="my-account">
        <div class="header-account">
            <h3 class="user-name">{{ $client->name }}</h3>
            <a href="#" class="avatar">
                <div class="box-image">
                    <img src="http://endlesstheme.com/Endless1.5.1/img/user.jpg">
                    <div class="change-image">
                        <i class="fa fa-camera" aria-hidden="true"></i>
                    </div>
                </div>
            </a>
        </div>
        <nav class="nav-account navbar navbar-expand-lg">
            <div class="container">
                <ul class="navbar-nav justify-content-end">
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fa fa-address-card-o"></i> Visão geral da conta</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fa fa-edit"></i> Editar perfil</a></li>
                </ul>
                <ul class="navbar-nav justify-content-start">
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fa fa-key"></i> Mudar senha</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fa fa-credit-card"></i> Assinatura</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="content-account mt-5">
            @yield('content')
        </div>

    </div>
@stop