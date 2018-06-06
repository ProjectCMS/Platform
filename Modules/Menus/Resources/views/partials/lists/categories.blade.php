@inject('category', '\Modules\Posts\Entities\Category')

<div class="parent-menu" data-type="categories">
    <ul class="list-unstyled list-checks">
        @foreach($category->where("parent_id", 0)->with('children')->get() as $cat)
            <li>
                <div class="custom-control custom-checkbox">
                    <input id="checkboxs-c-{{ $cat->id }}" class="custom-control-input" type="checkbox" name="category[]" value="{{ $cat->id }}"><span></span>
                    <label class="custom-control-label" for="checkboxs-c-{{ $cat->id }}">{{ $cat->title }}</label>
                </div>
                <ul class="list-unstyled">
                    @foreach($cat->children as $children)
                        <li>
                            <div class="custom-control custom-checkbox">
                                <input id="checkboxs-c-{{ $children->id }}" class="custom-control-input" type="checkbox" name="category[]" value="{{ $children->id }}"><span></span>
                                <label class="custom-control-label" for="checkboxs-c-{{ $children->id }}">{{ $children->title }}</label>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
    {{ Form::button('<i class="fa fa-plus"></i> Adicionar ao menu', ['class' => 'btn btn-outline-secondary waves-effect waves-light mt-3 add-item-menu']) }}
</div>