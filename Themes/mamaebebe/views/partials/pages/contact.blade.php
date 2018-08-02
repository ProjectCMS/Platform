<div class="contact">
    <h3>Ficou com alguma dúvida? Gostaria de fazer uma crítica ou sugestão?</h3>
    <p>Preencha os campos abaixo, que em breve entraremos em contato</p>

    {!! Form::open(['route' => 'web.emails.contact.send', 'method' => 'POST']) !!}

    <div class="row">

        <div class="col-md-6">
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                {{ Form::label('name', 'Nome') }}
                {{ Form::text('name', NULL, ['class' => 'form-control']) }}
                <span class="text-danger">{{ $errors->first('name') }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                {{ Form::label('email', 'Nome') }}
                {{ Form::text('email', NULL, ['class' => 'form-control']) }}
                <span class="text-danger">{{ $errors->first('name') }}</span>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group {{ $errors->has('subject') ? 'has-error' : '' }}">
                {{ Form::label('subject', 'Assunto') }}
                {{ Form::text('subject', NULL, ['class' => 'form-control']) }}
                <span class="text-danger">{{ $errors->first('name') }}</span>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group {{ $errors->has('subject') ? 'has-error' : '' }}">
                {{ Form::label('subject', 'Assunto') }}
                {{ Form::textarea('subject', null, ['class' => 'form-control', 'rows' => 5]) }}
                <span class="text-danger">{{ $errors->first('name') }}</span>
            </div>
        </div>
    </div>

    <div class="mt-4 mx-auto w-25">
        {{ Form::button('Enviar mensagem', ['class' => 'btn btn-lg btn-block btn-info btn-round btn-shadow', 'type' => 'submit']) }}
    </div>

    {!! Form::close() !!}

</div>