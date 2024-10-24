<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name='robots' content='index, follow' />
    {{-- <link rel="stylesheet" href="{{ asset(mix('vendors/css/file-uploaders/dropzone.min.css')) }}"> --}}


    <link rel="canonical" href="@yield('cononical-tag')">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" rel="stylesheet"/>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alata&family=Poppins:wght@200;400&display=swap"
        rel="stylesheet">
    {{-- <link href="https://fonts.googleapis.com/css2?family=Alata&family=Castoro+Titling&family=Castoro:ital@1&family=Poppins:wght@200;400&display=swap" rel="stylesheet"> --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Alata&family=Castoro+Titling&family=Castoro:ital@0;1&family=Poppins:wght@200;400&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Alata&family=Castoro+Titling&family=Castoro:ital@0;1&family=Inter:wght@400;700&family=Poppins:wght@200;400&display=swap"
        rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <meta property="og:title" content="@yield('og:title')" />
    <meta name="description" content="@yield('description')">
    <meta name="og:description" content="@yield('og-description')">
    <meta name="keywords" content="@yield('keywords')">
    <meta property="og:image" content="@yield('og:image')">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo/favicon.ico') }}">
    <script src="https://js.stripe.com/v3"></script>

    <!-- Scripts -->
    <script src="{{ asset(mix('js/app.js')) }}" defer></script>

    <script src="https://kit.fontawesome.com/f5e36eb0fd.js" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.14/vue.js"></script>
    {{-- <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.18.1/build/cssreset/cssreset-min.css">
    <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.18.1/build/cssreset/cssreset-min.css"> --}}

    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com"> --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prata&family=Roboto&display=swap" rel="stylesheet">

</head>
<body class="main-body">


    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WDXSNMK8" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>

    <div id="app">
        <main>
            @yield('content')
        </main>
    </div>
</body>

</html>
