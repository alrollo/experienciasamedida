@extends('templates.template-intranet')
@section('page_class', 'page-reviews')

@section('title', "Reseña - $item->title")
@section('meta_title', "Reseña - $item->title")
@section('meta_description', 'Reseña - $item->title')

@section('content-message')
@stop

@section('content-title')
    <a href="{{ url('intranet/reviews') }}" class="nav-link">Reseñas</a>
@stop

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Reseña - {{ $item->title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('intranet/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('intranet/reviews') }}">Reseñas</a></li>
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
                    <form class="form-horizontal" method="post" action="{{ url("intranet/reviews/$item->id") }}">
                        {{ Form::token() }}
                        <input type="hidden" name="id" id="id" value="{{ $item->id }}" />
                        <input type="hidden" name="secureId" value="{{ encrypt($item->id) }}" />

                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#informacion" data-toggle="tab">Información</a></li>
                                    @if($item->id!=0)
                                        <li class="nav-item"><a class="nav-link" href="#imagenes" data-toggle="tab">Imágenes</a></li>
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
                                                    <label for="active">Activa</label>
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
                                                                <label for="roleInput">Experiencia</label>
                                                                {{ Form::select('experiencia_id', $experiencias->pluck('title', 'id'), old('experiencia_id', $item->experiencia_id), ['class' => 'form-control', 'placeholder' => 'Elige una experiencia...']) }}
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
                                                     data-model="review"
                                                     data-id="{{ $item->id }}">
                                                    @php
                                                        $tagImage = $item->images->where('tag', 'portada')->first();
                                                    @endphp
                                                    <div class="image-entity">
                                                        <div class="text-center font-weight-bold" style="border-bottom: 1px solid #efefef; margin-bottom: 10px; padding-bottom: 5px;">Portada</div>
                                                        <div class="image-container">
                                                            @if ($tagImage)
                                                                <a href="{{ asset('storage/review/'.$tagImage->attachable_id.'/'.$tagImage->file_name) }}" target="_blank"><img src="{{ asset('storage/review/'.$tagImage->attachable_id.'/'.$tagImage->file_name) }}" class="img-fluid"></a>
                                                            @else
                                                                <img src="{{ asset('assets/images/no_photo.png') }}" class="img-fluid">
                                                            @endif
                                                        </div>
                                                        <div class="buttons-container">
                                                            @can(['reviews.update', 'general.upload_files'])
                                                                <a href="#" class="btn btn-default btn-flat btnUploadImage" style="@if($tagImage) display: none; @endif"><i class="fas fa-plus"></i></a>
                                                            @endcan
                                                            @can(['reviews.update', 'general.edit_files'])
                                                                <a href="#" class="btn btn-default btn-flat btnEditImage" data-id="{{ $tagImage ? $tagImage->id : 0 }}" style="@if(!$tagImage) display: none; @endif"><i class="far fa-fw fa-edit"></i></a>
                                                            @endcan
                                                            @can(['reviews.update', 'general.delete_files'])
                                                                <a href="#" class="btn btn-default btn-flat btnDeleteImage" data-id="{{ $tagImage ? $tagImage->id : 0 }}" style="@if(!$tagImage) display: none; @endif"><i class="far fa-fw fa-trash-alt"></i></a>
                                                            @endcan
                                                        </div>
                                                    </div>
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

                            @canany(['reviews.create', 'reviews.update'])
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
    <script src="{{ asset('assets/js/intranet/reviews/ReviewsForm.js') }}" type="module"></script>
@stop
