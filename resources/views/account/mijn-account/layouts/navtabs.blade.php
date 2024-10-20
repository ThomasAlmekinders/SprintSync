<ul class="nav nav-tabs" id="accountTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link {{ Route::currentRouteName() == 'mijn-account.profiel' ? 'active' : '' }}" href="{{ route('mijn-account.profiel') }}">Profiel</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link {{ Route::currentRouteName() == 'mijn-account.persoonlijke-gegevens' ? 'active' : '' }}" href="{{ route('mijn-account.persoonlijke-gegevens') }}">Persoonlijke Gegevens</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link {{ Route::currentRouteName() == 'mijn-account.wachtwoord' ? 'active' : '' }}" href="{{ route('mijn-account.wachtwoord') }}">Wachtwoord wijzigen</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link {{ Route::currentRouteName() == 'mijn-account.voorkeuren' ? 'active' : '' }}" href="{{ route('mijn-account.voorkeuren') }}">Voorkeuren & Meldingen</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link {{ Route::currentRouteName() == 'mijn-account.activiteitslog' ? 'active' : '' }}" href="{{ route('mijn-account.activiteitslog') }}">Activiteitslog</a>
    </li>
</ul>
