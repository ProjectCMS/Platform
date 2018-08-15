@extends('layouts.post')
@section('post_title', $seo->title)
@section('post_date', $post->created_at_cm)
@section('post_date_html', $post->created_at)
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
                <span><a href="{{ route('web.posts.category', $category->slug) }}" title="{{ $category->title }}">{{ $category->title }}</a></span>
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
    <div class="post-nav d-none">
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

@section('js')
    <script>

        /**
         *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
         *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
        /*
        var disqus_config = function () {
        this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
        this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
        };
        */
        (function() { // DON'T EDIT BELOW THIS LINE
            var d = document, s = d.createElement('script');
            s.src = 'https://revistamamaebebe.disqus.com/embed.js';
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
@stop
