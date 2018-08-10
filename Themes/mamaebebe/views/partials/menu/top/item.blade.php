@php
    $menu = get_menus('top');
    if($menu){
        $menu = $menu->items;
        $menu = collect($menu);
        $menu = $menu->prepend((object) ['title' => 'Home', 'url' => '/', 'children' => collect([])]);
        $menu = $menu->chunk(ceil($menu->count() / 2));
    }
@endphp

<ul class="navbar-nav ml-auto">
    @if($menu[0])
        @foreach($menu[0] as $item)
            <li class="nav-item {{ ($item->children->count() ? 'dropdown' : '') }}">
                @if(isset($item->provider) && $item->provider())
                    @if($item->provider_type == 'categories')
                        <a class="nav-link" href="{{ route('web.posts.category', $item->provider->slug) }}" title="{{ $item->title }}">{{ $item->title }}</a>
                    @else
                        <a class="nav-link" href="{{ url($item->provider->slug) }}" title="{{ $item->title }}">{{ $item->title }}</a>
                    @endif
                @else
                    <a class="nav-link" href="{{ $item->url }}" title="{{ $item->title }}">{{ $item->title }}</a>
                @endif
                @if($item->children->count())
                    @include('partials.menu.top.submenu-item', ['items' => $item->children])
                @endif
            </li>
        @endforeach
    @endif
</ul>
<a class="navbar-brand" href="{{ url('/') }}" title="{{ setting('site_name') }}">
    <div class="logo">
        <div class="container">
            <img src="{{ asset('storage/filemanager/logo.png') }}" height="50">
        </div>
    </div>
</a>
<ul class="navbar-nav mr-auto">
    @if($menu[1])
        @foreach($menu[1] as $item)
            <li class="nav-item {{ ($item->children->count() ? 'dropdown' : '') }}">
                @if(isset($item->provider) && $item->provider())
                    @if($item->provider_type == 'categories')
                        <a class="nav-link" href="{{ route('web.posts.category', $item->provider->slug) }}" title="{{ $item->title }}">{{ $item->title }}</a>
                    @else
                        <a class="nav-link" href="{{ url($item->provider->slug) }}" title="{{ $item->title }}">{{ $item->title }}</a>
                    @endif
                @else
                    <a class="nav-link" href="{{ $item->url }}" title="{{ $item->title }}">{{ $item->title }}</a>
                @endif
                @if($item->children->count())
                    @include('partials.menu.top.submenu-item', ['items' => $item->children])
                @endif
            </li>
        @endforeach
    @endif
</ul>