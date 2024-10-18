<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('/images/logos/Favicon.ico') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
</head>

<body class="d-flex flex-column min-vh-100">
    <header>
        @include('layouts.navbar')
    </header>

    <noscript>
        <style>
            .noscript-warning {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 50vh;
                min-height: 500px;
                text-align: center;
                background-color: #f8d7da;
                color: #721c24;
                padding: 20px;
                font-size: 1.2em;
                border: 1px solid #f5c6cb;
            }
        </style>
        <div class="noscript-warning">
            <div>
                <strong>JavaScript is vereist!</strong>
                <p>Deze website werkt niet zonder JavaScript ingeschakeld in uw browser.</p>
                <p>Neem alstublieft de tijd om JavaScript in te schakelen om toegang te krijgen tot alle functies van deze site.</p>
            </div>
        </div>
    </noscript>

    <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
        <strong>Let op!</strong> Deze website is momenteel in ontwikkeling. Sommige functies zijn mogelijk nog niet beschikbaar.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div id="app" class="flex-grow-1">
        <main>

            @yield('content')
        </main>
    </div>

    <footer class="mt-auto">
        @include('layouts.footer')
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

</body>

</html>
