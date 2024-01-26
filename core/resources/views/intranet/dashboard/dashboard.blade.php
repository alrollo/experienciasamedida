@extends('templates.template-intranet')
@section('page_class', 'page-dashboard')

@section('title', 'Dashboard')
@section('meta_title', 'Dashboard')
@section('meta_description', 'Dashboard')

@section('content-message')
@stop

@section('content-title')
    <a href="{{ url('intranet/dashboard') }}" class="nav-link">Dashboard</a>
@stop

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                @can('utils.execute')
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Herramientas</h3>
                        </div>

                        <div class="card-body">
                            <div><a href="#" id="btnVaciarCacheVistas">Vaciar cache views</a></div>
                            <div><a href="#" id="btnVaciarCache">Vaciar cache</a></div>
                            <div><a href="#" id="btnCrearLinkStorage">Crear link storage</a></div>
                            <div><a href="#" id="btnEmptyTempFolder">Vaciar carpeta temporal</a></div>
                        </div>
                    </div>
                </div>
                @endcan
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('assets/js/intranet/dashboard/Dashboard.js') }}" type="module"></script>
@stop
