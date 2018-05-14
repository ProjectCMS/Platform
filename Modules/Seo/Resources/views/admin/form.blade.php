<h4 class="mt-0 header-title">Seo <small>Search Engine Optimization</small></h4>

<div class="row">
    
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('seo_title') ? 'has-error' : '' }}">
            {{ Form::label('seo_title', 'Título da página') }}
            {{ Form::text('seo_title', NULL, ['class' => 'form-control']) }}
            <span class="text-danger">{{ $errors->first('seo_title') }}</span>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('seo_keywords') ? 'has-error' : '' }}">
            {{ Form::label('seo_keywords', 'Tags') }}
            {{ Form::text('seo_keywords', NULL, ['class' => 'form-control']) }}
            <small>Separe as tags por virgula</small>
            <span class="text-danger">{{ $errors->first('seo_keywords') }}</span>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group {{ $errors->has('seo_content') ? 'has-error' : '' }}">
            {{ Form::label('seo_content', 'Descrição') }}
            {{ Form::textarea('seo_content', null, ['class' => 'form-control', 'rows' => 6]) }}
            <span class="text-danger">{{ $errors->first('seo_content') }}</span>
        </div>
    </div>
    
</div>