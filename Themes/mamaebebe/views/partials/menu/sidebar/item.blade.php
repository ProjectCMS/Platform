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
        <img src="{{ asset('storage/filemanager/logo.png') }}" width="100%">
    </div>
    <div class="content">
        <ul class="list-unstyled components">

            @foreach($menu as $item)
                <li class="{{ ($item->children->count() ? 'dropdown' : '') }}">
                    @if($item->children->count())
                        <a href="#{{ $item->id }}" data-toggle="collapse" class="" aria-expanded="true">{{ $item->title }}</a>
                        @include('partials.menu.sidebar.submenu-item', ['items' => $item->children])
                    @else
                        @if(isset($item->provider) && $item->provider())
                            @if($item->provider_type == 'categories')
                                <a href="{{ route('web.posts.category', $item->provider->slug) }}">{{ $item->title }}</a>
                            @else
                                <a href="{{ url($item->provider->slug) }}">{{ $item->title }}</a>
                            @endif
                        @else
                            <a href="{{ $item->url }}">{{ $item->title }}</a>
                        @endif
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</nav>
