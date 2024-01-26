@extends('templates.template-intranet')
@section('page_class', 'page-pages')

@section('title', 'Página')
@section('meta_title', 'Página')
@section('meta_description', 'Página')

@section('content-message')
@stop

@section('content-title')
    <a href="{{ url('intranet/pages') }}" class="nav-link">Páginas</a>
@stop

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Página</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('intranet/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('intranet/pages') }}">Páginas</a></li>
                        <li class="breadcrumb-item">{{ $item->name }}</li>
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
                    <form class="form-horizontal" method="post" action="{{ url("intranet/pages/{$item->id}") }}">
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
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="icheck-primary">
                                                        <input type="checkbox" id="active" name="active" @if (old('active', $item->active)) checked @endif>
                                                        <label for="active">
                                                            Activa
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="nameInput">Nombre @if ($errors->has('name')) <small class="text-danger">({{ $errors->first('name') }})</small>@endif</label>
                                                        <input type="text" name="name" class="form-control" id="nameInput" placeholder="Nombre" value="{{ old('name', $item->name) }}">
                                                    </div>
                                                </div>

                                                @canany(['pages.edit_urls'])
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="roleInput">URLs relativas @if ($errors->has('url')) <small class="text-danger">({{ $errors->first('url') }})</small>@endif</label>

                                                        <div id="urlsContainer">
                                                            @foreach ($item->url ?? [] as $url)
                                                            <div class="input-group mb-3 urlContainer">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon1">{{ url('') }}/</span>
                                                                </div>
                                                                <input type="text" name="url[]" class="form-control" id="roleInput" placeholder="URL" value="{{ old("url[]", $url) }}">
                                                                <div class="input-group-append">
                                                                    <a class="btn btn-outline-secondary btnDeleteUrl" href="#" ><i class="far fa-trash-alt"></i></a>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="text-left"><a href="#" id="btnAddUrl" class="btn btn-outline-secondary"><i class="fas fa-plus"></i> Añadir URL</a></div>
                                                </div>
                                                @endcanany
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="modulesWrapper">
                                                @if ($item->id != 0)
                                                    @canany(['pages.create_module'])
                                                        <div class="text-right mb-3"><a href="{{ url("intranet/pages/$item->id/modules/create") }}" class="btn btn-outline-secondary"><i class="fas fa-plus"></i> Añadir módulo</a></div>
                                                    @endcanany
                                                    <div id="modulesContainer">
                                                        @foreach ($item->modules as $module)
                                                            <div class="moduleItem" data-id="{{ $module->id }}">
                                                                <div class="input-group mb-1">
                                                                    <div class="input-group-prepend moveable">
                                                                        <span class="input-group-text"><i class="fa fa-bars"></i></span>
                                                                    </div>
                                                                    <span class="form-control">{{ $module->name }}</span>
                                                                    <div class="input-group-append">
                                                                        @if($module->blocked == false || $module->created_by == \Illuminate\Support\Facades\Auth::user()->id)
                                                                        <a href="{{ url("intranet/pages/$item->id/modules/$module->id") }}" class="btn btn-outline-secondary"><i class="fas fa-pencil-alt"></i></a>
                                                                        <a href="{{ url("intranet/pages/$item->id/modules/$module->id/delete") }}" class="btn btn-outline-secondary btn-delete"><i class="far fa-trash-alt"></i></a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div class="text-center">Debes guardar la página para poder asociar módulos</div>
                                                @endif
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

                        @canany(['pages.create', 'pages.update'])
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
    <script src="{{ asset('assets/js/intranet/pages/PageForm.js') }}" type="module"></script>
@stop
