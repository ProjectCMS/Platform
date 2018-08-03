@extends('posts::admin.layouts.master')

@section('title_prefix', trans('dashboard::dashboard.page.create'))

@section('content')

    {!! Form::open(['route' => 'admin.posts.tags.store', 'method' => 'post']) !!}
    <div class="wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12 col-lg">
                    @include('posts::admin.tags.partials.form')
                </div>

                <div class="col col-flex flex-400">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">Informações</h4>
                            <p><i class="fa fa-calendar"></i> Criado: <b class="pull-right">---</b></p>
                            <p><i class="fa fa-calendar"></i> Editado: <b class="pull-right">---</b></p>
                        </div>
                        <div class="card-footer">
                            {{ Form::button('<i class="fa fa-check"></i> '.trans('dashboard::dashboard.form.save'), ['class' => 'btn btn-success pull-right waves-effect waves-light', 'type' => 'submit']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop()