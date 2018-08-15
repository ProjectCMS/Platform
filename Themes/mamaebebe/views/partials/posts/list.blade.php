@extends('layouts.page')
@section('page_title', $seo->title)
@section('page_breadcrumb')
    @if(isset($data->title))
        {{ Breadcrumbs::render('post.partial', $data) }}
    @else
        {{ Breadcrumbs::render('post') }}
    @endif
@stop
@section('page_content')
    <section class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="posts" data-posts="sub">
                        <div class="row">
                            @foreach($posts as $post)
                                <article>
                                    @include('partials.posts.item', compact('post'))
                                </article>
                            @endforeach
                        </div>
                    </div>
                    {{ $posts->links() }}
                </div>
                @include('partials.posts.sidebar_post')
            </div>
        </div>
    </section>
@stop