@extends('posts::admin.layouts.master')

@section('title_icon', 'dripicons-feed')
@section('title_prefix', trans('dashboard::dashboard.page.edit'))

@section('content')

    {!! Form::model($data, ['route' => ['admin.posts.update', $data->id], 'method' => 'put']) !!}
    <div class="wrapper">
        <div class="container-fluid">

            <div class="card m-b-20">
                <div class="card-body">
                    <div class="pull-right">
                        <a href="{{ route('admin.posts.create') }}" title="{{ trans('dashboard::dashboard.form.create') }}" class="btn btn-outline-info btn-round waves-effect waves-light"><i class="fa fa-plus"></i>
                            {{ trans('dashboard::dashboard.form.create') }}</a>
                        <a href="{{ route('admin.posts.delete') }}" title="{{ trans('dashboard::dashboard.form.delete') }}" class="btn btn-outline-danger btn-round ajax-action waves-effect waves-light" data-method="delete" data-id="{{ $data->id }}"><i class="fa fa-close"></i> {{ trans('dashboard::dashboard.form.delete') }}
                        </a>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg">
                    @include('posts::admin.posts.partials.form')
                </div>

                <div class="col col-flex flex-400">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">Informações</h4>
                            <p><i class="fa fa-eye"></i> Status: <b class="pull-right">{{ $data->status->title }}</b>
                            </p>
                            <p><i class="fa fa-calendar"></i> Criado:
                                <b class="pull-right">{{ $data->created_at_cm }}</b></p>
                            <p><i class="fa fa-calendar"></i> Editado:
                                <b class="pull-right">{{ $data->updated_at_cm }}</b></p>
                        </div>
                        <div class="card-footer">
                            @if($data->deleted_at == NULL)
                                <a href="{{ route('admin.posts.trash') }}" title="{{ trans('dashboard::dashboard.form.trash') }}" class="btn btn-link ajax-action waves-effect waves-light" data-method="delete" data-id="{{ $data->id }}"><i class="fa fa-trash"></i>
                                    Mover para lixeira</a>
                            @else
                                <a href="{{ route('admin.posts.restore') }}" title="{{ trans('dashboard::dashboard.form.restore') }}" class="btn btn-link ajax-action waves-effect waves-light" data-method="put" data-id="{{ $data->id }}"><i class="fa fa-refresh"></i>
                                    Remover da lixeira</a>
                            @endif
                            {{ Form::button('<i class="fa fa-check"></i> '.trans('dashboard::dashboard.form.save'), ['class' => 'btn btn-success pull-right waves-effect waves-light', 'type' => 'submit']) }}
                        </div>
                    </div>

                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">Categorias</h4>
                            @include ('posts::admin.categories.partials.list_post', ["selected" => $data->categories->pluck('id')])
                        </div>
                    </div>

                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">Tags</h4>
                            @include ('posts::admin.tags.partials.list_post', ["selected" => $data->tags])
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    {!! Form::close() !!}
@stop()