<div class="magazine">
    <div class="row">
        @foreach($magazine as $item)
            <div class="col-md-3 col-6">
                <a href="#" class="item manager-magazine" data-id="{{ $item->id }}" title="{{ $item->title }}">
                    <figure>
                        @if($item->image)
                            <img src="{{ asset('storage/'.$item->image) }}" class="no-image">
                        @else
                            <img src class="no-image">
                        @endif
                    </figure>
                </a>
            </div>
        @endforeach
    </div>
</div>
