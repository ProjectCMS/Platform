<h4 class="mt-0 header-title">Galeria</h4>

<div class="btn-group">
    <a href="" class="btn btn-secondary manager-pdf"><i class="fa fa-picture-o"></i> {{ trans('dashboard::dashboard.form.add_images') }}</a>
</div>

{{ Form::hidden('files_items', (isset($files) ? $files->toJson() : ''), ['class' => 'form-control files-input', 'data-input' => 'pdf']) }}

<div class="grid row list-pdf" data-columns="4"></div>
