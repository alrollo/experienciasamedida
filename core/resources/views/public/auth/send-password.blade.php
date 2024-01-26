@extends('templates.template-intranet-blank')
@section('page_class', 'page-login')
@section('content')
    <div class="login-box">

        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ url('/') }}" class="h1">{!! Configuration::get('intranet.name') !!}</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <p>Hemos generado una nueva contraseña y te la hemos enviado por correo.<br><br>Muchas gracias!</p>
                    </div>
                </div>


                <div class="row">
                    <div class="col-4"><a href="{{ url('login') }}" class="btn btn-light btn-block">Volver</a></div>

                </div>
            </div>
        </div>
    </div>
@stop
