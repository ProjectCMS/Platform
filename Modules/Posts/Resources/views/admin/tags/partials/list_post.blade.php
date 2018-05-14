@inject('tags', '\Modules\Posts\Entities\Tag')

<div class="input-group">
    {{ Form::text('', NULL, ['class' => 'form-control tag-input']) }}
    <span class="input-group-btn"><button type="button" class="btn btn-outline-default insert-tag"><i class="fa fa-plus"></i> {{ trans('dashboard::dashboard.form.add') }}</button></span>
</div>
<i class="help-block">Separe as tags com vírgulas</i>

<ul class="tags list-inline">
    @if(isset($selected))
        @foreach($selected as $tag)
            <li class="list-inline-item" data-name="{{ $tag->name }}">
                <span></span>
                {{ $tag->name }}
            </li>
        @endforeach
    @endif
</ul>

<div class="form-group d-none {{ $errors->has('tag') ? 'has-error' : '' }}">
    {{ Form::select('tag[]', [], '', ['class' => 'form-control tag-select', 'multiple' => 'multiple']) }}
</div>

<div class="d-none" data-tags="{{ $tags->pluck('name')->toJson() }}"></div>

