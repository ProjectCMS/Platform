@inject('category', '\Modules\Posts\Entities\Category')

<ul class="list-unstyled list-checks">
    @foreach($category->where("parent_id", 0)->with('children')->get() as $cat)
        <li>
            <div class="custom-control custom-checkbox">
                <input id="checkboxs-{{ $cat->id }}" class="custom-control-input" type="checkbox" name="category[]" value="{{ $cat->id }}"
                       @if(isset($selected) && $selected->contains($cat->id)) checked @endif><span></span>
                {{ Form::label('checkboxs-'.$cat->id, $cat->title, ['class' => 'custom-control-label']) }}
            </div>
            <ul class="list-unstyled">
                @foreach($cat->children as $children)
                    <li>
                        <div class="custom-control custom-checkbox">
                            <input id="checkboxs-{{ $children->id }}" class="custom-control-input" type="checkbox" name="category[]" value="{{ $children->id }}"
                                   @if(isset($selected) && $selected->contains($children->id)) checked @endif><span></span>
                            {{ Form::label('checkboxs-'.$children->id, $children->title, ['class' => 'custom-control-label']) }}
                        </div>
                    </li>
                @endforeach
            </ul>
        </li>
    @endforeach
</ul>
