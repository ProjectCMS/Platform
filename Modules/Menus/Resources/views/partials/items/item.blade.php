@foreach($data as $item)
    <li class="dd-item" data-id="{{ $item->tmp_id }}">
        <div class="dd-handle dd3-handle"></div>
        <a href="#cl-{{ $item->tmp_id }}" class="dd3-content" data-toggle="collapse" role="button" aria-expanded="false">{{ $item->title }}</a>
        <div class="collapse" id="cl-{{ $item->tmp_id }}">
            <div class="card card-body">
                @include('menus::partials.items.form', compact('item', 'new'))
            </div>
        </div>
    </li>
@endforeach