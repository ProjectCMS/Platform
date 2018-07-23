<section class="timeline mt-4">
    @forelse($timeline as $item)
        <article class="item">
            <div class="content">
                <div class="box">
                    <a href="{{ route('web.posts.'.$item->post->slug) }}" target="_blank" title="{{ $item->title }}">{{ $item->title }}</a>
                    <p>{{ str_limit($item->content, 140) }}</p>
                </div>
            </div>
        </article>
    @empty
    @endforelse
</section>
