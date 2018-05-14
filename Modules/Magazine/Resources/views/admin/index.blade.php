@extends('magazine::admin.layouts.master')

@section('title_prefix', 'Revistas'. ' - ')

@section('content_header')
    <h1>Revistas</h1>
    {{ Breadcrumbs::render('admin.magazine') }}
@stop

@section('content')

    @include ('core::status-messages')

    {{--<div class="box">--}}

        {{--<div class="box-header with-border">--}}
            {{--<a href="{{ route('admin.pages.create') }}" class="btn btn-info"><i class="fa fa-plus"></i> {{ trans('dashboard::dashboard.form.create') }}--}}
            {{--</a>--}}
        {{--</div>--}}

        {{--<div class="box-body">--}}

            {{--@include('core::status', ['route' => 'pages'])--}}

            {{--<div class="dd nestable" data-url="{{ route('admin.pages.order') }}">--}}
                {{--@include('pages::admin.partials.nestable-item', ["item" => $paginate])--}}
            {{--</div>--}}

            {{--{{ $paginate->appends(@$dataForm)->links() }}--}}

        {{--</div>--}}

    {{--</div>--}}

@stop
