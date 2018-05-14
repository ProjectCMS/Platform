@extends('posts::admin.layouts.master')

@section('title_prefix', 'Categorias')

@section('content')

    <div class="wrapper">
        <div class="container-fluid">

            <div class="card m-b-20">
                <div class="card-body">

                    <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-secondary btn-round mb-3" role="button"><i class="fa fa-plus"></i> {{ trans('dashboard::dashboard.form.create') }}
                    </a>

                    @include ('core::status-messages')

                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th data-sort="id" width="80" class="text-center">ID</th>
                            <th data-sort="name">Nome</th>
                            <th data-sort="slug">Slug</th>
                            <th>Grupo</th>
                            <th data-sort="posts_count" width="150">Total de posts</th>
                            <th data-sort="updated_at" width="150">Data</th>
                            <th width="100">Opções</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($paginate as $data)
                            <tr>
                                <td class="text-center">{{ $data->id }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->slug }}</td>
                                <td>{{ $data->parent->name }}</td>
                                <td>{{ $data->posts_count }}</td>
                                <td>
                                    @if($data->created_at == $data->updated_at)
                                        Publicado
                                        <br>
                                        <abbr title="{{ Date::parse($data->created_at)->format('d F, Y H:i') }}">{{ Date::parse($data->created_at)->format('d F, Y') }}</abbr>
                                    @else
                                        Atualizado
                                        <br>
                                        <abbr title="{{ Date::parse($data->updated_at)->format('d F, Y H:i') }}">{{ Date::parse($data->updated_at)->format('d F, Y') }}</abbr>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group-sm">
                                        <a href="{{ route('admin.categories.edit', $data->id) }}" title="{{ trans('dashboard::dashboard.form.edit') }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('admin.categories.delete') }}" title="{{ trans('dashboard::dashboard.form.delete') }}" class="btn btn-danger ajax-action" data-method="delete" data-id="{{ $data->id }}"><i class="fa fa-close"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{ $paginate->appends(Request::all())->links() }}

                </div>
            </div>
        </div>
    </div>

@stop
