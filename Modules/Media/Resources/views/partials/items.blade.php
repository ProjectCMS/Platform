@forelse($directories as $key => $dir)
    <div class="item" data-type="{{ $dir["type"] }}" data-value="{{ $dir["path_url"] }}" title="{{ $dir["file"] }}">
        <div class="preview">
            <label for="checkboxs-{{ $key }}">
                @if($dir["type"] != 'folder-up')
                    <div class="check">
                        <div class="ui-input ui-bg">
                            <input type="checkbox" id="checkboxs-{{ $key }}" class="check-item" name="item[]" value="{{ $dir["path_url"] }}"><span></span>
                        </div>
                    </div>
                @endif
                <div class="details">
                    <div class="icon-content">
                        <div class="icon"></div>
                    </div>
                    <a href="{{ $dir["path"] }}" class="name">{{ $dir["file"] }}</a>
                    @if($dir["type"] != 'folder-up')
                        <div class="infos">Criado {{ $dir["date"] }}</div>
                    @endif
                </div>
            </label>
        </div>
    </div>
@empty
@endforelse

@forelse($items as $key => $item)
    <div class="item"
         data-ext="{{ $item["ext"] }}"
         data-path="{{ $item["path_url"] }}"
         data-url="{{ $item["path"] }}"
         data-type="{{ $item["type"] }}"
         data-file="{{ $item["file"] }}"
         data-storage="{{ $item["storage"] }}"
         title="{{ $item["file"] }}">
        <div class="preview">
            <div class="item-content">
                <label for="checkboxs-{{ $key }}">
                    <div class="check">
                        <div class="ui-input ui-bg">
                            <input type="checkbox" id="checkboxs-{{ $key }}" class="check-item" name="item[]" value="{{ $item["path_url"] }}"><span></span>
                        </div>
                    </div>

                    @if($item["type"] == 'image')
                          <figure>
                            <img src="{{ $item["path"] }}" data-orientation="{{ $item["orientation"] }}">
                        </figure>
                    @endif

                    <div class="details">
                        <div class="icon-content">
                            <div class="icon"></div>
                        </div>
                        <a href="{{ $item["download"] }}" class="name">{{ $item["file"] }}</a>
                        <div class="infos">Criado {{ $item["date"] }} | {{ $item["size"] }}</div>
                    </div>
                </label>
            </div>
        </div>
    </div>
@empty
@endforelse

<script type="text/javascript">
    check_item();
</script>
