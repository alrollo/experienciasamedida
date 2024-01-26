<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{!! csrf_token() !!}">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        @yield('metas')

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

        <link rel="stylesheet" href="{{ asset('assets/plugins/flags/freakflags.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/adminlte-3.2.0/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-5.15.4/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap-3.0.1/icheck-bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/select2-4.0.13/css/select2.min.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

        <link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-5.39.0/tempusdominus-bootstrap-4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/summernote-0.8.18/summernote-bs4.min.css') }}">
        <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.css">
        <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.css">

        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/intranet.css') }}">
    </head>

    <body class="hold-transition sidebar-mini @yield('page_class')">

        <div class="wrapper">

            <nav class="main-header navbar navbar-expand navbar-white navbar-light">

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        @yield('content-title')
                    </li>
                </ul>

                <ul class="navbar-nav ml-auto">

                    <li class="nav-item">
                        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                            <i class="fas fa-expand-arrows-alt"></i>
                        </a>
                    </li>

                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ url(Storage::url('users/'.Auth::user()->avatar)) }}" class="user-image img-circle elevation-2" alt="User Image">
                            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                            <li class="user-header bg-primary">
                                <img src="{{ url(Storage::url('users/'.Auth::user()->avatar)) }}" class="img-circle elevation-2" alt="User Image">
                                <p>
                                    {{ Auth::user()->name }}
                                    <small>{{ Auth::user()->email }}</small>
                                </p>
                            </li>

                            @impersonating($guard = null)
                            <li class="user-body">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <a href="{{ route('intranet.users.leave-impersonate') }}" class="btn btn-block btn-warning btn-sm">Volver a tu usuario</a>
                                    </div>
                                </div>
                            </li>
                            @endImpersonating

                            @can(['users.impersonate'])
                                <li class="user-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <form class="form-horizontal" method="post" action="{{ route('intranet.users.impersonate') }}">
                                                {{ csrf_field() }}
                                                {{ Form::select('impersonate_id', Users::GetAll()->pluck('email', 'id'), null, ['class' => 'form-control', 'style' => '', 'placeholder' => 'Suplantar a...',  'onchange' => 'this.form.submit()']) }}
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            @endcan

                            <li class="user-footer">
                                <a href="{{ url('intranet/membership/users/me') }}" class="btn btn-default btn-flat">Perfil</a>
                                <a href="{{ url('logout') }}" class="btn btn-default btn-flat float-right">Salir</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                            <i class="fas fa-th-large"></i>
                        </a>
                    </li>
                </ul>
            </nav>

            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <a href="{{ url('') }}" class="brand-link">
                    <span class="brand-text font-weight-light">{!! Configuration::get('intranet.name', 'GYAsys 3.0') !!}</span>
                </a>

                <div class="sidebar">
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                            @can('general.acceso_intranet')
                            <li class="nav-item">
                                <a href="{{ url('intranet/dashboard') }}" class="nav-link">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li>
                            @endcan

                            @can('users.view')
                            <li class="nav-item">
                                <a href="{{ url('intranet/membership/users') }}" class="nav-link">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Usuarios</p>
                                </a>
                            </li>
                            @endcan

                            @can('roles.view')
                            <li class="nav-item">
                                <a href="{{ url('intranet/membership/roles') }}" class="nav-link">
                                    <i class="nav-icon fas fa-users-cog"></i>
                                    <p>Roles</p>
                                </a>
                            </li>
                            @endcan

                            @can('languages.view')
                                <li class="nav-item">
                                    <a href="{{ url('intranet/languages') }}" class="nav-link">
                                        <i class="nav-icon fas fa-flag"></i>
                                        <p>Idiomas</p>
                                    </a>
                                </li>
                            @endcan

                            @can('translations.view')
                                <li class="nav-item">
                                    <a href="{{ url('intranet/translations') }}" class="nav-link">
                                        <i class="nav-icon fas fa-flag"></i>
                                        <p>Traducciones</p>
                                    </a>
                                </li>
                            @endcan

                            @can('configuration.view')
                            <li class="nav-item">
                                <a href="{{ url('intranet/configuration') }}" class="nav-link">
                                    <i class="nav-icon fas fa-cogs"></i>
                                    <p>Configuración</p>
                                </a>
                            </li>
                            @endcan

                            @can('masters.view')
                                <li class="nav-item">
                                    <a href="{{ url('intranet/masters') }}" class="nav-link">
                                        <i class="nav-icon fas fa-list"></i>
                                        <p>Maestras</p>
                                    </a>
                                </li>
                            @endcan

                            @if(Configuration::get('modules.customers', '0') == '1')
                                @can('customers.view')
                                    <li class="nav-item">
                                        <a href="{{ url('intranet/customers') }}" class="nav-link">
                                            <i class="nav-icon fas fa-address-book"></i>
                                            <p>Clientes</p>
                                        </a>
                                    </li>
                                @endcan
                            @endif

                            @if(Configuration::get('modules.pages', '0') == '1')
                                @can('pages.view')
                                    <li class="nav-item">
                                        <a href="{{ url('intranet/pages') }}" class="nav-link">
                                            <i class="nav-icon fas fa-file-code"></i>
                                            <p>Páginas</p>
                                        </a>
                                    </li>
                                @endcan
                            @endif

                            @if(Configuration::get('modules.articles', '0') == '1')
                                @can('articles.view')
                                    <li class="nav-item">
                                        <a href="{{ url('intranet/articles') }}" class="nav-link">
                                            <i class="nav-icon far fa-file-word"></i>
                                            <p>Articulos</p>
                                        </a>
                                    </li>
                                @endcan
                            @endif

                            @if(Configuration::get('modules.news', '0') == '1')
                                @can('news.view')
                                    <li class="nav-item">
                                        <a href="{{ url('intranet/news') }}" class="nav-link">
                                            <i class="nav-icon fas fa-newspaper"></i>
                                            <p>Noticias</p>
                                        </a>
                                    </li>
                                @endcan
                            @endif

                            @if(Configuration::get('modules.services', '0') == '1')
                                @can('services.view')
                                    <li class="nav-item">
                                        <a href="{{ url('intranet/services') }}" class="nav-link">
                                            <i class="nav-icon fas fa-tools"></i>
                                            <p>Servicios</p>
                                        </a>
                                    </li>
                                @endcan
                            @endif

                            @if(Configuration::get('modules.reviews', '0') == '1')
                                @can('reviews.view')
                                    <li class="nav-item">
                                        <a href="{{ url('intranet/reviews') }}" class="nav-link">
                                            <i class="nav-icon far fa-comments"></i>
                                            <p>Reseñas</p>
                                        </a>
                                    </li>
                                @endcan
                            @endif

                            @if(Configuration::get('modules.products', '0') == '1')
                                @can('products.view')
                                    <li class="nav-item">
                                        <a href="{{ url('intranet/products') }}" class="nav-link">
                                            <i class="nav-icon fas fa-gifts"></i>
                                            <p>Productos</p>
                                        </a>
                                    </li>
                                @endcan
                            @endif

                            @if(Configuration::get('modules.promotions', '0') == '1')
                                @can('promotions.view')
                                    <li class="nav-item">
                                        <a href="{{ url('intranet/promotions') }}" class="nav-link">
                                            <i class="nav-icon fas fa-medal"></i>
                                            <p>Promociones</p>
                                        </a>
                                    </li>
                                @endcan
                            @endif

                            @if(Configuration::get('modules.faqs', '0') == '1')
                                @can('faqs.view')
                                    <li class="nav-item">
                                        <a href="{{ url('intranet/faqs') }}" class="nav-link">
                                            <i class="nav-icon fas fa-question"></i>
                                            <p>Preguntas frecuentes</p>
                                        </a>
                                    </li>
                                @endcan
                            @endif

                            @if(Configuration::get('modules.works', '0') == '1')
                                @can('works.view')
                                    <li class="nav-item">
                                        <a href="{{ url('intranet/works') }}" class="nav-link">
                                            <i class="nav-icon fas fa-briefcase"></i>
                                            <p>Trabajos</p>
                                        </a>
                                    </li>
                                @endcan
                            @endif
                        </ul>
                    </nav>

                </div>

            </aside>

            <div class="content-wrapper">
                @yield('content')
            </div>

            <aside class="control-sidebar control-sidebar-dark">
                <div class="p-3">
                    <h5>Calendario</h5>
                    <div id="calendarSidebar"></div>

                </div>
            </aside>

            <footer class="main-footer">
                <div class="float-right d-none d-sm-inline">GyA Studio 2023</div>
                GYAsys3.0
            </footer>
        </div>

        <!-- Modals -->


        @include('templates.template-intranet-modals')
        @include('templates.template-intranet-handlebars')

        <script type="text/javascript" src="{{ asset('assets/plugins/jquery-3.6.3/jquery-3.6.3.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-4.6.2/js/bootstrap.bundle.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/adminlte-3.2.0/js/adminlte.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/select2-4.0.13/js/select2.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/plupload-2.3.9/js/plupload.full.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/moment-2.29.4/moment-with-locales.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/tempusdominus-5.39.0/tempusdominus-bootstrap-4.min.js') }}"></script>
        <script src="//cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.js"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/html5sortable-0.13.3/html5sortable.min.js') }}"></script>

        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.js"></script>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.js"></script>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/2.36.0/formatting.js"></script>
        <script type="text/javascript" src="{{ asset('assets/plugins/summernote-0.8.18/summernote-bs4.min.js') }}"></script>


        <script type="text/javascript">
            var common = {};
            common.Host = '{{ url('') }}';
            common.Languages = {!! json_encode(Language::GetArray()) !!};
        </script>
        <script src="{{ asset('assets/js/intranet/Core.js') }}" type="module"></script>
        @yield('js')
    </body>
</html>
