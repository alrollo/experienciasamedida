@extends('templates.template-intranet')
@section('page_class', 'page-promotions')

@section('title', 'Promociones')
@section('meta_title', 'Promociones')
@section('meta_description', 'Promociones')

@section('content-message')
@stop

@section('content-title')
    <a href="{{ url('intranet/promotions') }}" class="nav-link">Promociones</a>
@stop

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Promociones</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('intranet/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Promociones</li>
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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Listado de Promociones</h3>
                            @canany(['promotions.create'])
                            <a href="{{ url('intranet/promotions/create') }}" class="btn btn-light btn-sm float-right"><i class="fas fa-plus"></i> Añadir</a>
                            @endcanany
                        </div>

                        <div class="card-body">
                            <table id="tdItems" class="table table-bordered table-striped table-sm">
                                <thead>
                                <tr>
                                    <th class="table-selector">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="selectAll">
                                            <label for="selectAll"></label>
                                        </div>
                                    </th>
                                    <th>Título</th>
                                    <th style="width: 72px;"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($items as $item)
                                <tr>
                                    <td class="table-selector">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" data-id="{{ $item->id }}" class="selectOne" id="selectItem_{{ $item->id }}">
                                            <label for="selectItem_{{ $item->id }}"></label>
                                        </div>
                                    </td>
                                    <td>@if(!$item->active) <b class="text-danger">·</b> @endif{{ $item->translate('title', 'es') }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                            @canany(['promotions.update'])
                                            <a href="{{ url("intranet/promotions/{$item->id}") }}" class="btn btn-light"><i class="fas fa-pencil-alt"></i></a>
                                            @endcanany
                                            @canany(['promotions.delete'])
                                            <a href="{{ url("intranet/promotions/{$item->id}/delete") }}" class="btn btn-light btnDelete"><i class="fas fa-trash"></i></a>
                                            @endcanany
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                                <tfoot></tfoot>
                            </table>
                        </div>

                        <div class="card-footer">
                            <a href="#" class="btn btn-light invisible"><i class="fas fa-trash"></i> Eliminar seleccionados</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('js')
@stop
