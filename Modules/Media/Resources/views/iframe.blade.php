<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>File manager</title>
    <link rel="stylesheet" href="{{ Module::asset('media:css/libs.min.css') }}">
    <link rel="stylesheet" href="{{ Module::asset('media:css/core.min.css') }}">
</head>

<body>

<!-- start content -->
<div class="filemanager">

    <div class="sidebar">

        <div class="upload">
            <div class="btn btn-info btn-block btn-upload waves-effect waves-light"><i class="fa fa-upload"></i> Upload files</div>
            <div class="uploading text-center d-none">
                <h3>
                    <div class="spinner"></div>
                    <span>Uploading</span>
                </h3>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="infos">
                    <span class="size">0 MB</span>
                    <b>de</b>
                    <span class="total">0 MB</span>
                </div>
            </div>
        </div>
        <nav class="menu">
            <span>Folders</span>
            <ul class="list-unstyled">
                @foreach($directories as $dir)
                    @if($dir["type"] == "folder-up")
                        <li><a href="{{ $dir["path"] }}" class="back">...</a></li>
                    @else
                        <li><a href="{{ $dir["path"] }}">{{ $dir["file"] }}</a></li>
                    @endif
                @endforeach
            </ul>
        </nav>

    </div>
    <div class="content">
        <div class="header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="{{ route('admin.media.iframe') }}?{{ http_build_query(Request::except('dir')) }}"><i class="fa fa-home"></i> Home</a></li>
                    @foreach($breadcrumb as $item)
                        @if($item["active"] == TRUE)
                            <li class="breadcrumb-item active">{{ $item["folder"] }}</li>
                        @else
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.media.iframe') }}?{{ $item["link"] }}">{{ $item["folder"] }}</a>
                            </li>
                        @endif
                    @endforeach
                </ol>
            </nav>

            <div class="header-icons">
                <div class="group">
                    <a href="{{ route('admin.media.iframe') }}?{{ http_build_query(Request::except('dir')) }}" class="fi flaticon-home" data-tooltip data-placement="top" title="Home"></a>
                    <a href="#" class="fi flaticon-folder-add" data-placement="top" data-tooltip data-toggle="modal" data-target="#modal-dir" title="Nova pasta"></a>
                    <a href="#" class="fi flaticon-interface set-view" data-tooltip data-placement="top" title="Lista" data-view="list"></a>
                    <a href="#" class="fi flaticon-shapes set-view" data-tooltip data-placement="top" title="Box" data-view="box"></a>
                </div>

                <div class="group group-right">
                    <a href="#" class="fi flaticon-download downloads" data-tooltip data-placement="top" title="Download"></a>
                    <a href="#" class="fi flaticon-trash delete" data-tooltip data-placement="top" title="Deletar"></a>
                </div>
            </div>
        </div>

        <div class="box-item" data-view="list" data-toolbar>
            <div class="items"></div>
        </div>

        <div class="toolbar text-right">
            <button class="btn btn-info waves-effect waves-light" id="insert-item" disabled><i class="fa fa-plus"></i> Inserir</button>
        </div>

    </div>
</div>

@include('media::partials.modais')

<script type="text/javascript">

    var token        = '{{ csrf_token() }}',
        request      = '{{ http_build_query(Request::all()) }}',
        url          = '{{ route('admin.media') }}',
        url_items    = '{{ route('admin.media.items') }}',
        url_upload   = '{{ route('admin.media.upload') }}',
        url_download = '{{ route('admin.media.downloads') }}',
        url_delete   = '{{ route('admin.media.delete') }}',
        current_dir  = '{{ Request::input('dir') }}',
        tools        = '{{ Request::input('tools') }}',
        multiple     = '{{ Request::input('multiple') }}';
</script>

<script type="text/javascript" src="{{ Module::asset('media:js/libs.min.js') }}?v={{ time() }}"></script>
<script type="text/javascript" src="{{ Module::asset('media:js/core.min.js') }}?v={{ time() }}"></script>
<script type="text/javascript" src="{{ Module::asset('media:js/media.js') }}?v={{ time() }}"></script>

</body>

</html>