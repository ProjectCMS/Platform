<h4 class="mt-0 header-title">Galeria</h4>

<div class="btn-group">
    <a href="" class="btn btn-secondary manager-image waves-effect waves-light"><i class="fa fa-picture-o"></i> {{ trans('dashboard::dashboard.form.add_images') }}</a>
    @if(isset($data->id))
        <a href="{{ route('admin.images.order', $data->id) }}" class="btn btn-success disabled ordering waves-effect waves-light"><i class="fa fa-refresh"></i>
            {{ trans('dashboard::dashboard.form.save_order') }}</a>
    @endif
</div>
<div class="clearfix"></div>
<div class="grid" data-columns="7">
    @if(isset($images))
        @foreach($images as $image)
            @php
                list($width, $height) = getimagesize(asset('storage/'.$image->name));
                if ($width > $height) {
                     $orientation = "landscape";
                 } else {
                     $orientation = "portrait";
                 }
            @endphp
            <div class="item sortable @if($image->order == 0)main @endif" id="{{ $image->id }}" data-image="{{ $image->name }}">
                <div class="delete-image"></div>
                <img src="{{ asset('storage/'.$image->name) }}" data-orientation="{{ $orientation }}">
            </div>
        @endforeach
    @endif
</div>

{{ Form::select('images[]', (isset($images) ? $images->pluck('name', 'name') : []), '', ['class' => 'form-control files-input d-none', 'multiple' => 'multiple']) }}

