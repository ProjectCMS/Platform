@extends('posts::admin.layouts.master')

@section('title_prefix', trans('dashboard::dashboard.page.edit'). ' - ')

@section('content_header')
    <h1>{{ trans('dashboard::dashboard.page.create') }}
        <small>Nova tag</small>
    </h1>
    {{ Breadcrumbs::render('admin.tags.create') }}
@stop

@section('content')

    {!! Form::open(['route' => 'admin.tags.store', 'method' => 'post']) !!}

    <div class="row">

        <div class="col-lg-9 col-md-8">
            <div class="box">

                <div class="box-header with-border">
                </div>

                @include('posts::admin.tags.partials.form')

            </div>
        </div>

        <div class="col-lg-3 col-md-4">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Informações</h3>
                </div>

                <div class="box-body">
                    <p><i class="fa fa-eye"></i> Status: <b class="pull-right">---</b></p>
                    <p><i class="fa fa-calendar"></i> Publicado: <b class="pull-right">---</b></p>
                    <p><i class="fa fa-calendar"></i> Editado: <b class="pull-right">---</b></p>
                </div>

                <div class="box-footer">
                    {{ Form::button('<i class="fa fa-check"></i> ' .trans('dashboard::dashboard.form.save'), ['class' => 'btn btn-success pull-right', 'type' => 'submit']) }}
                </div>

            </div>
        </div>

    </div>

    {!! Form::close() !!}
@stop()