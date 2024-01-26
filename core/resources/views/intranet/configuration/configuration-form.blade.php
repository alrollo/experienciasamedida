@extends('templates.template-intranet')
@section('page_class', 'page-configuration')

@section('title', 'Configuración')
@section('meta_title', 'Configuración')
@section('meta_description', 'Configuración')

@section('content-message')
@stop

@section('content-title')
    <a href="{{ url('intranet/configuration') }}" class="nav-link">Configuración</a>
@stop

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Configuración</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('intranet/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Configuración</li>
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
                    <form class="form-horizontal" method="post" action="{{ url("intranet/configuration") }}">
                        {{ Form::token() }}

                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#informacion" data-toggle="tab">Información</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#emails" data-toggle="tab">Emails</a></li>
                                </ul>
                            </div>

                            <div class="card-body">

                                <div class="tab-content">
                                    <div class="tab-pane active" id="informacion">
                                        <div class="row">
                                            <div class="col-xs-12"><h3 class="mt-10">Intranet</h3></div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-2"><label class="control-label">Nombre APP</label></div>
                                                    <div class="col-md-10"><input type="text" name="value[intranet.name]" value="{{ old('value[intranet.name]', $items['intranet.name'] ?? '') }}" class="form-control" /></div>
                                                </div>
                                            </div>


                                            <div class="col-md-12 mt-2">
                                                <div class="row">
                                                    <div class="col-md-2"><label class="control-label">Google analytics</label></div>
                                                    <div class="col-md-10"><input type="text" name="value[general.google_analytics]" value="{{ old('value[general.google_analytics]', $items['general.google_analytics'] ?? '') }}" class="form-control" /></div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mt-2">
                                                <div class="row">
                                                    <div class="col-md-2"><label class="control-label">Pixel Facebook</label></div>
                                                    <div class="col-md-10"><input type="text" name="value[general.pixel_facebook]" value="{{ old('value[general.pixel_facebook]', $items['general.pixel_facebook'] ?? '') }}" class="form-control" /></div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mt-2">
                                                <div class="row">
                                                    <div class="col-md-2"><label class="control-label">ReCaptcha V3 Google</label></div>
                                                    <div class="col-md-10">
                                                        <div class="icheck-primary">
                                                            <input type="checkbox" id="general.recaptcha" name="value[general.recaptcha]" value="1" @if(old('value[general.recaptcha]', $items['general.recaptcha'] ?? '0') == '1') checked @endif />
                                                            <label for="general.recaptcha"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-xs-12"><h3 class="mt-10">Módulos</h3></div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-2"><label class="control-label">Clientes</label></div>
                                                    <div class="col-md-10">
                                                        <div class="icheck-primary">
                                                            <input type="checkbox" id="modules.customers" name="value[modules.customers]" value="1" @if(old('value[modules.customers]', $items['modules.customers'] ?? '0') == '1') checked @endif />
                                                            <label for="modules.customers"></label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-2"><label class="control-label">Páginas</label></div>
                                                    <div class="col-md-10">
                                                        <div class="icheck-primary">
                                                            <input type="checkbox" id="modules.pages" name="value[modules.pages]" value="1" @if(old('value[modules.pages]', $items['modules.pages'] ?? '0') == '1') checked @endif />
                                                            <label for="modules.pages"></label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-2"><label class="control-label">Artículos</label></div>
                                                    <div class="col-md-10">
                                                        <div class="icheck-primary">
                                                            <input type="checkbox" id="modules.articles" name="value[modules.articles]" value="1" @if(old('value[modules.articles]', $items['modules.articles'] ?? '0') == '1') checked @endif />
                                                            <label for="modules.articles"></label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-2"><label class="control-label">Noticias</label></div>
                                                    <div class="col-md-10">
                                                        <div class="icheck-primary">
                                                            <input type="checkbox" id="modules.news" name="value[modules.news]" value="1" @if(old('value[modules.news]', $items['modules.news'] ?? '0') == '1') checked @endif />
                                                            <label for="modules.news"></label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-2"><label class="control-label">Servicios</label></div>
                                                    <div class="col-md-10">
                                                        <div class="icheck-primary">
                                                            <input type="checkbox" id="modules.services" name="value[modules.services]" value="1" @if(old('value[modules.services]', $items['modules.services'] ?? '0') == '1') checked @endif />
                                                            <label for="modules.services"></label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-2"><label class="control-label">Reseñas</label></div>
                                                    <div class="col-md-10">
                                                        <div class="icheck-primary">
                                                            <input type="checkbox" id="modules.reviews" name="value[modules.reviews]" value="1" @if(old('value[modules.reviews]', $items['modules.reviews'] ?? '0') == '1') checked @endif />
                                                            <label for="modules.reviews"></label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-2"><label class="control-label">Productos</label></div>
                                                    <div class="col-md-10">
                                                        <div class="icheck-primary">
                                                            <input type="checkbox" id="modules.products" name="value[modules.products]" value="1" @if(old('value[modules.products]', $items['modules.products'] ?? '0') == '1') checked @endif />
                                                            <label for="modules.products"></label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-2"><label class="control-label">Promociones</label></div>
                                                    <div class="col-md-10">
                                                        <div class="icheck-primary">
                                                            <input type="checkbox" id="modules.promotions" name="value[modules.promotions]" value="1" @if(old('value[modules.promotions]', $items['modules.promotions'] ?? '0') == '1') checked @endif />
                                                            <label for="modules.promotions"></label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-2"><label class="control-label">Preguntas frecuentes</label></div>
                                                    <div class="col-md-10">
                                                        <div class="icheck-primary">
                                                            <input type="checkbox" id="modules.faqs" name="value[modules.faqs]" value="1" @if(old('value[modules.faqs]', $items['modules.faqs'] ?? '0') == '1') checked @endif />
                                                            <label for="modules.faqs"></label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-2"><label class="control-label">Trabajos</label></div>
                                                    <div class="col-md-10">
                                                        <div class="icheck-primary">
                                                            <input type="checkbox" id="modules.works" name="value[modules.works]" value="1" @if(old('value[modules.works]', $items['modules.works'] ?? '0') == '1') checked @endif />
                                                            <label for="modules.works"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="emails">
                                        <div class="row">
                                            <div class="col-xs-12"><h3 class="mt-10">Emails</h3></div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-2"><label class="control-label">Firma emails</label></div>
                                                    <div class="col-md-10"><textarea name="value[emails.firma]" class="summernote">{{ old('value[emails.firma]', $items['emails.firma'] ?? '') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>

                            @canany(['settings.update'])
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
    <script src="{{ asset('assets/js/intranet/configuration/ConfigurationForm.js') }}" type="module"></script>
    <script type="text/javascript">
        $(function () {
            // Summernote
            $('.summernote').summernote({
                height: 150,   //set editable area's height
                codemirror: { // codemirror options
                    theme: 'monokai'
                },
                toolbar: [
                    ['font', ['bold', 'underline', 'clear']],
                    ['para', ['paragraph']],
                    ['view', ['codeview']],
                ]
            });
        });
    </script>
@stop
