@extends('templates.template-intranet-blank')
@section('page_class', 'page-login')
@section('content')

    <div class="login-box">

        @if (isset($error))
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endif

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            @if (session('message.success'))
                                <div class="alert alert-success">
                                    {{ session('message.success') }}
                                </div>
                            @endif

                            @if (session('message.error'))
                                <div class="alert alert-danger">
                                    {{ session('message.error') }}
                                </div>
                            @endif

                            @if (session('message.info'))
                                <div class="alert alert-info">
                                    {{ session('message.info') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ url('/') }}" class="h1">{!! Configuration::get('intranet.name') !!}</a>
            </div>
            <div class="card-body">
                <form action="{{ url('auth/forgot-password') }}" method="post">
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

                    <div class="row">
                        <div class="col-4"><a href="{{ url('login') }}" class="btn btn-light btn-block">Volver</a></div>
                        <div class="col-4"></div>

                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Recuperar</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>

    </div>

@stop
