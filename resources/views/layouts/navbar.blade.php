<nav class="navbar navbar-expand-md navbar-light shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/logos/Logo_SprintNest.svg') }}" alt="{{ config('app.name', 'Laravel') }}" style="width: 200px; height: auto;" height="67px" width="200px">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav ms-auto text-center" style="margin-right: calc(5vw + 2rem);">
                @auth
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'dashboard.index' ? 'active' : '' }}" href="{{ route('dashboard.index') }}">Dashboard</a>
                </li>
                @endauth
                <li class="nav-item dropdown">
                    <span class="nav-link dropdown-toggle" id="informatieDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;">
                        Informatie
                    </span>
                    <div class="dropdown-menu is-right dropdown-menu-end" aria-labelledby="informatieDropdown">
                        <a class="dropdown-item nav-link {{ Route::currentRouteName() == 'functioneel-ontwerp.index' ? 'active' : '' }}" href="{{ route('functioneel-ontwerp.index') }}">Functioneel ontwerp</a>
                        <a class="dropdown-item nav-link mb-3 {{ Route::currentRouteName() == 'technisch-ontwerp.index' ? 'active' : '' }}" href="{{ route('technisch-ontwerp.index') }}">Technisch ontwerp</a>

                        <a class="dropdown-item nav-link {{ Route::currentRouteName() == 'over-ons.index' ? 'active' : '' }}" href="{{ route('over-ons.index') }}">Over Ons</a>
                        <a class="dropdown-item nav-link mb-3 {{ Route::currentRouteName() == 'contact.index' ? 'active' : '' }}" href="{{ route('contact.index') }}">Contact</a>

                        <a class="dropdown-item nav-link {{ Route::currentRouteName() == 'algemene-voorwaarden.index' ? 'active' : '' }}" href="{{ route('algemene-voorwaarden.index') }}">Algemene voorwaarden</a>
                        <a class="dropdown-item nav-link {{ Route::currentRouteName() == 'privacystatement.index' ? 'active' : '' }}" href="{{ route('privacystatement.index') }}">Privacy statement</a>
                        <a class="dropdown-item nav-link {{ Route::currentRouteName() == 'cookiestatement.index' ? 'active' : '' }}" href="{{ route('cookiestatement.index') }}">Cookie statement</a>
                        <a class="dropdown-item nav-link {{ Route::currentRouteName() == 'sitemap.index' ? 'active' : '' }}" href="{{ route('sitemap.index') }}">Sitemap</a>
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
                        <img src="{{ asset('images/profile_pictures/' . (Auth::user()->profile_picture ?? 'images/profile_pictures/default_profile.svg')) }}" alt="Profielfoto" class="profile-img d-inline-block" height="75px" width="75px">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle d-inline-block" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                        </a>

                        <div class="dropdown-menu is-right dropdown-menu-end" aria-labelledby="navbarDropdown">
                            @if(auth()->check() && auth()->user()->is_administrator)
                                <a class="dropdown-item nav-link {{ Route::currentRouteName() == 'beheer.statistieken' ? 'active' : '' }}" href="{{ route('beheer.statistieken') }}">
                                    Beheer
                                </a> 
                            @endif
                            <a class="dropdown-item nav-link {{ Route::currentRouteName() == 'mijn-account.profiel' ? 'active' : '' }}" href="{{ route('mijn-account.profiel') }}">
                                Mijn Account
                            </a>
                            <a class="dropdown-item nav-link {{ Route::currentRouteName() == 'connecties.index' ? 'active' : '' }}" href="{{ route('connecties.index') }}">
                                Connecties
                            </a>
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
