@extends('layouts.page')
@section('page_title', $seo->title)
@section('page_content')
    @if($page->content)
        <div class="page-text">
            {!! $page->content !!}
        </div>
    @endif
    @if($page->template)
        @include($page->template->path)
    @endif
@stop