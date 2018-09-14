@php
    $menu = get_menus('top');
    if($menu){
        $menu = $menu->items;
        $menu = collect($menu);
        $menu = $menu->prepend((object) ['title' => 'Home', 'url' => '/', 'children' => collect([])]);
    }
@endphp

<nav class="sidebar-menu">
    <div class="sidebar-header">
        <img src="{{ image_resize('filemanager/logo.png', 60, null, 100) }}" width="100%">
    </div>
    <div class="content">
        <ul class="list-unstyled components">

            @foreach($menu as $item)
                <li class="{{ ($item->children->count() ? 'dropdown' : '') }}">
                    @if($item->children->count())
                        <a href="#{{ $item->id }}" data-toggle="collapse" class="" aria-expanded="true" title="{{ $item->title }}">{{ $item->title }}</a>
                        @include('partials.menu.sidebar.submenu-item', ['items' => $item->children])
                    @else
                        @if(isset($item->model))
                            @if($item->model->model_type == 'categories')
                                <a href="{{ route('web.posts.category', $item->model->slug) }}" title="{{ $item->title }}">{{ $item->title }}</a>
                            @else
                                <a href="{{ url($item->model->slug) }}" title="{{ $item->title }}">{{ $item->title }}</a>
                            @endif
                        @else
                            <a href="{{ $item->url }}" title="{{ $item->title }}">{{ $item->title }}</a>
                        @endif
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</nav>
