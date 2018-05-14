<ol class="dd-list">
    @foreach($item as $data)
        <li class="dd-item" data-id="{{ $data->id }}">
            <div class="dd-handle"></div>
            <div class="dd-content">
                <a href="{{ route('admin.pages.edit', $data->id) }}">{{ $data->title }}</a>
                <div class="dd-right">
                    <div class="btn-group-sm">
                        @if($data->deleted_at == null)
                            <a href="{{ route('admin.pages.trash') }}" title="{{ trans('dashboard::dashboard.form.trash') }}" class="btn btn-default ajax-action" data-method="delete" data-id="{{ $data->id }}"><i class="fa fa-trash"></i></a>
                        @else
                            <a href="{{ route('admin.pages.restore') }}" title="{{ trans('dashboard::dashboard.form.restore') }}" class="btn btn-warning ajax-action" data-method="put" data-id="{{ $data->id }}"><i class="fa fa-refresh"></i></a>
                        @endif
                        <a href="{{ route('admin.pages.edit', $data->id) }}" title="{{ trans('dashboard::dashboard.form.edit') }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                        <a href="{{ route('admin.pages.delete') }}" title="{{ trans('dashboard::dashboard.form.delete') }}" class="btn btn-danger ajax-action" data-method="delete" data-id="{{ $data->id }}"><i class="fa fa-close"></i></a>
                    </div>
                </div>
            </div>
            @if(count($data->children))
                @include('pages::admin.partials.nestable-item', ["item" => $data->children])
            @endif
        </li>
    @endforeach
</ol>
