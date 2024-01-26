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

        <link rel="stylesheet" href="{{ asset('assets/plugins/adminlte-3.2.0/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-5.15.4/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap-3.0.1/icheck-bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/intranet.css') }}">
    </head>

    <body class="@yield('page_class')">

        @yield('content')

        <script src="{{ asset('assets/plugins/jquery-3.6.3/jquery-3.6.3.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/bootstrap-4.6.2/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/adminlte-3.2.0/js/adminlte.min.js') }}"></script>
    </body>
</html>
