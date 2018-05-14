@extends('magazine::admin.layouts.master')

@section('title_prefix', trans('dashboard::dashboard.page.create'). ' - ')

@section('content_header')
    <h1>{{ trans('dashboard::dashboard.page.create') }}
        <small>Criar nova revista</small>
    </h1>
    {{ Breadcrumbs::render('admin.magazine.create') }}
@stop

@section('content')

    {!! Form::open(['route' => 'admin.magazine.store', 'method' => 'post']) !!}

    <div class="row">

        <div class="col-lg-9 col-md-8">
            <div class="box">

                <div class="box-header with-border">
                </div>

                @include('magazine::admin.partials.form')

            </div>
        </div>

        <div class="col-lg-3 col-md-4">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Informações</h3>
                </div>

                <div class="box-body">
                    <p><i class="fa fa-eye"></i> Status: <b class="pull-right">---</b></p>
                    <p><i class="fa fa-calendar"></i> Criado em: <b class="pull-right">---</b></p>
                    <p><i class="fa fa-calendar"></i> Editado em: <b class="pull-right">---</b></p>
                </div>

                <div class="box-footer">
                    {{ Form::button('<i class="fa fa-check"></i> '. trans('dashboard::dashboard.form.save'), ['class' => 'btn btn-success pull-right', 'type' => 'submit']) }}
                </div>

            </div>
        </div>

    </div>

    {!! Form::close() !!}
@stop()