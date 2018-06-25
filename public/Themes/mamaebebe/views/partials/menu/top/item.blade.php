<ul class="navbar-nav m-auto">
    @if(get_menus('top'))
        @foreach(get_menus('top')->items as $item)
            <li class="nav-item {{ ($item->children->count() ? 'dropdown' : '') }}">
                @if($item->provider())
                    @if($item->provider_type == 'categories')
                        <a class="nav-item nav-link" href="{{ route('web.posts.category', $item->provider->slug) }}">{{ $item->title }}</a>
                    @else
                        <a class="nav-item nav-link" href="{{ url($item->provider->slug) }}">{{ $item->title }}</a>
                    @endif
                @else
                    <a class="nav-item nav-link" href="{{ $item->url }}">{{ $item->title }}</a>
                @endif
                @if($item->children->count())
                    @include('partials.menu.top.submenu-item', ['items' => $item->children])
                @endif
            </li>
        @endforeach
        <li class="nav-item"><a class="nav-item nav-link search" href="#">
                <i class="fa fa-search" aria-hidden="true"></i>
            </a>
        </li>
    @endif
</ul>