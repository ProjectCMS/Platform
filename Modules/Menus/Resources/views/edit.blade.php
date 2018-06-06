@extends('menus::layouts.master')

@section('title_icon', 'dripicons-menu')
@section('title_prefix', trans('dashboard::dashboard.page.edit'))

@section('content')
    <div class="wrapper">
        <div class="container-fluid">
            {!! Form::model($data, ['route' => ['admin.settings.menus.update', $data->id], 'method' => 'put']) !!}
            @include('menus::partials.master')
            {!! Form::close() !!}
        </div>
    </div>
@stop