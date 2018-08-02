@extends('layouts.login')
@section('content')
    <div class="login-page">
        <div class="login-box">
            <div class="content">
                <div class="row no-gutters">
                    <div class="col">
                        <div class="left-content">
                            <a href="{{ url('/') }}" class="back"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Voltar
                                para o site</a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="right-contet">
                            <div class="description-content d-flex flex-column justify-content-center">
                                <img src="{{ asset('storage/filemanager/logo.png') }}" class="logo">
                                @yield('form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop