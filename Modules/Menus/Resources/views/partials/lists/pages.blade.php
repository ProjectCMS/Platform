@inject('page', '\Modules\Pages\Entities\Page')

<div class="parent-menu" data-type="pages">
    <ul class="list-unstyled list-checks">
        @foreach($page->where("parent_id", 0)->with('children')->get() as $pg)
            <li>
                <div class="custom-control custom-checkbox">
                    <input id="checkboxs-p-{{ $pg->id }}" class="custom-control-input" type="checkbox" name="item[]" value="{{ $pg->id }}"><span></span>
                    <label class="custom-control-label" for="checkboxs-p-{{ $pg->id }}">{{ $pg->title }}</label>
                </div>
                <ul class="list-unstyled">
                    @foreach($pg->children as $children)
                        <li>
                            <div class="custom-control custom-checkbox">
                                <input id="checkboxs-p-{{ $children->id }}" class="custom-control-input" type="checkbox" name="item[]" value="{{ $children->id }}"><span></span>
                                <label class="custom-control-label" for="checkboxs-p-{{ $children->id }}">{{ $children->title }}</label>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
    {{ Form::button('<i class="fa fa-plus"></i> Adicionar ao menu', ['class' => 'btn btn-outline-secondary waves-effect waves-light mt-3 add-item-menu']) }}
</div>