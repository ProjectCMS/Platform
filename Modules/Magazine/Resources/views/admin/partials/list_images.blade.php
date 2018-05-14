<h4>Galeria</h4>

<div class="btn-group">
    <a href="" class="btn btn-default manager-image"><i class="fa fa-picture-o"></i> {{ trans('dashboard::dashboard.form.add_images') }}</a>
    @if(isset($data->id))
        <a href="{{ route('admin.images.order', $data->id) }}" class="btn btn-success disabled ordering"><i class="fa fa-refresh"></i>
            {{ trans('dashboard::dashboard.form.save_order') }}</a>
    @endif
</div>

<div class="grid row list-pdf" data-columns="4">

</div>

