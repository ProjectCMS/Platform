<div class="modal fade" id="modal-dir" tabindex="-1" role="dialog" aria-labelledby="modal-dir">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Nova pasta</h4>
            </div>
            {!! Form::open(['route' => 'admin.media.create.folder', 'method' => 'post']) !!}
            <div class="modal-body">
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    {{ Form::label('name', 'Nome') }}
                    {{ Form::text('name', NULL, ['class' => 'form-control']) }}
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                </div>
            </div>
            <div class="modal-footer-justified">
                <div class="btn-group d-flex">
                    <a href="#" class="btn btn-danger w-100" data-dismiss="modal" role="button">Cancelar</a>
                    <a href="#" class="btn btn-success save-folder w-100">Salvar</a>
                </div>
            </div>
            <input type="hidden" name="dir" value="{{ Request::input('dir') }}">
            {!! Form::close() !!}
        </div>
    </div>
</div>