@extends('layouts.post')
@section('post_title', $seo->title)
@section('post_date', $post->created_at_cm)
@section('post_date_html', $post->created_at)
@section('post_content')
    {!! $post->content !!}
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
        <ul class="post-categories">
            @foreach($post->categories as $category)
                <li><a href="{{ route('web.posts.category', $category->slug) }}" title="{{ $category->title }}">{{ $category->title }}</a></li>
            @endforeach
        </ul>
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

@section('js')
    <script>
        (function() {
            var d = document, s = d.createElement('script');
            s.src = 'https://revistamamaebebe.disqus.com/embed.js';
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();
    </script>
@stop
