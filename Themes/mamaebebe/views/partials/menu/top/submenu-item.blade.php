<ul>
    @foreach($items as $item)
        <li class="nav-item {{ ($item->children->count() ? 'dropdown' : '') }}">
            @if($item->provider())
                @if($item->provider_type == 'categories')
                    <a class="nav-item nav-link" href="{{ route('web.posts.category', $item->provider->slug) }}" title="{{ $item->title }}">{{ $item->title }}</a>
                @else
                    <a class="nav-item nav-link" href="{{ url($item->provider->slug) }}" title="{{ $item->title }}">{{ $item->title }}</a>
                @endif
            @else
                <a class="nav-item nav-link" href="{{ $item->url }}" title="{{ $item->title }}">{{ $item->title }}</a>
            @endif
            @if($item->children->count())
                @include('partials.menu.top.submenu-item', ['items' => $item->children])
            @endif
        </li>
    @endforeach
</ul>