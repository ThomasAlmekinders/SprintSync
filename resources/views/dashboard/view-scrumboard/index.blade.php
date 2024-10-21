@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('dashboard.view-scrumboard.layouts.sidebar')

        <main class="col-md-9 ms-sm-auto col-lg-10 px-4 main-content">
            <button class="btn btn-primary d-md-none w-100" id="sidebarToggle">
                <i class="bi bi-list"></i> Menu
            </button>

            @yield('dashboard-content')
        </main>
    </div>
</div>

<style>
    .sidebar .nav-link {
        padding: 10px 15px;
        font-size: 1rem;
        color: #333;
    }

    .sidebar .nav-link.active {
        font-weight: bold;
        color: #0d6efd;
        background-color: rgba(13, 110, 253, 0.1);
        border-left: 3px solid #0d6efd;
    }

    .sidebar .nav-link:hover {
        background-color: rgba(0, 123, 255, 0.1);
        color: #0d6efd;
    }

    @media (max-width: 767.98px) {
        .sidebar {
            position: fixed;
            width: 100%;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 1000;
            visibility: hidden;
            opacity: 0;
            transition: visibility 0s, opacity 0.125s linear;
            background-color: #f8f9fa;
            border-right: none;
        }

        .sidebar.show {
            visibility: visible;
            opacity: 1;
            display: flex;
            flex-direction: column;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .main-content {
            margin-left: 0;
        }
    }

    html:has(body.no-scroll) {
        padding: 0px;
    }
    body.no-scroll {
        overflow: hidden;
        max-height: 100vh;
    }
    .sidebar h5 {
        font-size: 1.25rem;
        font-weight: bold;
        border-bottom: 1px solid #fff; /* Subtiele onderlijn */
    }
</style>

<script defer>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const closeButton = document.getElementById('sidebarClose');

        toggleButton.addEventListener('click', function() {
            sidebar.classList.toggle('show');
            document.body.classList.toggle('no-scroll', sidebar.classList.contains('show'));
        });

        closeButton.addEventListener('click', function() {
            sidebar.classList.remove('show');
            document.body.classList.remove('no-scroll');
        });

        document.addEventListener('click', function(event) {
            if (!sidebar.contains(event.target) && sidebar.classList.contains('show') && !toggleButton.contains(event.target)) {
                sidebar.classList.remove('show');
                document.body.classList.remove('no-scroll');
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
                document.body.classList.remove('no-scroll');
            }
        });
    });
</script>
@endsection
