<div class="post" title="{{ $post->title }}">
    <a href="{{ route('web.posts.'.$post->slug) }}">
        <div class="box-image">
            @if($post->images->count())
                <img src="{{ asset('storage/'.$post->images->first()->path) }}" class="no-image">
            @else
                <img src class="no-image">
            @endif
        </div>
    </a>
    <div class="content">
        @if($post->categories->count())
            <div class="post-categories">
                @foreach($post->categories->slice(0, 1) as $category)
                    <span><a href="{{ route('web.posts.category', $category->slug) }}">{{ $category->title }}</a></span>
                @endforeach
            </div>
        @endif
        <h3><a href="{{ route('web.posts.'.$post->slug) }}">{{ $post->title }}</a></h3>
        <p>{{ str_limit(strip_tags($post->content), 205, '[...]') }}</p>
        <div class="meta">
            <span class="date"><i class="fa fa-clock-o"></i> {{ $post->created_at_cm }}</span>
        </div>
    </div>
    <ul class="social list-inline">
        <li><a href="" class="facebook"><i class="fa fa-facebook"></i></a></li>
        <li><a href="" class="twitter"><i class="fa fa-twitter"></i></a></li>
        <li><a href="" class="googlep"><i class="fa fa-google-plus"></i></a></li>
        <li><a href="" class="whatsapp"><i class="fa fa-whatsapp"></i></a></li>
    </ul>
</div>