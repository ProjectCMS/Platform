@if($item->provider_type == 'link')
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
    @if(isset($item->provider))
        <p class="link-original">
            <i>Original:</i> <a href="{{ url($item->provider->slug) }}">{{ $item->provider->title }}</a>
        </p>
        {{ Form::hidden('', $item->provider->id, ['class' => 'form-control', 'data-link' => 'provider_id']) }}
    @endif
@else
    @if($item->provider())
        <p class="link-original">
        <i>Original:</i> <a href="{{ url($item->provider->slug) }}">{{ $item->provider->title }}</a>
        </p>
        {{ Form::hidden('', $item->provider->id, ['class' => 'form-control', 'data-link' => 'provider_id']) }}
    @endif
@endif

{{ Form::hidden('', $item->provider_type, ['class' => 'form-control', 'data-link' => 'provider_type']) }}


<a href="" class="text-danger remove-item">Remover</a>