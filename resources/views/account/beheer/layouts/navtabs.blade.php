<ul class="nav nav-tabs" id="beheerTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link {{ Route::currentRouteName() == 'beheer.statistieken' ? 'active' : '' }}" href="{{ route('beheer.statistieken') }}">Statistieken</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link {{ Route::currentRouteName() == 'beheer.formulieren' ? 'active' : '' }}" href="{{ route('beheer.formulieren') }}">Formulieren</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link {{ Route::currentRouteName() == 'beheer.gebruikers' ? 'active' : '' }}" href="{{ route('beheer.gebruikers') }}">Gebruikers</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link {{ Route::currentRouteName() == 'beheer.instellingen' ? 'active' : '' }}" href="{{ route('beheer.instellingen') }}">Instellingen</a>
    </li>
</ul>
