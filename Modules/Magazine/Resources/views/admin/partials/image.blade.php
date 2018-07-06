<div class="card m-b-20">
    <div class="card-body">
        <h4 class="mt-0 header-title">Capa</h4>
        <div class="content-image clearfix mt-2">
            @if(isset($data->image) && $data->image != null)
                <img src="{{ asset('storage/'. $data->image) }}">
            @endif
        </div>
        {{ Form::hidden('image', NULL, ['class' => 'form-control single-image']) }}
    </div>
    <div class="card-footer text-right">
        @if(isset($data->image) && $data->image != null)
            {{ Form::button('Remover image', ['class' => 'btn btn-danger remove-image waves-effect waves-light']) }}
        @endif
        {{ Form::button('Mudar imagem', ['class' => 'btn btn-default change-image waves-effect waves-light']) }}
    </div>
</div>