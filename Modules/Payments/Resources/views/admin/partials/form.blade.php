<div class="card m-b-20">
    <div class="card-body">

        @include ('core::status-messages')

        <h4 class="mt-0 header-title">{{ $data->title }}
            <small>Informações</small>
        </h4>

        <div class="form-group row mb-4 {{ $errors->has('status') ? 'has-error' : '' }}">
            {{ Form::label('status', 'Status', ['class' => 'col-sm-3 col-form-label']) }}
            <div class="col-lg-7 col">
                {{ Form::select('status', [0 => 'Inativo', 1 => 'Ativo'], NULL, ['class' => 'form-control']) }}
                <span class="text-danger">{{ $errors->first('status') }}</span>
            </div>
        </div>

        @foreach($data->configs as $config)

            <div class="form-group row mb-4 {{ $errors->has($config->name) ? 'has-error' : '' }}">
                {{ Form::label($config->name, $config->title, ['class' => 'col-sm-3 col-form-label']) }}
                <div class="col-lg-7 col">
                    @include('payments::admin.partials.form_item')
                    @if($config->description)
                        <p class="text-muted mb-0 mt-1 ml-2">{{ $config->description }}</p>
                        <span class="text-danger">{{ $errors->first($config->name) }}</span>
                    @endif
                </div>
            </div>

        @endforeach

    </div>

    <div class="card-footer">
        {{ Form::button('<i class="fa fa-check"></i> '.trans('dashboard::dashboard.form.save'), ['class' => 'btn btn-success pull-right waves-effect waves-light', 'type' => 'submit']) }}
    </div>

</div>

