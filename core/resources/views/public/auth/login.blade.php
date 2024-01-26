@extends('templates.template-intranet-blank')
@section('page_class', 'page-login')
@section('content')

    <div class="login-box">

        @if (isset($error))
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endif

        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ url('/') }}" class="h1">{!! Configuration::get('intranet.name') !!}</a>
            </div>
            <div class="card-body">
                <form action="{{ url('login') }}" method="post">
                    {{ csrf_field() }}

                    @if($errors->has('email')) <label class="col-form-label text-danger text-thin"><i class="far fa-times-circle"></i> {{ $errors->first('email') }}</label>@endif
                    <div class="input-group mb-3">
                        <input type="text" name="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    @if($errors->has('password')) <label class="col-form-label text-danger text-thin"><i class="far fa-times-circle"></i> {{ $errors->first('password') }}</label>@endif
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Contraseña">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Recordarme
                                </label>
                            </div>
                        </div>

                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                        </div>

                    </div>
                </form>
                <hr>
                <p class="mb-1">
                    <a href="{{ url('auth/forgot-password') }}">He olvidado mi contraseña</a>
                </p>
                <p class="mb-0">
                    <a href="{{ url('auth/register') }}" class="text-center">Registrarme como usuario nuevo</a>
                </p>
            </div>

        </div>

    </div>
@stop
