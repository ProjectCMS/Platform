@extends('media::layouts.master')

@section('title_icon', 'dripicons-archive')
@section('title_prefix', 'Biblioteca de mídia')

@section('content')

    <div class="wrapper">
        <div class="container-fluid">
            <div class="card m-b-20" style="overflow: hidden">
                <iframe src="{{ route('admin.media.iframe') }}?multiple=true&tools=false" frameborder="0" class="no-content" style="width: 100%; height: calc(100vh - 126px)"></iframe>
            </div>
        </div>

@endsection