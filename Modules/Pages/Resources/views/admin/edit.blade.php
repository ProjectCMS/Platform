@extends('pages::admin.layouts.master')

@section('title_prefix', trans('dashboard::dashboard.page.edit'). ' - ')

@section('content_header')
    <h1>{{ trans('dashboard::dashboard.page.edit') }}
        <small>{{ $data->title }}</small>
    </h1>
    {{ Breadcrumbs::render('admin.pages.edit', $data) }}
@stop

@section('content')

    {!! Form::model($data, ['route' => ['admin.pages.update', $data->id], 'method' => 'put']) !!}

    <div class="row">
        <div class="col-lg-9 col-md-8">
            <div class="box">

                <div class="box-header with-border">
                    <div class="pull-right">
                        <a href="{{ route('admin.pages.create') }}" title="{{ trans('dashboard::dashboard.form.create') }}" class="btn btn-info"><i class="fa fa-plus"></i> {{ trans('dashboard::dashboard.form.create') }}
                        </a>
                        <a href="{{ route('admin.pages.delete') }}" title="{{ trans('dashboard::dashboard.form.delete') }}" class="btn btn-danger ajax-action" data-method="delete" data-id="{{ $data->id }}"><i class="fa fa-close"></i> {{ trans('dashboard::dashboard.form.delete') }}
                        </a>
                    </div>

                </div>

                @include('pages::admin.partials.form')

            </div>
        </div>
        <div class="col-lg-3 col-md-4">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Informações</h3>
                </div>

                <div class="box-body">
                    <p><i class="fa fa-eye"></i> Status: <b class="pull-right">{{ $data->status->name }}</b></p>
                    <p><i class="fa fa-calendar"></i> Criado:
                        <b class="pull-right">{{ $data->created_at->format('d M, Y H:i') }}</b></p>
                    <p><i class="fa fa-calendar"></i> Editado:
                        <b class="pull-right">{{ $data->updated_at->format('d M, Y H:i') }}</b></p>
                </div>

                <div class="box-footer">
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

    {!! Form::close() !!}
@stop()