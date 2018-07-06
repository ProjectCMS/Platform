@extends('layouts.master')
@section('content')
    <section class="mt-5">
        <div class="container">
            <div class="grid-posts row">
                @foreach($postsFixed as $post)
                    <article>
                        <div class="content">
                            <a href="{{ route('web.posts.'.$post->slug) }}">
                                <div class="box-image">
                                    @if($post->images->count())
                                        <img src="{{ asset('storage/'.$post->images->first()->path) }}" class="no-image">
                                    @else
                                        <img src class="no-image">
                                    @endif
                                </div>
                            </a>
                            <div class="caption">
                                @if($post->categories->count())
                                    <div class="post-categories">
                                        @foreach($post->categories->slice(0, 1) as $category)
                                            <span><a href="{{ route('web.posts.category', $category->slug) }}">{{ $category->title }}</a></span>
                                        @endforeach
                                    </div>
                                @endif
                                <h3>
                                    <a href="{{ url($post->slug) }}">{{ $post->title }}</a>
                                </h3>
                                <div class="meta">
                                    <span class="date"><i class="fa fa-clock-o"></i> {{ $post->updated_at_cm }}</span>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mt-5">
        <div class="container">
            <div class="posts row" id="main">
                @foreach($postsMain->splice(0, 10) as $post)
                    <article>
                        @include('partials.posts.item', compact('post'))
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mt-2">
        <div class="container">
            <div class="posts-category">
                <div class="row">
                    @foreach($postsCategory as $category)
                        <div class="col-md-4">
                            <h4 class="title">{{ $category->title }}</h4>
                            <div class="posts row">
                                @foreach($category->posts->take(4) as $post)
                                    <article class="col-md-12">
                                        @include('partials.posts.item', compact('post'))
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>


    <section class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="posts row" id="sub">
                        @foreach($postsMain->splice(0, 4) as $post)
                            <article>
                                @include('partials.posts.item', compact('post'))
                            </article>
                        @endforeach
                    </div>
                </div>
                @include('partials.sidebar')
            </div>
        </div>
    </section>
@stop