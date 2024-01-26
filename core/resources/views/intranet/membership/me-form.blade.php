@extends('templates.template-intranet')
@section('page_class', 'page-users')

@section('title', 'Membersía / Usuarios')
@section('meta_title', 'Membersía / Usuarios')
@section('meta_description', 'Membersía / Usuarios')

@section('content-message')
@stop

@section('content-title')
    <a href="{{ url('intranet/membership/users') }}" class="nav-link">Membresía / Usuarios</a>
@stop

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Membresía / Usuario</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('intranet/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Membresía</li>
                        <li class="breadcrumb-item"><a href="{{ url('intranet/membership/users') }}">Usuarios</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

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



    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form class="form-horizontal" method="post" action="{{ url("intranet/membership/users/me") }}">
                        {{ Form::token() }}
                        <input type="hidden" name="id" id="id" value="{{ $item->id }}" />
                        <input type="hidden" name="secureId" value="{{ encrypt($item->id) }}" />

                        <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#informacion" data-toggle="tab">Información</a></li>
                                <li class="nav-item"><a class="nav-link" href="#auditoria" data-toggle="tab">Auditoría</a></li>
                            </ul>
                        </div>

                        <div class="card-body">

                            <div class="tab-content">
                                <div class="tab-pane active" id="informacion">
                                    <div class="row">
                                        <div class="col-12 col-md-3">
                                            <div class="text-center" id="imageProfileContainer">
                                                <img id="imageProfileImg" class="profile-user-img img-fluid img-circle" src="{{ url(Storage::url('users/'.$item->avatar)) }}" alt="User profile picture">
                                                <input type="hidden" name="imageProfile" id="imageProfile">
                                                <div><a href="#" id="btnAddImageProfile">Cambiar foto</a></div>
                                                <div><a href="#" id="btnDeleteImageProfile">Eliminar foto</a></div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="nameInput">Nombre @if ($errors->has('name')) <small class="text-danger">({!! $errors->first('name') !!})</small>@endif</label>
                                                        <input type="text" name="name" class="form-control" id="nameInput" placeholder="Nombre" value="{{ old('name', $item->name) }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="nombreInput">Email @if ($errors->has('email')) <small class="text-danger">({!! $errors->first('email') !!})</small>@endif</label>
                                                        <input type="email" name="email" class="form-control" id="emailInput" placeholder="Email" value="{{ old('email', $item->email) }}">
                                                    </div>
                                                </div>

                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="passwordInput">Contraseña</label>
                                                        <input type="password" name="password" class="form-control" id="passwordInput" placeholder="Contraseña">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="confirmPasswordInput">Repetir contraseña</label>
                                                        <input type="password" name="password_confirmation" class="form-control" id="confirmPasswordInput" placeholder="Contraseña">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="auditoria">
                                    <div class="row">
                                        <div class="col-12">
                                            <p>Creado el {{ $item->created_at->isoFormat('LLLL') }} @if($item->creator) por {{ $item->creator->name }} @endif</p>
                                            <p>Modificado el {{ $item->updated_at->isoFormat('LLLL') }} @if($item->updater) por {{ $item->updater->name }} @endif</p>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        @canany(['user.update'])
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-app btn-flat"><i class="fa fa-save"></i> Guardar</button>
                        </div>
                        @endcanany
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@stop

@section('js')
    <script src="{{ asset('assets/js/intranet/membership/UsuarioForm.js') }}" type="module"></script>
@stop
