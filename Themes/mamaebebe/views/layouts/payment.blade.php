@extends('layouts.includes')

@section('layout')

    <div class="main-content">

        <header class="header-simple">
            <div class="container">
                <a href="{{ url('/') }}" class="logo pull-left">
                    <img src="{{ asset('storage/filemanager/logo.png') }}">
                </a>
                <div class="content">
                    <div class="account ml-auto">
                        <a href="">
                            <div class="avatar">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </div>
                            <span>Michel Vieira</span>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <div class="page-content">
            @yield('page-content')
        </div>

    </div>

@stop