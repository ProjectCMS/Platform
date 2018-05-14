<li class="@if(isset($item['submenu']))has-submenu @endif">
    <a href="{{ $item['href'] }}">{{ $item['text'] }}</a>
    @if (isset($item['submenu']))
        <ul class="submenu">
            @each('partials.menu.submenu-item', $item['submenu'], 'item')
        </ul>
    @endif
</li>