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

    @if(Request::get('s') && Request::get('s') != NULL)
        <div class="page-search">
            <div class="container">
                <div class="box-search mt-5 box-shadow">
                    <h1>
                        <i class="fa fa-search"></i>
                        <span>Pesquisado por:</span> {{ Request::get('s') }}
                    </h1>
                    <p>Resultados encontrados <span>{{ $posts->count() }}</span></p>
                </div>
            </div>
        </div>
    @endif

    <section class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="posts" data-posts="list">
                        @foreach($posts as $post)
                            <article>
                                @include('partials.posts.item', compact('post'))
                            </article>
                        @endforeach
                    </div>
                    {{ $posts->appends(Request::all())->links() }}
                </div>
                @include('partials.posts.sidebar_post')
            </div>
        </div>
    </section>
@stop