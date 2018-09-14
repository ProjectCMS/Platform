@extends('partials.client.layouts.account')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-shadow">
                    <h5 class="box-title">Visão geral</h5>
                    {!! Form::open([]) !!}
                        <div class="form-group">
                            <label>Nome</label>
                            <span class="d-block">{{ $client->name }}</span>
                        </div>
                        <div class="form-group">
                            <label>E-mail</label>
                            <span class="d-block">{{ $client->email }}</span>
                        </div>
                        <div class="form-group">
                            <label>Assinatura</label>
                            <div class="clearfix"></div>
                            @if($client->subscribe && $client->subscribe->status == 1)
                                <span class="d-block">Válido até <span class="text-info">{{ \Date::parse($client->subscribe->renovation_at)->format('j \d\e F \d\e Y') }}</span>

                                </span>
                            @else
                                <a href="{{ url('/planos') }}">
                                    <span class="badge badge-bg badge-outline p-2">Nenhuma assinatura, assinar</span>
                                </a>
                            @endif
                        </div>
                        <a href="{{ route('web.clients.account.profile') }}" class="btn btn-round btn-bg btn-block btn-lg mt-5"><i class="fa fa-edit"></i> Editar
                            perfil
                        </a>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="col-md">
                <div class="box box-shadow">
                    <h5 class="box-title">Chave de assinatura</h5>
                    @include('core::status-messages')
                    {!! Form::open(['route' => 'web.subscribes.key', 'method' => 'POST']) !!}
                    <div class="form-group mb-0 {{ $errors->has('key') ? 'has-error' : '' }}">
                        <span class="d-block mb-3">Possuí uma chave de assinatura? Insira abaixo:</span>
                        <div class="input-group">
                            {{ Form::text('key', NULL, ['class' => 'form-control', 'aria-describedby' => 'button-addon']) }}
                            <div class="input-group-append">
                                {{ Form::button('<i class="fa fa-key"></i> Inserir chave', ['class' => 'btn btn-info btn-loading', 'id' => 'button-addon', 'type' => 'submit', 'data-style' => 'zoom-in', 'data-spinner-size' => 30]) }}
                            </div>
                        </div>
                        <span class="text-danger">{{ $errors->first('key') }}</span>
                        <a href="" class="text-info">
                            <span class="btn-block text-right mt-3 d-none">Ver minhas chaves</span>
                        </a>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="col-md-12">
                <div class="box box-shadow">
                    <h5 class="box-title">Histórico de pagamentos</h5>
                    <table class="table table-bordered mb-0">
                        <thead>
                        <tr>
                            <th width="170">Data</th>
                            <th>Plano</th>
                            <th>Forma de pagamento</th>
                            <th>Valor</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($client->subscribe->payment_logs as $payment)
                            <tr>
                                <td>{{ $payment->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>{{ $payment->options->period }}</td>
                                <td>{{ $payment->method->title }}</td>
                                <td>R$ {{ $payment->options->amount }}</td>
                                <td>{{ $payment->status }}</td>
                            </tr>
                        @empty
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop