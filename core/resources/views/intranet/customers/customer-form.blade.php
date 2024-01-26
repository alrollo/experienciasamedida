@extends('templates.template-intranet')
@section('page_class', 'page-customers')

@section('title', "Cliente - $item->full_name")
@section('meta_title', "Cliente - $item->full_name")
@section('meta_description', "Cliente - $item->full_name")

@section('content-message')
@stop

@section('content-title')
    <a href="{{ url('intranet/customers') }}" class="nav-link">Clientes</a>
@stop

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Cliente - {{ $item->full_name }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('intranet/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('intranet/customers') }}">Clientes</a></li>
                        <li class="breadcrumb-item">{{ $item->full_name }}</li>
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
                    <form class="form-horizontal" method="post" action="{{ url("intranet/customers/$item->id") }}">
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
                                                    <input type="checkbox" id="is_company" name="is_company" @if (old('is_company', $item->is_company)) checked @endif>
                                                    <label for="is_company">Es empresa</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-sm-3">
                                                <div class="form-group">
                                                    <label for="nameInput">Alias</label>
                                                    <input type="text" name="alias" maxlength="191" class="form-control" id="aliasInput" placeholder="Alias" value="{{ old("alias", $item->alias) }}">
                                                </div>
                                            </div>

                                            <div class="col-6 col-md-2">
                                                <div class="form-group">
                                                    <label for="dateInput">Fecha de nacimiento @if ($errors->has('birthdate')) <small class="text-danger">({{ $errors->first('birthdate') }})</small>@endif</label>
                                                    <div class="input-group datePicker" id="datePicker" data-target-input="nearest">
                                                        <input name="birthdate" value="{{ old('birthdate', $item->birthdate ? \Carbon\Carbon::parse($item->birthdate)->format('d/m/Y') : '') }}" type="text" class="form-control datepicker-input" data-target="#datePicker" />
                                                        <div class="input-group-append" data-target="#datePicker" data-toggle="datepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-6 offset-md-1 col-md-6">
                                                <div class="form-group">
                                                    <label for="titleInput">Tags</label>

                                                    <div class="input-group mb-3">
                                                        {{ Form::select('tags[]', MasterTable::Get('tags_clientes')->options->pluck('option', 'id'), old('tags[]', $item->tags->pluck('id')->toArray()), ['id' => 'tags', 'class' => 'form-control select2', 'multiple', 'data-placeholder' => 'Tags...']) }}

                                                        @canany(['masters.update'])
                                                            <div class="input-group-append">
                                                                <button class="btn btn-outline-secondary btnAdminMasterOptions" data-id="{{ MasterTable::Get('tags_clientes')->id }}"  data-name="{{ MasterTable::Get('tags_clientes')->name }}" data-selectortorefresh="#tags" type="button"><i class="fas fa-plus"></i></button>
                                                            </div>
                                                        @endcanany
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-sm-3">
                                                <div class="form-group">
                                                    <label for="nameInput">Nombre @if ($errors->has("name")) <small class="text-danger">({{ $errors->first("name") }})</small>@endif</label>
                                                    <input type="text" name="name" maxlength="191" class="form-control" id="nameInput" placeholder="Nombre" value="{{ old("name", $item->name) }}">
                                                </div>
                                            </div>

                                            <div class="col-12 col-sm-6">
                                                <div class="form-group">
                                                    <label for="surnameInput">Apellidos</label>
                                                    <input type="text" name="surname" maxlength="191" class="form-control" id="surnameInput" placeholder="Apellidos" value="{{ old("surname", $item->surname) }}">
                                                </div>
                                            </div>

                                            <div class="col-12 col-sm-3">
                                                <div class="form-group">
                                                    <label for="surnameInput">DNI/NIE/NIF</label>
                                                    <input type="text" name="surname" maxlength="191" class="form-control" id="surnameInput" placeholder="Apellidos" value="{{ old("surname", $item->surname) }}">
                                                </div>
                                            </div>

                                            <div class="col-12 col-sm-4">
                                                <div class="form-group">
                                                    <label for="countryInput">País</label>
                                                    <input type="text" name="country" maxlength="191" class="form-control" id="countryInput" placeholder="País" value="{{ old("country", $item->country) }}">
                                                </div>
                                            </div>

                                            <div class="col-12 col-sm-4">
                                                <div class="form-group">
                                                    <label for="provinceInput">Provincia</label>
                                                    <input type="text" name="province" maxlength="191" class="form-control" id="provinceInput" placeholder="Provincia" value="{{ old("province", $item->province) }}">
                                                </div>
                                            </div>

                                            <div class="col-12 col-sm-4">
                                                <div class="form-group">
                                                    <label for="townInput">Población</label>
                                                    <input type="text" name="town" maxlength="191" class="form-control" id="townInput" placeholder="Población" value="{{ old("town", $item->town) }}">
                                                </div>
                                            </div>

                                            <div class="col-12 col-sm-4">
                                                <div class="form-group">
                                                    <label for="postalCodeInput">Código Postal</label>
                                                    <input type="text" name="postal_code" maxlength="191" class="form-control" id="postalCodeInput" placeholder="Código Postal" value="{{ old("postal_code", $item->postal_code) }}">
                                                </div>
                                            </div>

                                            <div class="col-12 col-sm-8">
                                                <div class="form-group">
                                                    <label for="addressInput">Dirección</label>
                                                    <input type="text" name="address" maxlength="191" class="form-control" id="addressInput" placeholder="Dirección" value="{{ old("address", $item->address) }}">
                                                </div>
                                            </div>

                                            <div class="col-12"><hr /></div>

                                            <div class="col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                    <label for="emailInput">Email @if ($errors->has("email")) <small class="text-danger">({{ $errors->first("email") }})</small>@endif</label>
                                                    <input type="text" name="email" maxlength="191" class="form-control" id="emailInput" placeholder="Email" value="{{ old("email", $item->email) }}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="nameInput">Web</label>
                                                    <input type="text" name="web" maxlength="191" class="form-control" id="webInput" placeholder="Web" value="{{ old("web", $item->web) }}">
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-6">
                                                <div class="mb-2">
                                                    <b>Teléfonos</b>
                                                    <button type="button" id="btnAddPhone" class="btn btn-default btn-xs float-right">Añadir</button>
                                                </div>

                                                <table class="table table-sm">
                                                    <tbody id="phonesContainer">
                                                        @foreach ($item->phones as $phone)
                                                        <tr>
                                                            <td style="width: 150px;"><a href="tel:">{{ $phone->full_phone }}</a></td>
                                                            <td>{{ $phone->description }}</td>
                                                            <td style="width: 50px;" class="text-right">
                                                                <button type="button" class="btn btn-default btn-sm btnDeletePhone" data-id="{{ $phone->id }}"><i class="fas fa-trash"></i></button>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
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
                                                     data-model="customer"
                                                     data-id="{{ $item->id }}">
                                                    @php
                                                        $tagImage = $item->images->where('tag', 'portada')->first();
                                                    @endphp
                                                    <div class="image-entity">
                                                        <div class="text-center font-weight-bold" style="border-bottom: 1px solid #efefef; margin-bottom: 10px; padding-bottom: 5px;">Portada</div>
                                                        <div class="image-container">
                                                            @if ($tagImage)
                                                                <a href="{{ asset('storage/customer/'.$tagImage->attachable_id.'/'.$tagImage->file_name) }}" target="_blank"><img src="{{ asset('storage/customer/'.$tagImage->attachable_id.'/'.$tagImage->file_name) }}" class="img-fluid"></a>
                                                            @else
                                                                <img src="{{ asset('assets/images/no_photo.png') }}" class="img-fluid">
                                                            @endif
                                                        </div>
                                                        <div class="buttons-container">
                                                            @can(['customers.update', 'general.upload_files'])
                                                                <a href="#" class="btn btn-default btn-flat btnUploadImage" style="@if($tagImage) display: none; @endif"><i class="fas fa-plus"></i></a>
                                                            @endcan
                                                            @can(['customers.update', 'general.edit_files'])
                                                                <a href="#" class="btn btn-default btn-flat btnEditImage" data-id="{{ $tagImage ? $tagImage->id : 0 }}" style="@if(!$tagImage) display: none; @endif"><i class="far fa-fw fa-edit"></i></a>
                                                            @endcan
                                                            @can(['customers.update', 'general.delete_files'])
                                                                <a href="#" class="btn btn-default btn-flat btnDeleteImage" data-id="{{ $tagImage ? $tagImage->id : 0 }}" style="@if(!$tagImage) display: none; @endif"><i class="far fa-fw fa-trash-alt"></i></a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr class="divider">
                                            @can(['customers.update', 'general.upload_files'])
                                                <div class="text-left mb-3"><a href="#" class="btn btn-outline-secondary btnUploadImages" data-id="{{ $item->id }}"><i class="fas fa-plus"></i> Añadir Imágenes</a></div>
                                            @endcan
                                            <div class="row" id="imagesContainer">
                                            @foreach($item->images->where('tag', null) as $image)
                                                <div class="col-12 col-md-2 file-entity" data-id="{{ $image->id }}">
                                                    <div class="image-entity">
                                                        <div class="image-container">
                                                            <a href="{{ asset('storage/customer/'.$image->attachable_id.'/'.$image->file_name) }}" target="_blank"><img src="{{ asset('storage/customer/'.$image->attachable_id.'/'.$image->file_name) }}" class="img-fluid"></a>
                                                        </div>
                                                        <div class="buttons-container">
                                                            <a href="#" clasS="btn btn-default btn-flat pull-left moveable"><i class="fa fa-bars"></i></a>
                                                            @can(['customers.update', 'general.edit_files'])
                                                                <a href="#" class="btn btn-default btn-flat btnEditFile" data-id="{{ $image->id }}"><i class="far fa-fw fa-edit"></i></a>
                                                            @endcan
                                                            @can(['customers.update', 'general.delete_files'])
                                                                <a href="#" class="btn btn-default btn-flat btnDeleteImageFromGallery" data-id="{{ $image->id }}"><i class="far fa-fw fa-trash-alt"></i></a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            </div>

                                        </div>

                                        <div class="tab-pane" id="documentos">
                                            @can(['customers.update', 'general.upload_files'])
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
                                                                            @can(['customers.update', 'general.edit_files'])
                                                                                <a href="#" class="btn btn-default btn-flat btnEditFile" data-id="{{ $file->id }}"><i class="far fa-fw fa-edit"></i></a>
                                                                            @endcan
                                                                            @can(['customers.update', 'general.delete_files'])
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

                            @canany(['customers.create', 'customers.update'])
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
    <script src="{{ asset('assets/js/intranet/customers/CustomerForm.js') }}" type="module"></script>
@stop
