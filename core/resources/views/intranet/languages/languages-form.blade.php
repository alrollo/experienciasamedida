@extends('templates.template-intranet')
@section('page_class', 'page-languages')

@section('title', "Idiomas")
@section('meta_title', "Idiomas")
@section('meta_description', 'Idiomas')

@section('content-message')
@stop

@section('content-title')
    <a href="{{ url('intranet/languages') }}" class="nav-link">Idiomas</a>
@stop

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Idiomas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('intranet/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Idiomas</li>
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
                    <form class="form-horizontal" method="post" action="{{ url("intranet/languages") }}">
                        {{ Form::token() }}
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#informacion" data-toggle="tab">Información</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#auditoria" data-toggle="tab">Auditoría</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <table id="tdItems" class="table table-bordered table-striped table-sm">
                                    <thead>
                                    <tr>
                                        <th>Idioma</th>
                                        <th style="width: 72px;">Activo</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $item->name }} ({{ $item->culture }})</td>
                                            <td>
                                                @if ($item->language != 'es')
                                                <div class="icheck-primary">
                                                    <input type="checkbox" id="{{$item->id}}" value="1" name="language[{{ $item->id }}]" @if (old('language['.$item->id.']', $item->active)) checked @endif>
                                                    <label for="{{$item->id}}"></label>
                                                </div>
                                                @else
                                                    <div class="icheck-primary">
                                                        <input type="checkbox" value="1" checked disabled="disabled">
                                                        <label></label>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot></tfoot>
                                </table>
                            </div>

                            @canany(['languages.update'])
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
@stop
