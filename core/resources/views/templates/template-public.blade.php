<!doctype html>
<html class="no-js" lang="{{ app()->getLocale() }}">
<head>
    @if(Configuration::get('general.google_analytics', '') != '' && cookiesAccepted('marketing'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ Configuration::get('general.google_analytics') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', '{{ Configuration::get('general.google_analytics') }}');
        </script>
    @endif

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1, maximum-scale=2" name="viewport">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <link rel="icon" href="{{ asset('assets/template/images-dj/icon.png') }}" type="image/gif" sizes="16x16">


    <title>{{ Seo::Get()->title }}</title>
    <meta name="title" content="{{ Seo::Get()->title }}">
    <meta name="description" content="{{ Seo::Get()->description }}">
    <meta name="keywords" content="{{ Seo::Get()->keywords }}">

    <link id="bootstrap" href="{{ asset('assets/template/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link id="bootstrap-grid" href="{{ asset('assets/template/css/bootstrap-grid.min.css') }}" rel="stylesheet" type="text/css" />
    <link id="bootstrap-reboot" href="{{ asset('assets/template/css/bootstrap-reboot.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/template/css/animate.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/template/css/owl.carousel.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/template/css/owl.theme.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/template/css/owl.transitions.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/template/css/magnific-popup.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/template/css/jquery.countdown.css') }}" rel="stylesheet" type="text/css" />
    <link id="mdb" href="{{ asset('assets/template/css/mdb.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/template/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/template/css/de-dj.css') }}" rel="stylesheet" type="text/css" />

    <link id="colors" href="{{ asset('assets/template/css/colors/scheme-02.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/template/css/coloring.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{ asset('assets/css/public.css') }}">

    @if(Configuration::get('general.pixel_facebook', '') != '' && cookiesAccepted('marketing'))
    <!-- Facebook Pixel Code  de seguimiento -->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t,s)}(window, document,'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ Configuration::get('general.pixel_facebook') }}');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id={{ Configuration::get('general.pixel_facebook') }}&ev=PageView&noscript=1" /></noscript>
        <!-- End Facebook Pixel Code -->
    @endif

    @if(Configuration::get('general.recaptcha', '0') == '1')
        {!! RecaptchaV3::initJs() !!}
    @endif
</head>

<body class="dark-scheme @yield('page_class')">
    <div id="wrapper">
        <div id="preloader">
            <div class="preloader1"></div>
        </div>


        <!-- HEADER -->
        <header class="transparent">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="de-flex sm-pt10">
                            <div class="de-flex-col">
                                <div class="de-flex-col">

                                    <div id="logo">
                                        <a href="{{ url('') }}">
                                            <img alt="" src="{{ asset('assets/template/images-dj/logo-light.png') }}" />
                                        </a>
                                    </div>

                                </div>
                                <div class="de-flex-col">
                                </div>
                            </div>
                            <div class="de-flex-col header-col-mid">

                                <ul id="mainmenu">
                                    <li>@link(["selector" => "inicio"])</li>
                                    <li>@link(["selector" => "quienes-somos"])</li>
                                    <li>@link(["selector" => "que-hacemos"])</li>
                                    <li>@link(["selector" => "experiencias"])</li>
                                    <li>@link(["selector" => "clientes"])</li>
                                    <li>@link(["selector" => "contacto"])</li>
                                    <li>@link(["selector" => "blog"])</li>
                                </ul>
                            </div>
                            <div class="de-flex-col">
                                <div class="menu_side_area">
                                    <a href="#section-tickets" ><img src="{{ asset('assets/template/images-dj/WhatsAppButtonGreenSmall.png') }}" alt="" style=" width:150px"></a>
                                    <span id="menu-btn"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="no-bottom no-top" id="content">
            <div id="top"></div>

            @yield('content')
        </div>

        <!-- content close -->
        <a href="#" id="back-to-top"></a>
        <!-- footer begin -->
        <footer data-bgimage="url({{ asset('assets/template/images-dj/background/2.jpg') }})">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-1">
                        <div class="widget">
                            <img src="{{ asset('assets/template/images/logo-pie.png') }}" class="img-fluid" alt="">

                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12 col-xs-1" style="padding-top:30px">
                        <h2 class="text-center">¡Consúltanos!</h2>
                        <h3 class="text-center">info@experienciasamedida.com | 647 71 53 70</h3>
                        <hr>
                        <p class="text-center">
                            @link(["selector" => "aviso-legal", "class" => "footer-link"]) |
                            @link(["selector" => "politica-de-privacidad", "class" => "footer-link"]) |
                            @link(["selector" => "cookies", "class" => "footer-link"]) |
                            @link(["selector" => "contacto", "class" => "footer-link"])
                        </p>
                    </div>
                </div>
            </div>
            <div class="subfooter">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="de-flex">
                                <div class="de-flex-col">
                                    <a href="https://www.gyastudio.com" target="_blank">
                                        <span class="copy">Desarrollo Web GyA Studio</span>
                                    </a>
                                </div>
                                <div class="de-flex-col">
                                    <div class="social-icons">
                                        <a href="#"><i class="fa fa-facebook fa-lg"></i></a>
                                        <a href="#"><i class="fa fa-twitter fa-lg"></i></a>
                                        <a href="#"><i class="fa fa-linkedin fa-lg"></i></a>
                                        <a href="#"><i class="fa fa-pinterest fa-lg"></i></a>
                                        <a href="#"><i class="fa fa-rss fa-lg"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer close -->
    </div>

    @can('seo.update')
        @include('public.seo.seo')
    @endcan

    @include('public.cookies.cookies')

    <!-- Javascript Files
    ================================================== -->
    <script src="{{ asset('assets/template/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/jquery.isotope.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/easing.js') }}"></script>
    <script src="{{ asset('assets/template/js/owl.carousel.js') }}"></script>
    <script src="{{ asset('assets/template/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/enquire.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/jquery.plugin.js') }}"></script>
    <script src="{{ asset('assets/template/js/jquery.countTo.js') }}"></script>
    <script src="{{ asset('assets/template/js/jquery.countdown.js') }}"></script>
    <script src="{{ asset('assets/template/js/jquery.lazy.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/jquery.lazy.plugins.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/mdb.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/jquery.countdown.js') }}"></script>
    <script src="{{ asset('assets/template/js/countdown-custom.js') }}"></script>
    <script src="{{ asset('assets/template/js/cookit.js') }}"></script>
    <script src="{{ asset('assets/template/js/designesia.js') }}"></script>


    <script src="{{ asset('assets/plugins/gya_cookies-manager/gya_cookies-manager.js') }}"></script>
    <script src="{{ asset('assets/plugins/gya_accessibility/gya_accessibility.js') }}"></script>
    <script src="{{ asset('assets/plugins/gya_hotkeys/gya_hotkeys.js') }}"></script>
    <script src="{{ asset('assets/plugins/gya_cookies/gya_cookies.js') }}"></script>



    @if(Configuration::get('general.recaptcha', '0') == '1')
        <script type="text/javascript">
            $(window).on('load', function () {
                let textarea = document.getElementById("g-recaptcha-response-100000");
                if (textarea) {
                    textarea.setAttribute("aria-hidden", "true");
                    textarea.setAttribute("aria-label", "do not use");
                    textarea.setAttribute("aria-readonly", "true");
                }
            });
        </script>
    @endif
</body>
</html>
