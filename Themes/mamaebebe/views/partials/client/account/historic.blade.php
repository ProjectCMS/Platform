@extends('partials.client.layouts.account')

@section('content')
    <div class="container">
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
@stop
