@extends('pages::admin.layouts.master')

@section('title_icon', 'dripicons-copy')
@section('title_prefix', 'Concursos')

@section('content')

    <div class="wrapper">
        <div class="container-fluid">

            <div class="card m-b-20">
                <div class="card-body">

                    <a href="{{ route('admin.contents.create') }}" class="btn btn-outline-secondary btn-round mb-3 waves-effect waves-light" role="button"><i class="fa fa-plus"></i> {{ trans('dashboard::dashboard.form.create') }}
                    </a>

                    @include ('core::status-messages')

                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th data-sort="title">Título</th>
                            <th width="150">Inicia</th>
                            <th width="150">Finaliza</th>
                            <th width="150">Participantes</th>
                            <th width="130">Opções</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($paginate as $data)
                            <tr>
                                <td><a href="{{ route('admin.contents.edit', $data->id) }}"><b>{{ $data->title }}</b></a></td>
                                <td><abbr title="{{ $data->starts_at_full }}">{{ $data->starts_at_cm }}</abbr></td>
                                <td><abbr title="{{ $data->finalized_at_full }}">{{ $data->finalized_at_cm }}</abbr></td>
                                <td>{{ $data->participants->count() }}</td>
                                <td>
                                    <div class="btn-group-sm">
                                        <a href="{{ route('admin.contents.edit', $data->id) }}" title="{{ trans('dashboard::dashboard.form.edit') }}" class="btn btn-success waves-effect waves-light"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('admin.contents.delete') }}" title="{{ trans('dashboard::dashboard.form.delete') }}" class="btn btn-danger ajax-action waves-effect waves-light" data-method="delete" data-id="{{ $data->id }}"><i class="fa fa-close"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="no-items">
                                <td class="colspanchange" colspan="7">Nenhum resultado encontrado.</td>
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

