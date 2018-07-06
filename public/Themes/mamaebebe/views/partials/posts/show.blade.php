@extends('layouts.post')
@section('post_title', $seo->title)
@section('post_date', $post->updated_at_cm)
@section('post_content')
    {!! $post->content !!}
@stop
@section('post_breadcrumb')
    {{ Breadcrumbs::render('post.item', $post) }}
@stop
@section('post_images')
    @if($post->images->count())
        <div class="owl-carousel carousel-posts">
            @foreach($post->images as $image)
                <div class="item box-image"><img src="{{ asset('storage/'.$image->path) }}"></div>
            @endforeach
        </div>
    @endif
@stop
@section('post_categories')
    @if($post->categories->count())
        <div class="post-categories">
            @foreach($post->categories as $category)
                <span><a href="{{ route('web.posts.category', $category->slug) }}">{{ $category->title }}</a></span>
            @endforeach
        </div>
    @endif
@stop
@section('post_tags')
    @if($post->tags->count())
        <div class="post-tags">
            @foreach($post->tags as $tag)
                <span><a href="{{ route('web.posts.tag', $tag->slug) }}"># {{ $tag->title }}</a></span>
            @endforeach
        </div>
    @endif
@stop

@section('post_outhers')
    <div class="post-nav">
        @if($prev)
            <a href="{{ route('web.posts.'.$prev->slug) }}" class="item pull-left">
                <span class="text-left">Artigo anterior</span>
                <p>{{ str_limit($prev->title, 80, '...') }}</p>
            </a>
        @endif
        @if($next)
            <a href="{{ route('web.posts.'.$next->slug) }}" class="item pull-right">
                <span class="text-right">Artigo seguinte</span>
                <p>{{ str_limit($next->title, 80, '...') }}</p>
            </a>
        @endif
    </div>
@stop
