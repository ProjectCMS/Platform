@extends('partials.client.layouts.account')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-shadow">
                    <h5 class="box-title">Visão geral</h5>
                    <form role="form">
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
                                <span class="d-block">{{ $client->subscribe->cicle->title }}

                                </span>
                            @else
                                <a href="">
                                    <span class="badge badge-bg badge-outline p-2">Nenhuma assinatura, assinar</span>
                                </a>
                            @endif
                        </div>
                        <button class="btn btn-round btn-bg btn-block btn-lg mt-5"><i class="fa fa-edit"></i> Editar
                            perfil
                        </button>
                    </form>
                </div>
            </div>
            <div class="col-md">
                <div class="box box-shadow">
                    <h5 class="box-title">Chave de assinatura</h5>
                    <div class="alert alert-danger" role="alert">
                        A simple danger alert—check it out!
                    </div>
                    <form>
                        <div class="form-group mb-0">
                            <span class="d-block mb-3">Possuí uma chave de assinatura? Insira abaixo:</span>
                            <div class="input-group">
                                <input type="text" class="form-control" aria-describedby="button-addon">
                                <div class="input-group-append">
                                    <button class="btn btn-info" type="button" id="button-addon">
                                        <i class="fa fa-key"></i> Inserir chave
                                    </button>
                                </div>
                            </div>
                            <a href="" class="text-info">
                                <span class="btn-block text-right mt-3">Ver minhas chaves</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box box-shadow">
                    <h5 class="box-title">Histórico de pagamentos</h5>
                    <table class="table table-bordered mb-0">
                        <thead>
                        <tr>
                            <th>Plano</th>
                            <th>Forma de pagamento</th>
                            <th>Valor</th>
                            <th>Data</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td scope="row">aaa</td>
                            <td>bbb</td>
                            <td>ccc</td>
                            <td>ddd</td>
                            <td>eee</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop