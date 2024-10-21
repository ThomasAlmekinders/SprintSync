<nav class="col-md-3 col-lg-2 bg-light sidebar" id="sidebar">
    <div class="d-flex flex-column h-100">
        <h5 class="mt-3">{{ $scrumboard->title }}</h5>

        <ul class="nav flex-column flex-grow-1" id="accountTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'scrumboard.index' ? 'active' : '' }}" 
                   href="{{ route('scrumboard.index', ['slug' => Str::slug($scrumboard->title), 'id' => $scrumboard->id]) }}">
                    Scrumboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'scrumboard.takenlijst' ? 'active' : '' }}" 
                   href="{{ route('scrumboard.takenlijst', ['slug' => Str::slug($scrumboard->title), 'id' => $scrumboard->id]) }}">
                    Takenlijst
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'scrumboard.tijdlijn' ? 'active' : '' }}" 
                   href="{{ route('scrumboard.tijdlijn', ['slug' => Str::slug($scrumboard->title), 'id' => $scrumboard->id]) }}">
                    Tijdlijn
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'scrumboard.instellingen' ? 'active' : '' }}" 
                   href="{{ route('scrumboard.instellingen', ['slug' => Str::slug($scrumboard->title), 'id' => $scrumboard->id]) }}">
                    Instellingen
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'scrumboard.beschrijving' ? 'active' : '' }}" 
                   href="{{ route('scrumboard.beschrijving', ['slug' => Str::slug($scrumboard->title), 'id' => $scrumboard->id]) }}">
                    Beschrijving
                </a>
            </li>
        </ul>

        <button class="btn btn-secondary mt-3 d-md-none" id="sidebarClose" style="width: 100%;">
            <i class="bi bi-x"></i> Sluiten
        </button>
    </div>
</nav>
