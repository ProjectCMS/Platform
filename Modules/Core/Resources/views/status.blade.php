@inject('status', '\Modules\Core\Entities\Status')

<ul class="list-inline menu-item my-0">
    <li class="{{ Request::input('status') == '' ? 'active' : '' }}">
        <a href="{{ route('admin.'.$route) }}">Todos</a> ::
    </li>
    @foreach($status->all() as $all)
        <li class="{{ Request::input('status') == $all->id ? 'active' : '' }}">
            <a href="{{ route('admin.'.$route) }}?status={{ $all->id }}">{{ $all->name }}</a> ::
        </li>
    @endforeach
    <li class="{{ Request::input('status') == '0' ? 'active' : '' }}">
        <a href="{{ route('admin.'.$route) }}?status=0">Lixeira</a>
    </li>
</ul>