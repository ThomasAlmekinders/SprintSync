<nav class="col-md-3 col-lg-2 bg-light sidebar" id="sidebar">
    <div class="d-flex flex-column h-100">
        <!-- Scrumboard Titel -->
        <div class="p-3 bg-primary text-white text-center">
            <h5 class="mb-0">{{ $scrumboard->title }}</h5>
        </div>

        <!-- Navigatie Items -->
        <ul class="nav flex-column flex-grow-1 mt-3" id="accountTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'scrumboard.index' ? 'active' : '' }}" 
                   href="{{ route('scrumboard.index', ['slug' => Str::slug($scrumboard->title), 'id' => $scrumboard->id]) }}">
                   <i class="bi bi-kanban"></i> Scrumboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'scrumboard.takenlijst' ? 'active' : '' }}" 
                   href="{{ route('scrumboard.takenlijst', ['slug' => Str::slug($scrumboard->title), 'id' => $scrumboard->id]) }}">
                   <i class="bi bi-card-checklist"></i> Takenlijst
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'scrumboard.tijdlijn' ? 'active' : '' }}" 
                   href="{{ route('scrumboard.tijdlijn', ['slug' => Str::slug($scrumboard->title), 'id' => $scrumboard->id]) }}">
                   <i class="bi bi-clock-history"></i> Tijdlijn
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'scrumboard.instellingen' ? 'active' : '' }}" 
                   href="{{ route('scrumboard.instellingen', ['slug' => Str::slug($scrumboard->title), 'id' => $scrumboard->id]) }}">
                   <i class="bi bi-gear"></i> Instellingen
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'scrumboard.beschrijving' ? 'active' : '' }}" 
                   href="{{ route('scrumboard.beschrijving', ['slug' => Str::slug($scrumboard->title), 'id' => $scrumboard->id]) }}">
                   <i class="bi bi-info-circle"></i> Beschrijving
                </a>
            </li>
        </ul>

        <!-- Sluiten Knop -->
        <button class="btn btn-secondary mt-3 d-md-none" id="sidebarClose" style="width: 100%;">
            <i class="bi bi-x"></i> Sluiten
        </button>
    </div>
</nav>
