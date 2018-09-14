@if($item->model_type == null)
    <div class="form-group">
        {{ Form::label('link-url', 'URL') }}
        {{ Form::text('', $item->url, ['class' => 'form-control', 'data-link' => 'url']) }}
    </div>
@endif

<div class="form-group">
    {{ Form::label('link-title', 'Rótulo de navegação') }}
    {{ Form::text('', $item->title, ['class' => 'form-control', 'data-link' => 'title']) }}
</div>

@if(isset($new))
    @if(isset($item->model))
        <p class="link-original">
            <i>Original:</i> <a href="{{ url($item->model->slug) }}">{{ $item->model->title }}</a>
        </p>
        {{ Form::hidden('', $item->model->id, ['class' => 'form-control', 'data-link' => 'model_id']) }}
    @endif
@else
    @if(isset($item->model))
        <p class="link-original">
            <i>Original:</i> <a href="{{ url($item->model->slug) }}">{{ $item->model->title }}</a>
        </p>
        {{ Form::hidden('', $item->model->id, ['class' => 'form-control', 'data-link' => 'model_id']) }}
    @endif
@endif

{{ Form::hidden('', $item->model_type, ['class' => 'form-control', 'data-link' => 'model_type']) }}


<a href="" class="text-danger remove-item">Remover</a>