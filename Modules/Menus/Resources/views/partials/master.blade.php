@inject('menu', '\Modules\Menus\Entities\Menu')

<div class="card m-b-20">
    <div class="card">
        <div class="card-body">
            <div class="form-inline form" data-url="{{ route('admin.settings.menus.edit') }}">
                <label class="my-1 mr-2" for="select">Selecionar um menu para editar:</label>
                <div class="mr-sm-2 w-25">
                    {{ Form::select('menu-select', $menu->pluck('title', 'id')->prepend('— Selecionar um menu —', ''), (isset($data) && $data->id != NULL ? $data->id : ''), ['class' => 'form-control set-menu w-100']) }}
                </div>
                {{ Form::button('Selecionar', ['class' => 'btn btn-outline-primary btn-round waves-effect waves-light']) }}
                <label class="my-1 ml-2">ou</label>
                <a href="{{ route('admin.settings.menus.create') }}" class="ml-1">criar um novo menu</a>
                <a href="{{ route('admin.settings.menus.locations') }}" class="btn btn-outline-success btn-round waves-effect waves-light ml-auto"><i class="fa fa-tasks" aria-hidden="true"></i>
                    Gerenciar posições</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card m-b-20">
            <div id="accordion">
                <div class="card">
                    <div class="card-header p-3" id="paginasTarget">
                        <h6 class="m-0">
                            <a href="#paginas" class="text-dark" data-toggle="collapse" aria-expanded="true" aria-controls="paginas">Páginas</a>
                        </h6>
                    </div>

                    <div id="paginas" class="collapse show" aria-labelledby="paginasTarget" data-parent="#accordion" style="">
                        <div class="card-body">
                            @include('menus::partials.lists.pages')
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header p-3" id="categoriasTarget">
                        <h6 class="m-0">
                            <a href="#categorias" class="text-dark collapsed" data-toggle="collapse" aria-expanded="false" aria-controls="categorias">Categorias</a>
                        </h6>
                    </div>
                    <div id="categorias" class="collapse" aria-labelledby="categoriasTarget" data-parent="#accordion" style="">
                        <div class="card-body">
                            @include('menus::partials.lists.categories')
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header p-3" id="linksTarget">
                        <h6 class="m-0">
                            <a href="#links" class="text-dark collapsed" data-toggle="collapse" aria-expanded="false" aria-controls="links">Links
                                personalizados</a>
                        </h6>
                    </div>
                    <div id="links" class="collapse" aria-labelledby="linksTarget" data-parent="#accordion" style="">
                        <div class="card-body">
                            @include('menus::partials.lists.links')
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <div class="col-lg-9">
        <div class="card m-b-20">
            <div class="card-header">
                <div class="form-inline">
                    {{ Form::label('title', 'Nome do menu:', ['class' => 'my-1 mr-2']) }}
                    <div class="form-group w-25 {{ $errors->has('title') ? 'has-error' : '' }}">
                        {{ Form::text('title', NULL, ['class' => 'form-control w-100']) }}
                    </div>
                    {{ Form::button('<i class="fa fa-check"></i> Salvar menu', ['class' => 'btn btn-outline-primary btn-round waves-effect waves-light ml-auto', 'type' => 'submit']) }}
                </div>
            </div>
            <div class="card-body">
                <h4 class="mt-0 header-title">Estrutura do menu</h4>
                <p class="text-muted">Arraste os itens para colocá-los na ordem desejada. Clique na seta à
                    direita do item para mostrar opções de configuração adicionais.</p>

                <div class="dd menu-dd">
                    @if(isset($data->items))
                        @include('menus::partials.items.nestable-item', ['items' => $data->items, 'children' => FALSE])
                    @else
                        <ol class="dd-list" id="dd-main"></ol>
                    @endif
                </div>

            </div>
            <div class="card-footer">
                @if(isset($data))
                    <div class="pull-left">
                        <a href="{{ route('admin.settings.menus.delete') }}" class="btn btn-outline-danger btn-round ajax-action waves-effect waves-light" data-method="delete" data-id="{{ $data->id }}"><i class="fa fa-trash" aria-hidden="true"></i>
                            Deletar menu</a>
                    </div>
                @endif
                <div class="pull-right">
                    {{ Form::button('<i class="fa fa-check"></i> Salvar menu', ['class' => 'btn btn-outline-primary btn-round waves-effect waves-light ml-auto', 'type' => 'submit']) }}
                </div>
            </div>
        </div>
    </div>
</div>
{{ Form::hidden('menu_items', '', ['class' => 'form-control menu-items']) }}
