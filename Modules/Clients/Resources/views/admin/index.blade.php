@extends('clients::admin.layouts.master')

@section('title_icon', 'dripicons-user-group')
@section('title_prefix', 'Clientes')

@section('content')

    @include ('core::status-messages')

    <div class="wrapper">
        <div class="container-fluid">

            <div class="card m-b-20">
                <div class="card-body">

                    <a href="{{ route('admin.clients.create') }}" class="btn btn-outline-secondary btn-round mb-3" role="button"><i class="fa fa-plus"></i> {{ trans('dashboard::dashboard.form.create') }}
                    </a>

                    @include ('core::status-messages')

                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th data-sort="id" width="80" class="text-center">ID</th>
                            <th data-sort="title">Nome</th>
                            <th data-sort="email" width="300">E-mail</th>
                            <th width="90">Opções</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($paginate as $data)
                            <tr>
                                <td class="text-center">{{ $data->id }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->email }}</td>
                                <td>
                                    <div class="btn-group-sm">
                                        <a href="{{ route('admin.clients.edit', $data->id) }}" title="{{ trans('dashboard::dashboard.form.edit') }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('admin.clients.delete') }}" title="{{ trans('dashboard::dashboard.form.delete') }}" class="btn btn-danger ajax-action" data-method="delete" data-id="{{ $data->id }}"><i class="fa fa-close"></i></a>
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


