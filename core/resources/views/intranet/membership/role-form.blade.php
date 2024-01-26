@extends('templates.template-intranet')
@section('page_class', 'page-users')

@section('title', 'Membersía / Roles')
@section('meta_title', 'Membersía / Roles')
@section('meta_description', 'Membersía / Roles')

@section('content-message')
@stop

@section('content-title')
    <a href="{{ url('intranet/membership/roles') }}" class="nav-link">Membresía / Roles</a>
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
                        <li class="breadcrumb-item"><a href="{{ url('intranet/membership/roles') }}">Roles</a></li>
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

    @if($errors->any())
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-danger">Hay errores en el formulario</div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form class="form-horizontal" method="post" action="{{ url("intranet/membership/roles/{$item->id}") }}">
                        {{ Form::token() }}
                        <input type="hidden" name="id" id="id" value="{{ $item->id }}" />
                        <input type="hidden" name="secureId" value="{{ encrypt($item->id) }}" />

                        <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#informacion" data-toggle="tab">Información</a></li>
                                <li class="nav-item"><a class="nav-link" href="#permisos" data-toggle="tab">Permisos</a></li>
                                <li class="nav-item"><a class="nav-link" href="#auditoria" data-toggle="tab">Auditoría</a></li>
                            </ul>
                        </div>

                        <div class="card-body">

                            <div class="tab-content">
                                <div class="tab-pane active" id="informacion">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="nameInput">Nombre @if ($errors->has('name_friendly')) <small class="text-danger">({{ $errors->first('name_friendly') }})</small>@endif</label>
                                                        <input type="text" name="name_friendly" class="form-control" id="nameInput" placeholder="Nombre" value="{{ old('name_friendly', $item->name_friendly) }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="roleInput">Rol @if ($errors->has('name')) <small class="text-danger">({{ $errors->first('name') }})</small>@endif</label>
                                                        <input type="text" name="name" class="form-control" id="roleInput" placeholder="Rol" value="{{ old('name', $item->name) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="permisos">
                                    <div class="row">
                                        <div class="col-12">
                                            <table class="table table-bordered table-striped" role="grid">
                                                @foreach($permissions->groupBy('group') as $group => $permissions_grouped)
                                                    <tr><td colspan="3"><h2>{{ $group }}</h2></td></tr>
                                                    @foreach($permissions_grouped as $permission)
                                                        <tr>
                                                            <td>{{ $permission->name_friendly }}</td>
                                                            <td>
                                                                <div class="icheck-primary d-inline">
                                                                    {!! Form::checkbox('permissions[]', $permission->name, in_array($permission->name, $item->permissions->pluck('name')->toArray()), ['id' => 'permiso'.$permission->id]) !!}

                                                                    <label for="permiso{{ $permission->id }}"></label>
                                                                </div>
                                                            </td>
                                                            <td>{{ $permission->description }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            </table>
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

                        @canany(['users.create', 'users.update'])
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
