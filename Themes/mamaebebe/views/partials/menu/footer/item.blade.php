@php
    $menu = get_menus('footer');
    if($menu){
        $menu = $menu->items;
    }
@endphp

@if($menu)
    <ul class="navbar-nav m-auto">
        @foreach($menu as $item)
            <li class="nav-item">
                @if(isset($item->provider) && $item->provider())
                    @if($item->provider_type == 'categories')
                        <a class="nav-link" href="{{ route('web.posts.category', $item->provider->slug) }}">{{ $item->title }}</a>
                    @else
                        <a class="nav-link" href="{{ url($item->provider->slug) }}">{{ $item->title }}</a>
                    @endif
                @else
                    <a class="nav-link" href="{{ $item->url }}">{{ $item->title }}</a>
                @endif
            </li>

        @endforeach
    </ul>
@endif