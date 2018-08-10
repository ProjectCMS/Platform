<div class="card m-b-20">
    <div class="card-body">

        <h4 class="mt-0 header-title">Timeline
            <small>Informações</small>
        </h4>

        <div class="row">

            <div class="col-md-6">
                <div class="form-group {{ $errors->has('timeline_order') ? 'has-error' : '' }}">
                    {{ Form::label('timeline_order', 'Ordem') }}
                    {{ Form::text('timeline_order', @$timeline->order, ['class' => 'form-control']) }}
                    <span class="text-danger">{{ $errors->first('timeline_order') }}</span>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group {{ $errors->has('timeline_title') ? 'has-error' : '' }}">
                    {{ Form::label('timeline_title', 'Título') }}
                    {{ Form::text('timeline_title', @$timeline->title, ['class' => 'form-control']) }}
                    <span class="text-danger">{{ $errors->first('timeline_title') }}</span>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group {{ $errors->has('timeline_content') ? 'has-error' : '' }}">
                    {{ Form::label('timeline_content', 'Conteúdo') }}
                    {{ Form::textarea('timeline_content', @$timeline->content, ['class' => 'form-control', 'rows' => 6]) }}
                    <span class="text-danger">{{ $errors->first('timeline_content') }}</span>
                </div>
            </div>

            @if(isset($timeline->id))
                {{ Form::hidden('timeline_id', $timeline->id, ['class' => 'form-control']) }}
            @endif

        </div>

    </div>
</div>

