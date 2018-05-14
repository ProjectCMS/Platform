<div class="modal fade modal-manager" role="dialog">
    <div class="modal-dialog modal-lg" style="max-width: calc(100% - 60px)">
        <div class="modal-content">
            <iframe src="{{ route('admin.media.iframe') }}?{{ http_build_query(Request::all()) }}" frameborder="0" class="no-content" style="width: 100%; height: calc(100vh - 65px)"></iframe>
        </div>
    </div>
</div>