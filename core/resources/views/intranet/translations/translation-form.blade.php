@extends('templates.template-intranet')
@section('page_class', 'page-translations')

@section('title', "Traducción - $item->mark")
@section('meta_title', "Traducción - $item->mark")
@section('meta_description', 'Traducción - $item->mark')

@section('content-message')
@stop

@section('content-title')
    <a href="{{ url('intranet/translations') }}" class="nav-link">Traducciones</a>
@stop

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Traducción - {{ $item->mark }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('intranet/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('intranet/translations') }}">Traducciones</a></li>
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
                    <form class="form-horizontal" method="post" action="{{ url("intranet/translations/$item->id") }}">
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
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="titleInput">Marca</label>
                                                    <label class="form-control" readonly>{{ old("mark", $item->mark) }}</label>
                                                </div>

                                                <label for="titleInput">Traducción @if ($errors->has("translation.es")) <small class="text-danger">({{ $errors->first("translation.es") }})</small>@endif</label>
                                                @foreach ($languages as $lang)
                                                    <div class="form-group">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon1"><div class="fflag fflag-{{ strtoupper($lang) }} ff-sm" title="{{ $lang }}"></div></span>
                                                            </div>

                                                            <textarea  name="translation[{{$lang}}]" class="form-control" id="titleInput" placeholder="Traducción" rows="3">{{ old("translation.$lang", $item->translate('translation', $lang, false)) }}</textarea>
                                                        </div>
                                                    </div>
                                                @endforeach
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

                            @canany(['translations.create', 'translations.update'])
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
    <script src="{{ asset('assets/js/intranet/translations/TranslationForm.js') }}" type="module"></script>
    <script type="text/javascript">
        $(function () {

        });
    </script>
@stop
