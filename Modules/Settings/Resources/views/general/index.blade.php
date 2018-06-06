@extends('settings::layouts.master')

@section('title_icon', 'dripicons-checklist')
@section('title_prefix', 'Configurações - Gerais')

@section('content')
    {!! Form::open(['route' => 'admin.settings.general.update', 'method' => 'put']) !!}
    <div class="wrapper">
        <div class="container-fluid">

            <div class="card m-b-20">
                <div class="card-body">

                    @include ('core::status-messages')

                    <h4 class="mt-0 header-title">Configurações
                        <small>Gerais</small>
                    </h4>

                    <div class="form-group row mb-5">
                        {{ Form::label('site_name', 'Nome do site', ['class' => 'col-sm-3 col-form-label']) }}
                        <div class="col-lg-6 col-sm-9">
                            {{ Form::text('site_name', setting('site_name', config('app.name')), ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group row mb-5">
                        {{ Form::label('site_description', 'Descrição', ['class' => 'col-sm-3 col-form-label']) }}
                        <div class="col-lg-6 col-sm-9">
                            {{ Form::text('site_description', setting('site_description'), ['class' => 'form-control']) }}
                            <p class="text-muted mb-0 mt-1 ml-2">Em poucas palavras, explique sobre o que é esse
                                site.</p>
                        </div>
                    </div>

                    <div class="form-group row mb-5">
                        {{ Form::label('site_url', 'Endereço do site (URL)', ['class' => 'col-sm-3 col-form-label']) }}
                        <div class="col-lg-6 col-sm-9">
                            {{ Form::text('site_url', setting('site_url', config('app.url')), ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group row mb-5">
                        {{ Form::label('timezone', 'Fuso horário', ['class' => 'col-sm-3 col-form-label']) }}
                        <div class="col-lg-6 col-sm-9">
                            {{ Form::select('timezone', $timezone, setting('timezone', config('app.timezone')), ['class' => 'form-control']) }}
                            <p class="text-muted mb-1 mt-1 ml-2">Escolha uma cidade no mesmo fuso horário que você ou o
                                fuso horário UTC.</p>
                            <p class="text-muted ml-2">Tempo universal (UTC) é <code>{{ Date::now()->timezone('UTC')->format('d/m/Y H:i:s') }}. </code>A
                                hora local é <code>{{ Date::now()->format('d/m/Y H:i:s') }}.</code></p>
                         </div>
                    </div>

                    <div class="form-group row mb-5">
                        {{ Form::label('format_date', 'Formato de data', ['class' => 'col-sm-3 col-form-label']) }}
                        <div class="col-lg-6 col-sm-9">
                            <div class="form-check">
                                <div class="custom-control custom-radio mb-2">
                                    {{ Form::radio('format_date', 'j \d\e F \d\e Y',
                                    (setting('format_date') == 'j \d\e F \d\e Y' ? TRUE : FALSE), ['class' => 'custom-control-input', 'id' => 'date-1']) }}
                                    <label class="custom-control-label" for="date-1">
                                        <span class="d-inline-block" style="min-width: 10em">{{ Date::now()->format('j \d\e F \d\e Y') }}</span>
                                        <code>j \d\e F \d\e Y</code>
                                    </label>
                                </div>
                            </div>
                            <div class="form-check">
                                <div class="custom-control custom-radio mb-2">
                                    {{ Form::radio('format_date', 'j \d\e M \d\e Y',
                                    (setting('format_date') == 'j \d\e M \d\e Y' ? TRUE : FALSE), ['class' => 'custom-control-input', 'id' => 'date-2']) }}
                                    <label class="custom-control-label" for="date-2">
                                        <span class="d-inline-block" style="min-width: 10em">{{ Date::now()->format('j \d\e M \d\e Y') }}</span>
                                        <code>j \d\e M \d\e Y</code>
                                    </label>
                                </div>
                            </div>
                            <div class="form-check">
                                <div class="custom-control custom-radio mb-2">
                                    {{ Form::radio('format_date', 'Y-m-d',
                                    (setting('format_date') == 'Y-m-d' ? TRUE : FALSE), ['class' => 'custom-control-input', 'id' => 'date-3']) }}
                                    <label class="custom-control-label" for="date-3">
                                        <span class="d-inline-block" style="min-width: 10em">{{ Date::now()->format('Y-m-d') }}</span>
                                        <code>Y-m-d</code>
                                    </label>
                                </div>
                            </div>
                            <div class="form-check">
                                <div class="custom-control custom-radio mb-2">
                                    {{ Form::radio('format_date', 'd/m/Y',
                                    (setting('format_date') == 'd/m/Y' ? TRUE : FALSE), ['class' => 'custom-control-input', 'id' => 'date-4']) }}
                                    <label class="custom-control-label" for="date-4">
                                        <span class="d-inline-block" style="min-width: 10em">{{ Date::now()->format('d/m/Y') }}</span>
                                        <code>d/m/Y</code>
                                    </label>
                                </div>
                            </div>
                            <div class="form-check">
                                <div class="custom-control custom-radio mb-2">
                                    {{ Form::radio('format_date', 'm/d/Y',
                                    (setting('format_date') == 'm/d/Y' ? TRUE : FALSE), ['class' => 'custom-control-input', 'id' => 'date-5']) }}
                                    <label class="custom-control-label" for="date-5">
                                        <span class="d-inline-block" style="min-width: 10em">{{ Date::now()->format('m/d/Y') }}</span>
                                        <code>m/d/Y</code>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-5">
                        {{ Form::label('format_time', 'Formato de hora', ['class' => 'col-sm-3 col-form-label']) }}
                        <div class="col-lg-6 col-sm-9">
                            <div class="form-check">
                                <div class="custom-control custom-radio mb-2">
                                    {{ Form::radio('format_time', 'H:i',
                                    (setting('format_time') == 'H:i' ? TRUE : FALSE), ['class' => 'custom-control-input', 'id' => 'time-1']) }}
                                    <label class="custom-control-label" for="time-1">
                                        <span class="d-inline-block" style="min-width: 10em">{{ Date::now()->format('H:i') }}</span>
                                        <code>H:i</code>
                                    </label>
                                </div>
                            </div>
                            <div class="form-check">
                                <div class="custom-control custom-radio mb-2">
                                    {{ Form::radio('format_time', 'g:i A',
                                    (setting('format_time') == 'g:i A' ? TRUE : FALSE), ['class' => 'custom-control-input', 'id' => 'time-2']) }}
                                    <label class="custom-control-label" for="time-2">
                                        <span class="d-inline-block" style="min-width: 10em">{{ Date::now()->format('g:i A') }}</span>
                                        <code>g:i A</code>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    {{ Form::button('<i class="fa fa-check"></i> '.trans('dashboard::dashboard.form.save'), ['class' => 'btn btn-success pull-right waves-effect waves-light', 'type' => 'submit']) }}
                </div>

            </div>

        </div>
    </div>
    {!! Form::close() !!}
@stop
