@extends('partials.sidebar')
@section('custom_widget')
    <div class="widget">
        <div class="title">Posts <span>recentes</span></div>
        <ul class="list-inline posts-list">
            @forelse($recentsPosts as $post)
                <li title="{{ $post->title }}">
                    <a href="{{ route('web.posts.'.$post->slug) }}" title="{{ $post->title }}">
                        <figure class="box-image">
                            @if($post->images->count())
                                <img src="{{ asset('storage/'.$post->images->first()->path) }}" class="no-image">
                            @else
                                <img src class="no-image">
                            @endif
                        </figure>
                    </a>
                    <h3>
                        <a href="{{ route('web.posts.'.$post->slug) }}">{{ str_limit($post->title, 50, '...') }}</a>
                    </h3>
                    <span><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $post->updated_at_cm }}</span>
                </li>
            @empty
            @endforelse
        </ul>
    </div>

    <div class="widget">
        <div class="title">Tags <span>populares</span></div>
        <ul class="list-inline">
            @if($tags->count())
                <div class="post-tags">
                    @foreach($tags as $tag)
                        <span data-count="{{ $tag->posts_count }}"><a href="{{ route('web.posts.tag', $tag->slug) }}" title="{{ $tag->title }}"># {{ $tag->title }}</a></span>
                    @endforeach
                </div>
            @endif
        </ul>
    </div>

@stop