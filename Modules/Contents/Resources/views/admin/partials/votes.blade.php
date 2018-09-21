<h4 class="mt-0 header-title">Votos adicionais
    <small>Votos para assinantes</small>
</h4>

<table class="table table-bordered table-cicle-content">
    <thead>
    <tr>
        <th>Ciclo</th>
        <th>Votos</th>
        <th width="150"></th>
    </tr>
    </thead>
    <tbody>
    <tr class="form-items">
        <td scope="row">
            {{ Form::select('', $cicles, NULL, ['class' => 'form-control select2', 'data-item' => 'cicle']) }}
        </td>
        <td>
            {{ Form::number('', 0, ['class' => 'form-control votes', 'data-item' => 'votes', 'min' => 0]) }}
        </td>
        <td>
            {{ Form::button('<i class="fa fa-plus"></i> Adicionar', ['class' => 'btn btn-info btn-block add-cicle-content']) }}
        </td>
    </tr>
    <tr class="info-size text-center">
        <td colspan="3">Ciclos adicionados para esse concurso</td>
    </tr>

    @if(isset($data->cicles))
        @foreach($data->cicles as $cicle)
            <tr data-id="{{ $cicle->id }}">
                <td>
                    <label class="mb-0">{{ $cicle->cicle->title }}</label><input type="hidden" name="cicle[{{ $cicle->id }}][subscribe_cicle_id]" value="{{ $cicle->subscribe_cicle_id }}">
                </td>
                <td>
                    <label class="mb-0">{{ $cicle->votes }}</label><input type="hidden" name="cicle[{{ $cicle->id }}][votes]" value="{{ $cicle->votes }}">
                </td>
                <td>
                    <button class="btn btn-danger btn-block remove-cicle-content" type="button">
                        <i class="fa fa-close"></i>
                        Remover
                    </button>
                    <input type="hidden" name="cicle[{{ $cicle->id }}][id]" value="{{ $cicle->id }}"></td>
            </tr>
        @endforeach
    @endif

    </tbody>
</table>