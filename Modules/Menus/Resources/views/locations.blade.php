@extends('menus::layouts.master')

@section('title_icon', 'dripicons-menu')
@section('title_prefix', 'Editar Posições')

@section('content')
    {!! Form::open(['route' => 'admin.settings.menus.locations.update', 'method' => 'PUT']) !!}
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card m-b-20">
                        <div class="card-header">
                            <div class="pull-right">
                                <a href="{{ route('admin.settings.menus') }}" class="btn btn-outline-success btn-round waves-effect waves-light"><i class="fa fa-tasks" aria-hidden="true"></i>
                                    Gerenciar menus</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <h4 class="mt-0 header-title">Estrutura das posições</h4>
                            <p class="text-muted">Seu tema suporta {{ count($locations) }} menus. Selecione o menu que
                                aparece em
                                cada lugar.</p>

                            <table class="table table-striped table-bordered w-50">
                                <thead>
                                <tr>
                                    <th>Posição no tema</th>
                                    <th>Menu atribuído</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($locations as $key => $location)
                                    <tr>
                                        <td scope="row">{{ $location->name }}</td>
                                        <td>
                                            {{ Form::select('location['.$location->key.']', $menu->pluck('title', 'id')->prepend('— Selecionar um menu —', ''), ($location->location != null ? $location->location->menu_id : ''), ['class' => 'form-control set-menu w-100']) }}
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                                </tbody>
                            </table>

                        </div>
                        <div class="card-footer">
                            <div class="pull-right">
                                {{ Form::button('<i class="fa fa-check"></i> Salvar alterações', ['class' => 'btn btn-outline-primary btn-round waves-effect waves-light ml-auto', 'type' => 'submit']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop