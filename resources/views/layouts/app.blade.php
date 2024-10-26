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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
    
    @vite('resources/js/app.js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

</body>

</html>
<script defer>
    function setCookie(name, value, days) {
        const expires = new Date(Date.now() + days * 864e5).toUTCString();
        document.cookie = `${name}=${encodeURIComponent(value)}; expires=${expires}; path=/; SameSite=Lax`;
    }

    function getCookie(name) {
        return document.cookie.split('; ').reduce((r, v) => {
            const parts = v.split('=');
            return parts[0] === name ? decodeURIComponent(parts[1]) : r;
        }, '');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const welcomeModal = document.getElementById('welcomeModal');
        const closeModalButtons = document.querySelectorAll('.btn-close, .btn-secondary');
        const overlay = document.createElement('div');

        if (!getCookie('modalClosed')) {
            welcomeModal.classList.add('zoom-in', 'show');
            welcomeModal.style.display = 'block';
            overlay.classList.add('show');
            document.body.classList.add('modal-open');
            overlay.classList.add('modal-backdrop', 'fade');
            document.body.appendChild(overlay);
        }

        closeModalButtons.forEach(button => {
            button.addEventListener('click', function () {
                closeModal();
            });
        });

        welcomeModal.addEventListener('click', function () {
            welcomeModal.classList.remove('zoom-in');
            welcomeModal.classList.add('bounce');
            setTimeout(() => {
                welcomeModal.classList.remove('bounce');
            }, 500);
        });

        function closeModal() {
            setTimeout(() => {
                welcomeModal.classList.remove('bounce');
            }, 10);
            welcomeModal.classList.remove('zoom-in');
            welcomeModal.classList.add('zoom-out');

            welcomeModal.addEventListener('animationend', function handler() {
                welcomeModal.classList.remove('zoom-out', 'show');
                welcomeModal.style.display = 'none';
                overlay.classList.remove('show');
                document.body.classList.remove('modal-open');
                overlay.remove();
                setCookie('modalClosed', 'true', 30);
                welcomeModal.removeEventListener('animationend', handler);
            });
        }
    });
</script>