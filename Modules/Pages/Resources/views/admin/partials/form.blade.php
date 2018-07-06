<div class="card m-b-20">
    <div class="card-body">

        @include ('core::status-messages')

        <h4 class="mt-0 header-title">Página
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
            <div class="clearfix"></div>

            <div class="col-md-6">
                <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
                    {{ Form::label('parent_id', 'Grupo') }}
                    {{ Form::select('parent_id', $parent, NULL, ['class' => 'form-control select2']) }}
                    <span class="text-danger">{{ $errors->first('parent_id') }}</span>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group {{ $errors->has('template_id') ? 'has-error' : '' }}">
                    {{ Form::label('template_id', 'Template') }}
                    {{ Form::select('template_id', $template, NULL, ['class' => 'form-control select2']) }}
                    <span class="text-danger">{{ $errors->first('template_id') }}</span>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                    {{ Form::label('title', 'Título da página') }}
                    {{ Form::text('title', NULL, ['class' => 'form-control']) }}
                    <span class="text-danger">{{ $errors->first('title') }}</span>
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
        {{-- SEO FORM --}}
        {!! Form::setModel(@$data->seo) !!}
        @include('seo::admin.form')
    </div>
    <div class="card-footer">
        {{ Form::button('<i class="fa fa-check"></i> '.trans('dashboard::dashboard.form.save'), ['class' => 'btn btn-success pull-right waves-effect waves-light', 'type' => 'submit']) }}
    </div>
</div>
