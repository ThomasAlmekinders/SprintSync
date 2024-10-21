@extends('dashboard.view-scrumboard.index')

@section('dashboard-content')
<div class="container">
    <h1>Instellingen voor Scrumboard: {{ $scrumboard->title }}</h1>

    <form action="{{ route('scrumboard.instellingen.update', ['slug' => Str::slug($scrumboard->title), 'id' => $scrumboard->id]) }}" method="POST">
        @csrf

        <!-- Scrumboard titel aanpassen -->
        <div class="mb-3">
            <label for="titel" class="form-label">Titel</label>
            <input type="text" class="form-control" id="titel" name="titel" value="{{ old('title', $scrumboard->title) }}" required>
        </div>

        <!-- Scrumboard beschrijving aanpassen -->
        <div class="mb-3">
            <label for="beschrijving" class="form-label">Beschrijving</label>
            <textarea class="form-control" id="beschrijving" name="beschrijving" rows="3" required>{{ old('description', $scrumboard->description) }}</textarea>
        </div>

        <!-- Zoekfunctie voor het koppelen van personen -->
        <div class="card mt-4">
            <div class="card-header">
                <h5>Zoek en selecteer personen</h5>
                <small class="form-text text-muted">Gebruik de zoekbalk om personen uit je connecties sneller te vinden en vink de personen aan die aan dit Scrumboard gekoppeld moeten worden!</small>
            </div>
            <div class="card-body">
                <!-- Zoekbalk -->
                <div class="mb-3">
                    <label for="search" class="form-label">Zoek op voornaam of achternaam</label>
                    <input type="text" class="form-control" id="search" placeholder="Zoeken..." autocomplete="off">
                </div>

                <!-- Lijst van personen -->
                <div class="mb-3">
                    <label for="personen" class="form-label">Personenlijst</label>
                    <div class="list-group" id="personen">
                        @foreach($connections as $connection)
                            <a class="list-group-item list-group-item-action d-flex align-items-center connection-item {{ in_array($connection->id, $scrumboard->users->pluck('id')->toArray()) ? 'list-item-muted' : '' }}"
                               title="Bekijk het profiel van {{ $connection->first_name }} {{ $connection->last_name }}">
                                <span class="px-3">
                                    <input type="checkbox" name="personen[]" value="{{ $connection->id }}" {{ in_array($connection->id, $scrumboard->users->pluck('id')->toArray()) ? 'checked' : '' }}>
                                </span>
                                <img src="/images/profile_pictures/{{ $connection->profile_picture }}" alt="Profielfoto" class="img-fluid rounded-circle me-2" style="width: 50px; height: 50px;">
                                <div>
                                    <h6 class="mb-1">{{ $connection->first_name }} {{ $connection->last_name }}</h6>
                                    <p class="mb-0 text-muted"><span>@</span>{{ $connection->username }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Opslaan knop of foutmelding -->
            <div class="px-4">
                @if(auth()->user()->id === $scrumboard->creator_id)
                    <button type="submit" class="btn btn-primary mb-3">Opslaan</button>
                @else
                    <p class="text-danger mb-0">Je hebt geen rechten om de gebruikers aan te passen.</p>
                @endif
            </div>
        </div>
    </form>
</div>

<script>
    document.getElementById('search').addEventListener('keyup', function() {
        var searchTerm = this.value.toLowerCase();

        var list = document.getElementById('personen');
        var connectionItems = Array.from(list.getElementsByClassName('connection-item'));

        connectionItems.sort(function(a, b) {
            var aText = a.querySelector('h6').textContent.toLowerCase();
            var bText = b.querySelector('h6').textContent.toLowerCase();

            var aMatches = aText.includes(searchTerm);
            var bMatches = bText.includes(searchTerm);

            if (aMatches && !bMatches) {
                return -1;
            } else if (!aMatches && bMatches) {
                return 1;
            } else {
                return 0;
            }
        });

        connectionItems.forEach(function(item) {
            list.appendChild(item);
        });
    });
</script>

<style>
    .connection-item.list-item-muted {
        background: #d7d7d7;
        opacity: .5;
    }
</style>
@endsection
