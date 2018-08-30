<div class="contact">
    <h3>Ficou com alguma dúvida? Gostaria de fazer uma crítica ou sugestão?</h3>
    <p>Preencha os campos abaixo, que em breve entraremos em contato</p>

    @include ('core::status-messages')

    {!! Form::open(['route' => 'web.emails.contact.send', 'method' => 'POST', 'class' => '']) !!}

    <div class="row">

        <div class="col-md-6">
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}" data-form="name">
                {{ Form::label('name', 'Nome') }}
                {{ Form::text('name', NULL, ['class' => 'form-control']) }}
                <span class="text-danger">{{ $errors->first('name') }}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}" data-form="email">
                {{ Form::label('email', 'E-mail') }}
                {{ Form::text('email', NULL, ['class' => 'form-control']) }}
                <span class="text-danger">{{ $errors->first('email') }}</span>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group {{ $errors->has('subject') ? 'has-error' : '' }}" data-form="subject">
                {{ Form::label('subject', 'Assunto') }}
                {{ Form::text('subject', NULL, ['class' => 'form-control']) }}
                <span class="text-danger">{{ $errors->first('subject') }}</span>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}" data-form="message">
                {{ Form::label('message', 'Mensagem') }}
                {{ Form::textarea('message', NULL, ['class' => 'form-control', 'rows' => 5]) }}
                <span class="text-danger">{{ $errors->first('message') }}</span>
            </div>
        </div>
    </div>

    <div class="form-group {{ $errors->has('g-recaptcha-response') ? 'has-error' : '' }}" data-form="g-recaptcha-response">
        <div class="g-recaptcha" data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}"></div>
        <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
    </div>

    <div class="mt-4 mx-auto col-md-5">
        {{ Form::button('<span class="ladda-label">Enviar mensagem', ['class' => 'btn btn-lg btn-block btn-info btn-round btn-shadow btn-loading', 'type' => 'submit', 'data-style' => 'zoom-in', 'data-spinner-size' => 30]) }}
    </div>

    {!! Form::close() !!}

</div>