@extends('templates.template-intranet')
@section('page_class', 'page-articles')

@section('title', "Artículo - $item->title")
@section('meta_title', "Artículo - $item->title")
@section('meta_description', 'Artículo - $item->title')

@section('content-message')
@stop

@section('content-title')
    <a href="{{ url('intranet/articles') }}" class="nav-link">Articulos</a>
@stop

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Artículo - {{ $item->title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('intranet/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('intranet/articles') }}">Artículos</a></li>
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
                    <form class="form-horizontal" method="post" action="{{ url("intranet/articles/$item->id") }}">
                        {{ Form::token() }}
                        <input type="hidden" name="id" id="id" value="{{ $item->id }}" />
                        <input type="hidden" name="secureId" value="{{ encrypt($item->id) }}" />

                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#informacion" data-toggle="tab">Información</a></li>
                                    @if($item->id!=0)
                                        <li class="nav-item"><a class="nav-link" href="#imagenes" data-toggle="tab">Imágenes</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#documentos" data-toggle="tab">Documentos</a></li>
                                    @endif
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
                                                    <label for="active">Activo</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6 col-md-2">
                                                <div class="form-group">
                                                    <label for="dateInput">Fecha @if ($errors->has('dateTime')) <small class="text-danger">({{ $errors->first('dateTime') }})</small>@endif</label>
                                                    <div class="input-group datetimePicker" id="dateTimePicker" data-target-input="nearest">
                                                        <input name="dateTime" value="{{ old('dateTime', \Carbon\Carbon::parse($item->dateTime)->format('d/m/Y H:i')) }}" type="text" class="form-control datetimepicker-input" data-target="#dateTimePicker" />
                                                        <div class="input-group-append" data-target="#dateTimePicker" data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-6 col-md-4">
                                                <div class="form-group">
                                                    <label for="titleInput">Tipo @if ($errors->has('type_id')) <small class="text-danger">({{ $errors->first('type_id') }})</small>@endif</label>

                                                    <div class="input-group mb-3">
                                                        {{ Form::select('type_id', MasterTable::Get('tipos_articulos')->options->pluck('option', 'id'), old('type_id', $item->type_id), ['id' => 'type_id', 'class' => 'form-control', 'placeholder' => 'Elige un tipo...']) }}

                                                        @canany(['masters.update'])
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-secondary btnAdminMasterOptions" data-id="{{ MasterTable::Get('tipos_articulos')->id }}"  data-name="{{ MasterTable::Get('tipos_articulos')->name }}" data-selectortorefresh="#type_id" type="button"><i class="fas fa-plus"></i></button>
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
                                                            <div class="row">
                                                                <div class="col-12 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label for="titleInput">Título @if ($errors->has("title.$lang")) <small class="text-danger">({{ $errors->first("title.$lang") }})</small>@endif</label>
                                                                        <input type="text" name="title[{{$lang}}]" maxlength="191" class="form-control" id="titleInput" placeholder="Título" value="{{ old("title.$lang", $item->translate('title', $lang, false)) }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label for="titleSlugInput">URL</label>
                                                                        <input type="text" name="title_slug[{{$lang}}]" maxlength="191" class="form-control maskSlug" id="titleSlugInput" placeholder="URL" value="{{ old("title_slug.$lang", $item->translate('title_slug', $lang, false)) }}">
                                                                    </div>
                                                                </div>
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

                                    @if($item->id!=0)
                                        <div class="tab-pane" id="imagenes">
                                            <hr class="divider">

                                            <div class="row">
                                                <div class="col-12 col-md-2 file-entity UploadImage"
                                                     data-width="1600"
                                                     data-height="1600"
                                                     data-imageselector=".image-container"
                                                     data-tag="portada"
                                                     data-model="article"
                                                     data-id="{{ $item->id }}">
                                                    @php
                                                        $tagImage = $item->images->where('tag', 'portada')->first();
                                                    @endphp
                                                    <div class="image-entity">
                                                        <div class="text-center font-weight-bold" style="border-bottom: 1px solid #efefef; margin-bottom: 10px; padding-bottom: 5px;">Portada</div>
                                                        <div class="image-container">
                                                            @if ($tagImage)
                                                                <a href="{{ asset('storage/article/'.$tagImage->attachable_id.'/'.$tagImage->file_name) }}" target="_blank"><img src="{{ asset('storage/article/'.$tagImage->attachable_id.'/'.$tagImage->file_name) }}" class="img-fluid"></a>
                                                            @else
                                                                <img src="{{ asset('assets/images/no_photo.png') }}" class="img-fluid">
                                                            @endif
                                                        </div>
                                                        <div class="buttons-container">
                                                            @can(['articles.update', 'general.upload_files'])
                                                                <a href="#" class="btn btn-default btn-flat btnUploadImage" style="@if($tagImage) display: none; @endif"><i class="fas fa-plus"></i></a>
                                                            @endcan
                                                            @can(['articles.update', 'general.edit_files'])
                                                                <a href="#" class="btn btn-default btn-flat btnEditImage" data-id="{{ $tagImage ? $tagImage->id : 0 }}" style="@if(!$tagImage) display: none; @endif"><i class="far fa-fw fa-edit"></i></a>
                                                            @endcan
                                                            @can(['articles.update', 'general.delete_files'])
                                                                <a href="#" class="btn btn-default btn-flat btnDeleteImage" data-id="{{ $tagImage ? $tagImage->id : 0 }}" style="@if(!$tagImage) display: none; @endif"><i class="far fa-fw fa-trash-alt"></i></a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr class="divider">
                                            @can(['articles.update', 'general.upload_files'])
                                                <div class="text-left mb-3"><a href="#" class="btn btn-outline-secondary btnUploadImages" data-id="{{ $item->id }}" data-model="Articles"><i class="fas fa-plus"></i> Añadir Imágenes</a></div>
                                            @endcan
                                            <div class="row" id="imagesContainer">
                                            @foreach($item->images->where('tag', null) as $image)
                                                <div class="col-12 col-md-2 file-entity" data-id="{{ $image->id }}">
                                                    <div class="image-entity">
                                                        <div class="image-container">
                                                            <a href="{{ asset('storage/article/'.$image->attachable_id.'/'.$image->file_name) }}" target="_blank"><img src="{{ asset('storage/article/'.$image->attachable_id.'/'.$image->file_name) }}" class="img-fluid"></a>
                                                        </div>
                                                        <div class="buttons-container">
                                                            <a href="#" clasS="btn btn-default btn-flat pull-left moveable"><i class="fa fa-bars"></i></a>
                                                            @can(['articles.update', 'general.edit_files'])
                                                                <a href="#" class="btn btn-default btn-flat btnEditFile" data-id="{{ $image->id }}"><i class="far fa-fw fa-edit"></i></a>
                                                            @endcan
                                                            @can(['articles.update', 'general.delete_files'])
                                                                <a href="#" class="btn btn-default btn-flat btnDeleteImageFromGallery" data-id="{{ $image->id }}"><i class="far fa-fw fa-trash-alt"></i></a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            </div>

                                        </div>

                                        <div class="tab-pane" id="documentos">
                                            @can(['articles.update', 'general.upload_files'])
                                                <div class="text-left"><a href="#" class="btn btn-outline-secondary btnUploadFiles"><i class="fas fa-plus"></i> Añadir Archivos</a></div>
                                            @endcan

                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    <table class="table table-sm">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col" style="width: 25px;">#</th>
                                                            <th scope="col">Nombre</th>
                                                            <th scope="col">Tamaño</th>
                                                            <th scope="col" style="width: 120px;">&nbsp;</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="filesContainer">
                                                            @foreach($item->files->where('tag', null) as $file)
                                                                <tr class="file-entity" data-id="{{ $file->id }}">
                                                                    <td class="text-left align-middle">
                                                                        <a href="#" clasS="moveable"><i class="fa fa-bars"></i></a>
                                                                    </td>
                                                                    <td class="file-entity-name align-middle">{{ $file->name }}</td>
                                                                    <td class="file-entity-file_size align-middle">{{ formatBytes($file->file_size, 2) }}</td>
                                                                    <td class="align-middle">
                                                                        <div class="buttons-container">
                                                                            @can(['articles.update', 'general.edit_files'])
                                                                                <a href="#" class="btn btn-default btn-flat btnEditFile" data-id="{{ $file->id }}"><i class="far fa-fw fa-edit"></i></a>
                                                                            @endcan
                                                                            @can(['articles.update', 'general.delete_files'])
                                                                                <a href="#" class="btn btn-default btn-flat btnDeleteFile" data-id="{{ $file->id }}"><i class="far fa-fw fa-trash-alt"></i></a>
                                                                            @endcan
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>

                                        </div>
                                    @endif

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

                            @canany(['articles.create', 'articles.update'])
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
    <script src="{{ asset('assets/js/intranet/articles/ArticleForm.js') }}" type="module"></script>
@stop
