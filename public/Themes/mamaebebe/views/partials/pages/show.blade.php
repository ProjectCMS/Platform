@extends('layouts.page')
@section('page_title', $seo->title)
@section('page_breadcrumb')
    {{ Breadcrumbs::render('page', $page) }}
@stop
@section('page_content')
    <div class="page-text">
        {!! $page->content !!}
    </div>
    @if($page->template)
        @include($page->template->path)
    @endif
@stop