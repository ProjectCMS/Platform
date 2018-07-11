@extends('dashboard::layouts.master')
@section('title_icon', 'dripicons-meter')
@section('title_prefix', 'Dashboard')

@section('content_header')
    @include('tracker::partials.chart')
@stop

@section('content')
    @include('tracker::partials.layout')
@stop
