<div class="card m-b-20">
    <div class="card-body">

        @include ('core::status-messages')

        <h4 class="mt-0 header-title">Regras
            <small>Informações</small>
        </h4>

        <div class="form-group row {{ $errors->has('label') ? 'has-error' : '' }}">
            {{ Form::label('label', 'Legenda', ['class' => 'col-sm-3 col-form-label']) }}
            <div class="col-sm-9">
                {{ Form::text('label', NULL, ['class' => 'form-control']) }}
                <span class="text-danger">{{ $errors->first('label') }}</span>
            </div>
        </div>

        <div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
            {{ Form::label('name', 'Nome', ['class' => 'col-sm-3 col-form-label']) }}
            <div class="col-sm-9">
                {{ Form::text('name', NULL, ['class' => 'form-control']) }}
                <span class="text-danger">{{ $errors->first('name') }}</span>
            </div>
        </div>

    </div>

</div>

<div class="card m-b-20">
    <div class="card-body">

        <h4 class="mt-0 header-title">Permissões
            <small>Atribuir a regras as permissões</small>
        </h4>

        <div class="form-group row {{ $errors->has('permissions') ? 'has-error' : '' }}">
            {{ Form::label('permissions', 'Permissões', ['class' => 'col-sm-3 col-form-label']) }}
            <div class="col-sm-9">
                <div class="row">
                    @foreach ($permissions as $permission)
                        <div class="col-lg-6 col-xl-3 mb-3">
                            <div class="custom-control custom-checkbox">
                                <input id="checkboxs-{{ $permission->id }}" class="custom-control-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                       @if(isset($data->permissions) && $data->permissions->pluck('id')->contains($permission->id)) checked @endif><span></span>
                                {{ Form::label('checkboxs-'.$permission->id, $permission->label, ['class' => 'custom-control-label']) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>


<div class="card m-b-20">
    <div class="card-body">

        <h4 class="mt-0 header-title">Rotas
            <small>Atribuir a regras as rotas</small>
        </h4>

        <div class="form-group row {{ $errors->has('routes') ? 'has-error' : '' }}">
            {{ Form::label('routes', 'Rotas', ['class' => 'col-sm-3 col-form-label']) }}
            <div class="col-sm-9">
                <div class="row">
                    <div class="routes-group">
                        @foreach($routes as $name => $route)
                            <div class="col-12">
                                <div class="item">
                                    {{ Form::label('route-'.$name, ucfirst($name), ['class' => 'label-item']) }}
                                    <div class="row">
                                        <div class="col-lg-12 mb-3">
                                            <div class="custom-control custom-checkbox">
                                                <input id="checkboxs-route-all-{{ $name }}" class="custom-control-input input-check-all" type="checkbox" value=""><span></span>
                                                {{ Form::label('checkboxs-route-all-'.$name, 'Selecione tudo', ['class' => 'custom-control-label check-all']) }}
                                            </div>
                                        </div>
                                        @foreach ($route as $key => $item)
                                            <div class="col-lg-6 mb-3">
                                                <div class="custom-control custom-checkbox">
                                                    <input id="checkboxs-route-{{ $key }}" class="custom-control-input checkboxs-route" type="checkbox" name="routes[]" value="{{ $item->name }}" @if(isset($data->routes) && $data->routes->pluck('pivot.route')->contains($item->name)) checked @endif><span></span>
                                                    {{ Form::label('checkboxs-route-'.$key, $item->uri, ['class' => 'custom-control-label']) }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="card-footer">
        {{ Form::button('<i class="fa fa-check"></i> '.trans('dashboard::dashboard.form.save'), ['class' => 'btn btn-success pull-right waves-effect waves-light', 'type' => 'submit']) }}
    </div>
</div>