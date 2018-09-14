@extends('partials.client.layouts.account')

@section('content')
    <div class="container">
        <div class="box box-shadow">
            <h5 class="box-title">Editar perfil</h5>
            @include('core::status-messages')
            {!! Form::model($client, ['route' => ['web.clients.account.password.update'], 'method' => 'PUT']) !!}

            <div class="form-group row  {{ $errors->has('current_password') ? 'has-error' : '' }}">
                {{ Form::label('current_password', 'Senha atual', ['class' => 'col-sm-2 col-form-label', 'for' => 'input-current_password']) }}
                <div class="col-sm-10">
                    {{ Form::password('current_password', ['class' => 'form-control', 'id' => 'input-current_password']) }}
                    <span class="text-danger">{{ $errors->first('current_password') }}</span>
                </div>
            </div>

            <div class="form-group row  {{ $errors->has('new_password') ? 'has-error' : '' }}">
                {{ Form::label('new_password', 'Nova senha', ['class' => 'col-sm-2 col-form-label', 'for' => 'input-new_password']) }}
                <div class="col-sm-10">
                    {{ Form::password('new_password', ['class' => 'form-control', 'id' => 'input-new_password']) }}
                    <span class="text-danger">{{ $errors->first('new_password') }}</span>
                </div>
            </div>

            <div class="form-group row  {{ $errors->has('new_password_confirmation') ? 'has-error' : '' }}">
                {{ Form::label('new_password_confirmation', 'Confirmar nova senha', ['class' => 'col-sm-2 col-form-label', 'for' => 'input-new_password_confirmation']) }}
                <div class="col-sm-10">
                    {{ Form::password('new_password_confirmation', ['class' => 'form-control', 'id' => 'input-new_password_confirmation']) }}
                    <span class="text-danger">{{ $errors->first('new_password_confirmation') }}</span>
                </div>
            </div>

            <div class="text-right">
                {{ Form::button('<i class="fa fa-check"></i> Salvar senha', ['class' => 'btn btn-success btn-lg btn-loading', 'type' => 'submit', 'data-style' => 'zoom-in', 'data-spinner-size' => 30]) }}
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@stop
