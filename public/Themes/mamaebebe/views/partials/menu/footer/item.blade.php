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
                @if(isset($item->model))
                    @if($item->model->model_type == 'categories')
                        <a class="nav-link" href="{{ route('web.posts.category', $item->model->slug) }}" title="{{ $item->title }}">{{ $item->title }}</a>
                    @else
                        <a class="nav-link" href="{{ url($item->model->slug) }}" title="{{ $item->title }}">{{ $item->title }}</a>
                    @endif
                @else
                    <a class="nav-link" href="{{ $item->url }}" title="{{ $item->title }}">{{ $item->title }}</a>
                @endif
            </li>

        @endforeach
    </ul>
@endif