@extends('payments::admin.layouts.master')

@section('title_icon', 'dripicons-copy')
@section('title_prefix', trans('dashboard::dashboard.page.edit'))

@section('content')

    {!! Form::model($data, ['route' => ['admin.settings.payments.update', $data->id], 'method' => 'put']) !!}
    <div class="wrapper">
        <div class="container-fluid">

            <div class="card m-b-20">
                <div class="card-body">
                    <div class="pull-left">
                        @if($data->image != NULL)
                            <img src="{{ asset('storage/'.$data->image) }}" height="30">
                        @endif
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg">
                    @include('payments::admin.partials.form')
                </div>

                <div class="col col-flex flex-400">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">Informações</h4>
                            <p><i class="fa fa-calendar"></i> Criado:
                                <b class="pull-right">{{ $data->created_at_cm }}</b></p>
                            <p><i class="fa fa-calendar"></i> Editado:
                                <b class="pull-right">{{ $data->updated_at_cm }}</b></p>
                        </div>
                        <div class="card-footer">
                            {{ Form::button('<i class="fa fa-check"></i> '. trans('dashboard::dashboard.form.save'), ['class' => 'btn btn-success pull-right waves-effect waves-light', 'type' => 'submit']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

