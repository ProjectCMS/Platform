@extends('menus::layouts.master')

@section('title_icon', 'dripicons-menu')
@section('title_prefix', trans('dashboard::dashboard.page.create'))

@section('content')
    <div class="wrapper">
        <div class="container-fluid">
            {!! Form::open(['route' => 'admin.settings.menus.store', 'method' => 'post']) !!}
                @include('menus::partials.master')
            {!! Form::close() !!}
        </div>
    </div>
@stop
