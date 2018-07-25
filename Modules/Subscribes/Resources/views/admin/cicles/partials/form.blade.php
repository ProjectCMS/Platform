<div class="card m-b-20">
    <div class="card-body">

        @include ('core::status-messages')

        <h4 class="mt-0 header-title">Ciclos de assinatura
            <small>Informações</small>
        </h4>

        <div class="form-group row {{ $errors->has('period_id') ? 'has-error' : '' }}">
            {{ Form::label('period_id', 'Período', ['class' => 'col-sm-3 col-form-label']) }}
            <div class="col-sm-9">
                {{ Form::select('period_id', $periods, NULL, ['class' => 'form-control select2']) }}
                <span class="text-danger">{{ $errors->first('period_id') }}</span>
            </div>
        </div>

        <div class="form-group row {{ $errors->has('title') ? 'has-error' : '' }}">
            {{ Form::label('title', 'Título', ['class' => 'col-sm-3 col-form-label']) }}
            <div class="col-sm-9">
                {{ Form::text('title', NULL, ['class' => 'form-control']) }}
                <span class="text-danger">{{ $errors->first('title') }}</span>
            </div>
        </div>

        <div class="form-group row {{ $errors->has('amount') ? 'has-error' : '' }}">
            {{ Form::label('amount', 'Valor', ['class' => 'col-sm-3 col-form-label']) }}
            <div class="col-sm-9">
                {{ Form::text('amount', NULL, ['class' => 'form-control money']) }}
                <span class="text-danger">{{ $errors->first('amount') }}</span>
            </div>
        </div>

    </div>

    <div class="card-footer">
        {{ Form::button('<i class="fa fa-check"></i> '.trans('dashboard::dashboard.form.save'), ['class' => 'btn btn-success pull-right waves-effect waves-light', 'type' => 'submit']) }}
    </div>

</div>



