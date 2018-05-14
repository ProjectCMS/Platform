<li class="has-submenu">
    <a href="{{ $item['href'] }}"><i class="{{ $item['icon'] or 'dripicons-media-record'}}"></i>{{ $item['text'] }}

        @if (isset($item['submenu']))
            <i class="mdi mdi-chevron-down mdi-drop"></i>
        @endif

    </a>
    @if (isset($item['submenu']))
        <ul class="submenu">
            @each('partials.menu.submenu-item', $item['submenu'], 'item')
        </ul>
    @endif
</li>
