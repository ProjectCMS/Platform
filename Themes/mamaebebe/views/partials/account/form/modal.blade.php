<div class="modal fade modal-login" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="login-label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="right-content"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="left-content" data-tab="register">
                            <div class="register-content item-content">
                                <div class="description-content d-flex flex-column justify-content-center">
                                    <span>Cadastre-se</span>
                                    <h2>Torne-se um membro</h2>
                                    <p>Informe seus dados abaixo</p>
                                    {!! Form::open(['route' => 'web.clients.register', 'method' => 'POST', 'class' => 'form-ajax']) !!}
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}" data-form="name">
                                        {{ Form::text('name', NULL, ['class' => 'form-control', 'placeholder' => 'Nome', 'autocomplete' => 'off']) }}
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    </div>
                                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}" data-form="email">
                                        {{ Form::text('email', NULL, ['class' => 'form-control', 'placeholder' => 'E-mail', 'autocomplete' => 'off']) }}
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    </div>
                                    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}" data-form="password">
                                        {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Senha']) }}
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    </div>
                                    {{ Form::button('Cadastre-se', ['class' => 'btn btn-info btn-block', 'type' => 'submit']) }}
                                    {!! Form::close() !!}

                                    @if(Request::secure())
                                        <div class="or"><span>Ou inscreva-se usando</span></div>
                                        @include('partials.account.form.btn_social')
                                    @endif

                                </div>
                                <footer>
                                    <p>
                                        <a href="#" class="pull-right modal-login-tab" data-tab="login">Já tenho minha
                                            conta</a>
                                    </p>
                                </footer>
                            </div>

                            <div class="login-content item-content">
                                <div class="description-content d-flex flex-column justify-content-center">
                                    <span>Login</span>
                                    <h2>Bem vindo de volta</h2>
                                    <p>Informe seus dados abaixo</p>
                                    {!! Form::open(['route' => 'web.clients.login', 'method' => 'POST', 'class' => 'form-ajax']) !!}
                                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}" data-form="email">
                                        {{ Form::text('email', NULL, ['class' => 'form-control', 'placeholder' => 'E-mail', 'autocomplete' => 'off']) }}
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    </div>
                                    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}" data-form="password">
                                        {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Senha']) }}
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    </div>
                                    <div class="mb-3 text-right">
                                        <a href="#">Esqueci minha senha</a>
                                    </div>
                                    {{ Form::button('Login', ['class' => 'btn btn-info btn-block', 'type' => 'submit']) }}
                                    {!! Form::close() !!}

                                    @if(Request::secure())
                                        <div class="or"><span>Ou faça o login usando</span></div>
                                        @include('partials.account.form.btn_social')
                                    @endif

                                </div>
                                <footer>
                                    <p>
                                        <a href="#" class="pull-right modal-login-tab" data-tab="register">Ainda não
                                            tenho minha conta</a>
                                    </p>
                                </footer>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

