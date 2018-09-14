@extends('partials.client.layouts.account')

@section('content')
    <div class="container">
        <div class="box box-shadow">
            <h5 class="box-title">Editar perfil</h5>
            @include('core::status-messages')
            {!! Form::model($client, ['route' => ['web.clients.account.profile.update'], 'method' => 'PUT']) !!}

            <div class="form-group row  {{ $errors->has('name') ? 'has-error' : '' }}">
                {{ Form::label('name', 'Nome', ['class' => 'col-sm-2 col-form-label', 'for' => 'input-name']) }}
                <div class="col-sm-10">
                    {{ Form::text('name', NULL, ['class' => 'form-control', 'id' => 'input-name']) }}
                </div>
            </div>

            <div class="form-group row  {{ $errors->has('email') ? 'has-error' : '' }}">
                {{ Form::label('email', 'E-mail', ['class' => 'col-sm-2 col-form-label', 'for' => 'input-email']) }}
                <div class="col-sm-10">
                    {{ Form::text('email', NULL, ['class' => 'form-control', 'id' => 'input-email']) }}
                </div>
            </div>


            <div class="text-right">
                {{ Form::button('<i class="fa fa-check"></i> Salvar perfil', ['class' => 'btn btn-success btn-lg btn-loading', 'type' => 'submit', 'data-style' => 'zoom-in', 'data-spinner-size' => 30]) }}
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@stop
