@extends('pages::admin.layouts.master')

@section('title_icon', 'dripicons-copy')
@section('title_prefix', trans('dashboard::dashboard.page.edit'))

@section('content')

    {!! Form::model($data, ['route' => ['admin.pages.update', $data->id], 'method' => 'put']) !!}
    <div class="wrapper">
        <div class="container-fluid">

            <div class="card m-b-20">
                <div class="card-body">
                    <div class="pull-right">
                        <a href="{{ route('admin.pages.create') }}" title="{{ trans('dashboard::dashboard.form.create') }}" class="btn btn-outline-info btn-round"><i class="fa fa-plus"></i>
                            {{ trans('dashboard::dashboard.form.create') }}</a>
                        <a href="{{ route('admin.pages.delete') }}" title="{{ trans('dashboard::dashboard.form.delete') }}" class="btn btn-outline-danger btn-round ajax-action" data-method="delete" data-id="{{ $data->id }}"><i class="fa fa-close"></i> {{ trans('dashboard::dashboard.form.delete') }}
                        </a>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-xl-9 col-lg-8 col-md-12">
                    @include('pages::admin.partials.form')
                </div>

                <div class="col-xl-3 col-lg-4 col-md-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">Informações</h4>
                            <p><i class="fa fa-eye"></i> Status: <b class="pull-right">{{ $data->status->name }}</b></p>
                            <p><i class="fa fa-calendar"></i> Criado:
                                <b class="pull-right">{{ $data->created_at->format('d M, Y H:i') }}</b></p>
                            <p><i class="fa fa-calendar"></i> Editado:
                                <b class="pull-right">{{ $data->updated_at->format('d M, Y H:i') }}</b></p>
                        </div>
                        <div class="card-footer">
                            @if($data->deleted_at == NULL)
                                <a href="{{ route('admin.pages.trash') }}" title="{{ trans('dashboard::dashboard.form.trash') }}" class="btn btn-default ajax-action" data-method="delete" data-id="{{ $data->id }}"><i class="fa fa-trash"></i> {{ trans('dashboard::dashboard.form.trash') }}
                                </a>
                            @else
                                <a href="{{ route('admin.pages.restore') }}" title="{{ trans('dashboard::dashboard.form.restore') }}" class="btn btn-warning ajax-action" data-method="put" data-id="{{ $data->id }}"><i class="fa fa-refresh"></i> {{ trans('dashboard::dashboard.form.restore') }}
                                </a>
                            @endif
                            {{ Form::button('<i class="fa fa-check"></i> '. trans('dashboard::dashboard.form.save'), ['class' => 'btn btn-success pull-right', 'type' => 'submit']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

