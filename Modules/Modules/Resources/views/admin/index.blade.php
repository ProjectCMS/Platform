@extends('modules::admin.layouts.master')

@section('content_header')
    <h1>Módulos</h1>
    {{ Breadcrumbs::render('admin.modules') }}
@stop

@section('content')

    <div class="box">

        <div class="box-header with-border">
        </div>

        <div class="box-body">

            <table class="table table-hover table-bordered" data-href="{{ route('admin.modules.switch') }}">
                <thead>
                <tr>
                    <th width="150">Nome</th>
                    <th>Descrição</th>
                    <th class="text-center" width="110">Status</th>
                    <th class="text-center" width="110">Ordem</th>
                    <th class="text-center" width="130">Habilitado</th>
                </tr>
                </thead>
                <tbody>
                @foreach($modules as $key => $module)
                    <tr>
                        <td><b>{{ $module->name }}</b></td>
                        <td>{{ $module->json()->description }}</td>
                        @if($module->json()->active == 1)
                            <td class="text-center"><span class="label label-success">Habilitado</span></td>
                        @else
                            <td class="text-center"><span class="label label-danger">Desabilitado</span></td>
                        @endif
                        <td class="text-center">{{ $module->json()->order }}</td>
                        <td class="text-center">
                            <div class="ui-switch ui-switch-sm ui-inline ui-success">
                                <input id="switchr-{{ $key }}" class="ajax-module" type="checkbox" name="module" value="{{ $module->json()->alias }}" {{ $module->json()->active == 1 ? 'checked' : '' }}>
                                <label for="switchr-{{ $key }}"></label>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@stop