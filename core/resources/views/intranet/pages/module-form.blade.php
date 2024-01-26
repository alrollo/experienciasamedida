@extends('templates.template-intranet')
@section('page_class', 'page-modules')

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
                    <h1 class="m-0">Módulo</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('intranet/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('intranet/pages') }}">Páginas</a></li>
                        <li class="breadcrumb-item"><a href="{{ url("intranet/pages/$page->id") }}">{{ $page->name }}</a></li>
                        <li class="breadcrumb-item">Módulo</li>
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
                    <form class="form-horizontal" method="post" action="{{ url("intranet/pages/{$page->id}/modules/$item->id") }}">
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
                                        <div class="col-6">
                                            <div class="icheck-primary">
                                                <input type="checkbox" id="active" name="active" @if (old('active', $item->active)) checked @endif>
                                                <label for="active">
                                                    Activa
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="icheck-primary">
                                                <input type="checkbox" id="blocked" name="blocked" @if (old('blocked', $item->blocked)) checked @endif>
                                                <label for="blocked">
                                                    Bloqueado <small>(Solo el creado podrá editarlo)</small>
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

                                        <div class="col-12">
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                @foreach ($languages as $lang)
                                                <li class="nav-item">
                                                    <a class="nav-link @if($loop->first) active @endif" id="contenido-{{$lang}}-tab" data-toggle="tab" href="#contenido-{{$lang}}" role="tab" aria-controls="contenido-{{$lang}}" aria-selected="true"><div class="fflag fflag-{{ strtoupper($lang) }} ff-sm" title="{{ $lang }}"></div></a>
                                                </li>
                                                @endforeach
                                            </ul>
                                            <div class="tab-content" id="myTabContent">
                                                @foreach ($languages as $lang)
                                                <div class="tab-pane tab-pane-bordered fade @if($loop->first) show active @endif" id="contenido-{{$lang}}" role="tabpanel" aria-labelledby="home-tab">
                                                    <div class="form-group">
                                                        <label for="roleInput">Contenido @if ($errors->has('content')) <small class="text-danger">({{ $errors->first('content') }})</small>@endif</label>
                                                        <textarea class="form-control summernote" name="content[{{$lang}}]">{{ old("content.$lang", $item->translate('content', $lang)) }}</textarea>
                                                    </div>
                                                </div>
                                                @endforeach
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

                        @canany(['pages.create_module', 'pages.update_module'])
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
    <script src="{{ asset('assets/js/intranet/pages/ModuleForm.js') }}" type="module"></script>
@stop
