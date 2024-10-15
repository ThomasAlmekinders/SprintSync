<nav class="navbar navbar-expand-md navbar-light shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/logos/Logo_Tekst.svg') }}" alt="{{ config('app.name', 'Laravel') }}" style="width: 200px; height: auto;" height="67px" width="200px">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav ms-auto text-center" style="margin-right: calc(5vw + 2rem);">
                <li class="nav-item dropdown">
                    <span class="nav-link dropdown-toggle" id="informatieDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;">
                        Informatie
                    </span>
                    <div class="dropdown-menu is-right dropdown-menu-end" aria-labelledby="informatieDropdown">
                        <a class="dropdown-item nav-link {{ Request::is('functioneel-ontwerp') ? 'active' : '' }}" href="/functioneel-ontwerp">Functioneel ontwerp</a>
                        <a class="dropdown-item nav-link mb-3 {{ Request::is('technisch-ontwerp') ? 'active' : '' }}" href="/technisch-ontwerp">Technisch ontwerp</a>

                        <a class="dropdown-item nav-link {{ Request::is('over-ons') ? 'active' : '' }}" href="/over-ons">Over Ons</a>
                        <a class="dropdown-item nav-link mb-3 {{ Request::is('contact') ? 'active' : '' }}" href="/contact">Contact</a>
                    </div>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav">
                @guest
                    <li class="nav-item">
                        <a class="nav-link d-inline-flex" href="{{ route('login') }}">{{ __('Inloggen') }}</a>
                        <span class="nav-link d-inline-flex  px-3 px-md-0"> / </span>
                        <a class="nav-link d-inline-flex" href="{{ route('register') }}">{{ __('Registreren') }}</a>
                    </li>
                @else
                    <li class="nav-item dropdown text-center">
                        <img src="{{ asset('images/profile_pictures/' . Auth::user()->profile_picture ?? 'images/profile_pictures/default_profile.svg') }}" alt="Profielfoto" class="profile-img d-inline-block" height="75px" width="75px">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle d-inline-block" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->first_name }}
                            {{ Auth::user()->last_name }}
                        </a>

                        <div class="dropdown-menu is-right dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item nav-link" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>