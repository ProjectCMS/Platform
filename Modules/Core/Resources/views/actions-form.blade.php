{!! Form::open(['route' => 'admin.posts.delete', 'method' => 'post', 'class' => 'form-inline ajax-actions']) !!}

<div class="form-group">
    {{ Form::select('action', ["" => "Ações em Massa", "delete" => "Deletar"], '', ['class' => 'form-control']) }}
</div>

<button type="submit" class="btn btn-default">Aplicar</button>

<hr>
{!! Form::close() !!}