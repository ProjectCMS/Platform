@extends('layouts.master')
@section('content')
    <section class="mt-5">
        <div class="container">
            <div class="posts" data-posts="grid">
                @foreach($postsFixed as $post)
                    <article>
                        @include('partials.posts.item', compact('post'))
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mt-5">
        <div class="container">
            <div class="posts" data-posts="main">
                <div class="row">
                    @foreach($postsMain->splice(0, 10) as $post)
                        <article>
                            @include('partials.posts.item', compact('post'))
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="mt-2">
        <div class="container">
            <div class="posts" data-posts="category">
                <div class="row">
                    @foreach($categoryPosts as $category)
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
                    <div class="posts" data-posts="sub">
                        <div class="row">
                            @foreach($postsMain->splice(0, 4) as $post)
                                <article>
                                    @include('partials.posts.item', compact('post'))
                                </article>
                            @endforeach
                        </div>
                    </div>
                </div>
                @include('partials.sidebar')
            </div>
        </div>
    </section>
@stop