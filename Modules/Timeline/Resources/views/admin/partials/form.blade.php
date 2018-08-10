<div class="card m-b-20">
    <div class="card-body">

        @include ('core::status-messages')

        <h4 class="mt-0 header-title">Timeline
            <small>Informações</small>
        </h4>

        <div class="row">

            <div class="col-md-6">
                <div class="form-group {{ $errors->has('order') ? 'has-error' : '' }}">
                    {{ Form::label('order', 'Ordem') }}
                    {{ Form::select('order', $order, NULL, ['class' => 'form-control select2']) }}
                    <span class="text-danger">{{ $errors->first('order') }}</span>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="col-md-6">
                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                    {{ Form::label('title', 'Título') }}
                    {{ Form::text('title', NULL, ['class' => 'form-control']) }}
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group {{ $errors->has('post_id') ? 'has-error' : '' }}">
                    {{ Form::label('post_id', 'Postagem') }}
                    {{ Form::select('post_id', $posts, NULL, ['class' => 'form-control select2']) }}
                    <span class="text-danger">{{ $errors->first('post_id') }}</span>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
                    {{ Form::label('content', 'Conteúdo') }}
                    {{ Form::textarea('content', NULL, ['class' => 'form-control', 'rows' => 6]) }}
                    <span class="text-danger">{{ $errors->first('content') }}</span>
                </div>
            </div>

        </div>

    </div>
</div>

