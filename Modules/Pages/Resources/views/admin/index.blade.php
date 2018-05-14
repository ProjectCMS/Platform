@extends('pages::admin.layouts.master')

@section('title_prefix', 'Páginas')

@section('content')

    @include ('core::status-messages')

    <div class="box">

        <div class="box-header with-border">
            <a href="{{ route('admin.pages.create') }}" class="btn btn-info"><i class="fa fa-plus"></i> {{ trans('dashboard::dashboard.form.create') }}
            </a>
        </div>

        <div class="box-body">

            @include('core::status', ['route' => 'pages'])

            <div class="dd nestable" data-url="{{ route('admin.pages.order') }}">
                @include('pages::admin.partials.nestable-item', ["item" => $paginate])
            </div>

            {{ $paginate->appends(@$dataForm)->links() }}

        </div>

    </div>

@stop
