@extends('posts::admin.layouts.master')

@section('title_icon', 'dripicons-feed')
@section('title_prefix', trans('dashboard::dashboard.page.create'))

@section('content')

    {!! Form::open(['route' => 'admin.posts.store', 'method' => 'post']) !!}

    <div class="wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-xl-9 col-lg-8 col-md-12">
                    @include('posts::admin.posts.partials.form')
                </div>

                <div class="col-xl-3 col-lg-4 col-md-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">Informações</h4>
                            <p><i class="fa fa-eye"></i> Status: <b class="pull-right">---</b></p>
                            <p><i class="fa fa-calendar"></i> Criado: <b class="pull-right">---</b></p>
                            <p><i class="fa fa-calendar"></i> Editado: <b class="pull-right">---</b></p>
                        </div>
                        <div class="card-footer">
                            {{ Form::button('<i class="fa fa-check"></i> '.trans('dashboard::dashboard.form.save'), ['class' => 'btn btn-success pull-right waves-effect waves-light', 'type' => 'submit']) }}
                        </div>
                    </div>

                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">Categorias</h4>
                            @include ('posts::admin.categories.partials.list_post')
                        </div>
                    </div>

                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">Tags</h4>
                            @include ('posts::admin.tags.partials.list_post')
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    {!! Form::close() !!}
@stop()