<div class="card m-b-20">
    <div class="card-body">

        @include ('core::status-messages')

        <h4 class="mt-0 header-title">Post
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
                <div class="form-group {{ $errors->has('orientation_id') ? 'has-error' : '' }}">
                    {{ Form::label('orientation_id', 'Orientação') }}
                    {{ Form::select('orientation_id', $orientation, NULL, ['class' => 'form-control select2']) }}
                    <span class="text-danger">{{ $errors->first('status_id') }}</span>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                    {{ Form::label('title', 'Título') }}
                    {{ Form::text('title', NULL, ['class' => 'form-control']) }}
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group {{ $errors->has('url') ? 'has-error' : '' }}">
                    {{ Form::label('url', 'URL') }}
                    {{ Form::text('url', NULL, ['class' => 'form-control']) }}
                    <span class="text-danger">{{ $errors->first('url') }}</span>
                </div>
            </div>

        </div>

    </div>
</div>


