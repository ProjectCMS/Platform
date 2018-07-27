@extends('users::layouts.master')

@section('title_icon', 'dripicons-user-group')
@section('title_prefix', 'Permissões')

@section('content')

    @include ('core::status-messages')

    <div class="wrapper">
        <div class="container-fluid">

            <div class="card m-b-20">
                <div class="card-body">

                    <a href="{{ route('admin.permissions.create') }}" class="btn btn-outline-secondary btn-round mb-3" role="button"><i class="fa fa-plus"></i> {{ trans('dashboard::dashboard.form.create') }}
                    </a>

                    @include ('core::status-messages')

                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th data-sort="id" width="80" class="text-center">ID</th>
                            <th data-sort="title">Legenda</th>
                            <th data-sort="title">Regras</th>
                            <th data-sort="title">Total de rotas</th>
                            <th data-sort="updated_at" width="150">Data</th>
                            <th width="90">Opções</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($paginate as $data)
                            <tr>
                                <td class="text-center">{{ $data->id }}</td>
                                <td>{{ $data->label }}</td>
                                <td>
                                    @foreach($data->roles as $role)
                                        <span class="badge badge-outline-secondary">{{ $role->label }}</span>
                                    @endforeach
                                </td>
                                <td>{{ $data->routes->count() }}</td>
                                <td>
                                    @if($data->created_at == $data->updated_at)
                                        Criado
                                        <br>
                                        <abbr title="{{ $data->created_at_full }}">{{ $data->created_at_cm }}</abbr>
                                    @else
                                        Atualizado
                                        <br>
                                        <abbr title="{{ $data->updated_at_full }}">{{ $data->updated_at_cm }}</abbr>
                                    @endif
                                </td>
                                  <td>
                                    <div class="btn-group-sm">
                                        <a href="{{ route('admin.permissions.edit', $data->id) }}" title="{{ trans('dashboard::dashboard.form.edit') }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('admin.permissions.delete') }}" title="{{ trans('dashboard::dashboard.form.delete') }}" class="btn btn-danger ajax-action" data-method="delete" data-id="{{ $data->id }}"><i class="fa fa-close"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <td class="colspanchange" colspan="7">Nenhum resultado encontrado.</td>
                        @endforelse
                    </table>

                    {{ $paginate->appends(Request::all())->links() }}

                </div>
            </div>
        </div>
    </div>

@stop

