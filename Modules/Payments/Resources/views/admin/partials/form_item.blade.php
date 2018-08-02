@switch($config->type)

    @case('text')
    {{ Form::text('config['.$config->name.']', $config->value, ['class' => 'form-control']) }}
    @break

    @case('select')
    {{ Form::select('config['.$config->name.']', $config->options, $config->value, ['class' => 'form-control']) }}
    @break

@endswitch