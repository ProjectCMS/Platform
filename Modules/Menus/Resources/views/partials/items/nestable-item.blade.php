<ol class="dd-list" id="{{ ($children == false ? 'dd-main' : '') }}">
    @foreach($items as $item)
        <li class="dd-item" data-id="{{ $item->id }}">
            <div class="dd-handle dd3-handle"></div>
            <a href="#cl-{{ $item->id }}" class="dd3-content" data-toggle="collapse" role="button" aria-expanded="false">{{ $item->title }}</a>
            <div class="collapse" id="cl-{{ $item->id }}">
                <div class="card card-body">
                    @include('menus::partials.items.form', compact('item'))
                </div>
            </div>
            @if(count($item->children))
                @include('menus::partials.items.nestable-item', ['items' => $item->children, 'children' => true])
            @endif
        </li>
    @endforeach
</ol>