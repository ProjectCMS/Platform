<div class="parent-link">
    <div class="form-group">
        {{ Form::label('link-url', 'URL') }}
        {{ Form::text('', 'http://', ['class' => 'form-control', 'data-link' => 'url']) }}
    </div>

    <div class="form-group">
        {{ Form::label('link-title', 'Rótulo de navegação') }}
        {{ Form::text('', NULL, ['class' => 'form-control', 'data-link' => 'title']) }}
    </div>

    {{ Form::button('<i class="fa fa-plus"></i> Adicionar ao menu', ['class' => 'btn btn-outline-secondary waves-effect waves-light add-item-menu-link']) }}

</div>