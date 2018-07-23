<div class="card m-b-20">
    <div class="card-body">

        @include ('core::status-messages')

        <h4 class="mt-0 header-title">Administrador
            <small>Informações</small>
        </h4>

        <div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
            {{ Form::label('name', 'Nome', ['class' => 'col-sm-3 col-form-label']) }}
            <div class="col-sm-9">
                {{ Form::text('name', NULL, ['class' => 'form-control']) }}
                <span class="text-danger">{{ $errors->first('name') }}</span>
            </div>
        </div>

        <div class="form-group row {{ $errors->has('email') ? 'has-error' : '' }}">
            {{ Form::label('email', 'E-mail', ['class' => 'col-sm-3 col-form-label']) }}
            <div class="col-sm-9">
                {{ Form::text('email', NULL, ['class' => 'form-control']) }}
                <span class="text-danger">{{ $errors->first('email') }}</span>
            </div>
        </div>

        <div class="form-group row {{ $errors->has('password') ? 'has-error' : '' }}">
            {{ Form::label('password', 'Senha', ['class' => 'col-sm-3 col-form-label']) }}
            <div class="col-sm-9">
                {{ Form::password('password', ['class' => 'form-control']) }}
                <span class="text-danger">{{ $errors->first('password') }}</span>
            </div>
        </div>

        <div class="form-group row {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
            {{ Form::label('password_confirmation', 'Confirmar senha', ['class' => 'col-sm-3 col-form-label']) }}
            <div class="col-sm-9">
                {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
            </div>
        </div>

    </div>

    <div class="card-footer">
        {{ Form::button('<i class="fa fa-check"></i> '.trans('dashboard::dashboard.form.save'), ['class' => 'btn btn-success pull-right waves-effect waves-light', 'type' => 'submit']) }}
    </div>

</div>