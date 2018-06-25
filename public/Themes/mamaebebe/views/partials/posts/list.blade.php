@extends('layouts.page')
@section('page_title', (isset($data->title) ? $data->title : 'Blog'))
@section('page_content')
    <section class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="posts row" id="sub">
                        @foreach($posts as $post)
                            <article>
                                @include('partials.posts.item', compact('post'))
                            </article>
                        @endforeach
                    </div>
                    {{ $posts->links() }}
                </div>
                @include('partials.posts.sidebar_post')
            </div>
        </div>
    </section>
@stop