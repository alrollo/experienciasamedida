@extends('templates.template-intranet')
@section('page_class', 'page-faqs')

@section('title', "Pregunta - $item->title")
@section('meta_title', "Pregunta - $item->title")
@section('meta_description', 'Pregunta - $item->title')

@section('content-message')
@stop

@section('content-title')
    <a href="{{ url('intranet/faqs') }}" class="nav-link">Preguntas frecuentes</a>
@stop

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pregunta - {{ $item->title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('intranet/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('intranet/faqs') }}">Preguntas frecuentes</a></li>
                        <li class="breadcrumb-item">{{ $item->title }}</li>
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
                    <form class="form-horizontal" method="post" action="{{ url("intranet/faqs/$item->id") }}">
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
                                                    <label for="active">Activa</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6 col-md-4">
                                                <div class="form-group">
                                                    <label for="titleInput">Tipo @if ($errors->has('type_id')) <small class="text-danger">({{ $errors->first('type_id') }})</small>@endif</label>

                                                    <div class="input-group mb-3">
                                                        {{ Form::select('type_id', MasterTable::Get('tipos_faqs')->options->pluck('option', 'id'), old('type_id', $item->type_id), ['id' => 'type_id', 'class' => 'form-control', 'placeholder' => 'Elige un tipo...']) }}

                                                        @canany(['masters.update'])
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-secondary btnAdminMasterOptions" data-id="{{ MasterTable::Get('tipos_faqs')->id }}"  data-name="{{ MasterTable::Get('tipos_faqs')->name }}" data-selectortorefresh="#type_id" type="button"><i class="fas fa-plus"></i></button>
                                                        </div>
                                                        @endcanany
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
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
                                                                <label for="titleInput">Título @if ($errors->has("title.$lang")) <small class="text-danger">({{ $errors->first("title.$lang") }})</small>@endif</label>
                                                                <input type="text" name="title[{{$lang}}]" class="form-control" id="titleInput" placeholder="Título" value="{{ old("title.$lang", $item->translate('title', $lang, false)) }}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="roleInput">Resumen</label>
                                                                <textarea class="form-control" name="summary[{{$lang}}]">{{ old("summary.$lang", $item->translate('summary', $lang, false)) }}</textarea>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="roleInput">Descripción</label>
                                                                <textarea class="form-control summernote" name="description[{{$lang}}]">{{ old("description.$lang", $item->translate('description', $lang, false)) }}</textarea>
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

                            @canany(['faqs.create', 'faqs.update'])
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
    <script src="{{ asset('assets/js/intranet/faqs/FaqForm.js') }}" type="module"></script>
@stop
