@extends('layouts.master')
@section('content')
    <div class="page-title">
        <div class="container">
            @yield('post_categories')
            <h1>@yield('post_title')</h1>
            <div class="meta">
                <span class="date"><i class="fa fa-clock-o"></i> @yield('post_date')</span>
            </div>
        </div>
    </div>
    <nav aria-label="breadcrumb" class="cm-breadcrumb">
        <div class="container">
            @yield('post_breadcrumb')
        </div>
    </nav>

    <div class="container">
        <div class="page-content mt-5">
            <div class="row">
                <div class="col-lg-8">
                    <div class="page-text">
                        @yield('post_images')
                        @yield('post_content')
                    </div>
                    @yield('post_tags')
                    @yield('post_outhers')
                    <div class="sharethis-inline-share-buttons mb-3 mt-3"></div>
                    <div class="comments">
                        <div id="disqus_thread"></div>
                    </div>
                </div>

                @include('partials.posts.sidebar_post')
            </div>
        </div>
    </div>
    <script>
        var disqus_config = function () {
            this.page.url = '{{ url()->full() }}';
        };
    </script>

@stop
