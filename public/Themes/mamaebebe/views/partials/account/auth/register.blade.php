@extends('partials.account.layouts.master')

@section('form')
    <div class="text-center">
        <h2>Torne-se um membro</h2>
        <p>Informe seus dados abaixo</p>
    </div>
    {!! Form::open(['route' => 'web.clients.register', 'method' => 'POST', 'class' => 'form-ajax']) !!}
    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}" data-form="name">
        {{ Form::text('name', NULL, ['class' => 'form-control', 'placeholder' => 'Nome', 'autocomplete' => 'off']) }}
        <span class="text-danger">{{ $errors->first('name') }}</span>
    </div>
    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}" data-form="email">
        {{ Form::text('email', NULL, ['class' => 'form-control', 'placeholder' => 'E-mail', 'autocomplete' => 'off']) }}
        <span class="text-danger">{{ $errors->first('email') }}</span>
    </div>
    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}" data-form="password">
        {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Senha']) }}
        <span class="text-danger">{{ $errors->first('password') }}</span>
    </div>
    {{ Form::button('Cadastre-se', ['class' => 'btn btn-info btn-block', 'type' => 'submit']) }}
    {!! Form::close() !!}

    @if(Request::secure())
        <div class="or"><span>Ou inscreva-se usando</span></div>
        @include('partials.account.btn_social')
    @endif

    <div class="text-center my-4">
        <a href="{{ route('web.clients') }}">Já tenho minha conta</a>
    </div>
@stop