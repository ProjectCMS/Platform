@extends('payments::admin.layouts.master')

@section('title_icon', 'dripicons-copy')
@section('title_prefix', 'Formas de pagamento')

@section('content')

    <div class="wrapper">
        <div class="container-fluid">

            <div class="card m-b-20">
                <div class="card-body">

                    @include ('core::status-messages')

                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th width="150"></th>
                            <th data-sort="title">Título</th>
                            <th data-sort="title" width="120">Status</th>
                            <th width="80">Opções</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($paginate as $data)
                            <tr>
                                @if($data->image != NULL)
                                    <td><img src="{{ asset('storage/'.$data->image) }}" height="30"></td>
                                @else
                                    <td></td>
                                @endif
                                <td>{{ $data->title }}</td>
                                <td>
                                    @switch($data->status)
                                        @case(0)
                                        <i class="mdi mdi-checkbox-blank-circle text-danger"></i> Inativo
                                        @break
                                        @case(1)
                                        <i class="mdi mdi-checkbox-blank-circle text-success"></i> Ativo
                                        @break
                                    @endswitch()
                                </td>
                                <td>
                                    <div class="btn-group-sm">
                                        <a href="{{ route('admin.settings.payments.edit', $data->id) }}" title="{{ trans('dashboard::dashboard.form.edit') }}" class="btn btn-success waves-effect waves-light"><i class="fa fa-edit"></i></a>
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

