<div class="card m-b-20">
    <div class="card-body">

        @include ('core::status-messages')

        <h4 class="mt-0 header-title">Concurso
            <small>Informações</small>
        </h4>

        <div class="row">

            <div class="col-md-6">
                <div class="form-group {{ $errors->has('status_id') ? 'has-error' : '' }}">
                    {{ Form::label('status_id', 'Status') }}
                    {{ Form::select('status_id', $status, NULL, ['class' => 'form-control select2']) }}
                    <span class="text-danger">{{ $errors->first('status_id') }}</span>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                    {{ Form::label('title', 'Título do concurso') }}
                    {{ Form::text('title', NULL, ['class' => 'form-control']) }}
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group {{ $errors->has('starts_at') ? 'has-error' : '' }}">
                    {{ Form::label('starts_at', 'Data de inicio') }}
                    {{ Form::date('starts_at', \Carbon\Carbon::parse(@$data->starts_at)->format('Y-m-d'), ['class' => 'form-control']) }}
                    <span class="text-danger">{{ $errors->first('starts_at') }}</span>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group {{ $errors->has('finalized_at') ? 'has-error' : '' }}">
                    {{ Form::label('finalized_at', 'Data de finalização') }}
                    {{ Form::date('finalized_at', \Carbon\Carbon::parse(@$data->finalized_at)->format('Y-m-d'), ['class' => 'form-control']) }}
                    <span class="text-danger">{{ $errors->first('finalized_at') }}</span>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
                    {{ Form::textarea('content', NULL, ['class' => 'form-control textarea editor']) }}
                    <span class="text-danger">{{ $errors->first('content') }}</span>
                </div>
            </div>

        </div>

    </div>
</div>

<div class="card m-b-20">
    <div class="card-body">

        @include('contents::admin.partials.votes')

    </div>
    <div class="card-footer">
        {{ Form::button('<i class="fa fa-check"></i> '.trans('dashboard::dashboard.form.save'), ['class' => 'btn btn-success pull-right waves-effect waves-light', 'type' => 'submit']) }}
    </div>
</div>
