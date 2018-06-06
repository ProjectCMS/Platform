<div class="card m-b-20">
    <div class="card-body">

        @include ('core::status-messages')

        <h4 class="mt-0 header-title">Revista Online
            <small>Informações</small>
        </h4>

        <div class="form-group row {{ $errors->has('status_id') ? 'has-error' : '' }}">
            {{ Form::label('status_id', 'Status', ['class' => 'col-sm-3 col-form-label']) }}
            <div class="col-sm-9">
                {{ Form::select('status_id', $status, NULL, ['class' => 'form-control select2']) }}
                <span class="text-danger">{{ $errors->first('status_id') }}</span>
            </div>
        </div>

        <div class="form-group row {{ $errors->has('title') ? 'has-error' : '' }}">
            {{ Form::label('title', 'Título da revista', ['class' => 'col-sm-3 col-form-label']) }}
            <div class="col-sm-9">
                {{ Form::text('title', NULL, ['class' => 'form-control']) }}
                <span class="text-danger">{{ $errors->first('title') }}</span>
            </div>
        </div>

        <div class="form-group row {{ $errors->has('publish_at') ? 'has-error' : '' }}">
            {{ Form::label('publish_at', 'Data de publicação', ['class' => 'col-sm-3 col-form-label']) }}
            <div class="col-sm-9">
                {{ Form::date('publish_at', \Carbon\Carbon::parse(@$data->publish_at), ['class' => 'form-control']) }}
                <span class="text-danger">{{ $errors->first('publish_at') }}</span>
            </div>
        </div>
    </div>
</div>

<div class="card m-b-20">
    <div class="card-body">
        @include('magazine::admin.partials.list_images', ["images" => @$data->images])
    </div>

    <div class="card-footer">
        {{ Form::button('<i class="fa fa-check"></i> '.trans('dashboard::dashboard.form.save'), ['class' => 'btn btn-success pull-right waves-effect waves-light', 'type' => 'submit']) }}
    </div>
</div>

