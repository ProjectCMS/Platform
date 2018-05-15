@extends('posts::admin.layouts.master')

@section('title_icon', 'dripicons-feed')
@section('title_prefix', 'Blog')

@section('content')

    <div class="wrapper">
        <div class="container-fluid">

            <div class="card m-b-20">
                <div class="card-body">
                    <section class="d-flex align-items-center">
                        @include('core::status', ['route' => 'posts'])

                        {!! Form::open(['route' => 'admin.posts', 'method' => 'get', 'class' => 'form-inline ml-auto']) !!}

                        <div class="form-group mr-sm-2">
                            {{ Form::select('date', $dates, '', ['class' => 'form-control']) }}
                        </div>

                        <div class="form-group mr-sm-2">
                            {{ Form::select('category_id', $categories, '', ['class' => 'form-control']) }}
                        </div>

                        <div class="form-group mr-sm-2">
                            {{ Form::text('search', NULL, ['class' => 'form-control', 'placeholder' => 'Título']) }}
                        </div>

                        {{ Form::button('Filtrar registros', ['class' => 'btn btn-outline-primary btn-round', 'type' => 'submit']) }}

                        <hr>
                        {!! Form::close() !!}

                    </section>

                </div>
            </div>

            <div class="card m-b-20">
                <div class="card-body">

                    <a href="{{ route('admin.posts.create') }}" class="btn btn-outline-secondary btn-round mb-3" role="button"><i class="fa fa-plus"></i> {{ trans('dashboard::dashboard.form.create') }}
                    </a>

                    @include ('core::status-messages')

                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th data-sort="title">Título</th>
                            <th data-sort="author" width="200" class="text-center">Autor</th>
                            <th width="250">Categorias</th>
                            <th width="250">Tags</th>
                            <th data-sort="updated_at" width="150">Data</th>
                            <th width="130">Opções</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($paginate as $data)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.posts.edit', $data->id) }}"><b>{{ ($data->title ? $data->title : "(sem título)") }}</b></a>
                                    @if($data->status_id != 1)
                                        <span><b> — {{ $data->status->name }}</b></span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="?author={{ $data->author->name }}">{{ $data->author->name }}</a></td>
                                <td>
                                    @forelse($data->categories as $category)
                                        <a href="?category_name={{ $category->name }}">{{ $category->name }}</a>
                                        @if(!$loop->last),@endif
                                    @empty
                                        ----
                                    @endforelse
                                </td>
                                <td>
                                    @forelse($data->tags as $tag)
                                        <a href="?tag_name={{ $tag->name }}">{{ $tag->name }}</a>
                                        @if(!$loop->last),@endif
                                    @empty
                                        ----
                                    @endforelse
                                </td>
                                <td>
                                    @if($data->created_at == $data->updated_at)
                                        Criado
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
                                        @if($data->deleted_at == NULL)
                                            <a href="{{ route('admin.posts.trash') }}" title="{{ trans('dashboard::dashboard.form.trash') }}" class="btn btn-secondary ajax-action" data-method="delete" data-id="{{ $data->id }}"><i class="fa fa-trash"></i></a>
                                        @else
                                            <a href="{{ route('admin.posts.restore') }}" title="{{ trans('dashboard::dashboard.form.restore') }}" class="btn btn-warning ajax-action" data-method="put" data-id="{{ $data->id }}"><i class="fa fa-refresh"></i></a>
                                        @endif
                                        <a href="{{ route('admin.posts.edit', $data->id) }}" title="{{ trans('dashboard::dashboard.form.edit') }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('admin.posts.delete') }}" title="{{ trans('dashboard::dashboard.form.delete') }}" class="btn btn-danger ajax-action" data-method="delete" data-id="{{ $data->id }}"><i class="fa fa-close"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="no-items">
                                <td class="colspanchange" colspan="7">Nenhum post encontrado.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    {{ $paginate->appends(Request::all())->links() }}

                </div>
            </div>

        </div>
    </div>

@stop
