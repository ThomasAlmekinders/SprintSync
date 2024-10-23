@extends('account.beheer.index')

@section('beheer-content')
<div class="container-xxl py-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <form method="GET" action="{{ route('beheer.gebruikers') }}" class="mb-4">
                <div class="input-group mb-3">
                    <input type="text" name="search" class="form-control" placeholder="Zoeken op id, voornaam, achternaam of email" value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">Zoeken</button>
                    <a class="btn btn-secondary" href="{{ route('beheer.gebruikers') }}">Reset</a>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <label>Per pagina:</label>
                        <select name="per_page" onchange="this.form.submit()">
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>
                    <div>
                        <label>Sorteren op:</label>
                        <select name="sort_by" onchange="this.form.submit()">
                            <option value="first_name" {{ request('sort_by') == 'first_name' ? 'selected' : '' }}>Voornaam</option>
                            <option value="last_name" {{ request('sort_by') == 'last_name' ? 'selected' : '' }}>Achternaam</option>
                            <option value="email" {{ request('sort_by') == 'email' ? 'selected' : '' }}>Email</option>
                            <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Aangemaakt op</option>
                            <option value="country" {{ request('sort_by') == 'country' ? 'selected' : '' }}>Land</option>
                        </select>
                        <select name="sort_order" onchange="this.form.submit()">
                            <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Oplopend</option>
                            <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Aflopend</option>
                        </select>
                    </div>
                </div>
            </form>
            @if($users->isEmpty())
                <p>Geen gebruikers gevonden.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Naam</th>
                                <th>Email</th>
                                <th>Land</th>
                                <th>Aangemaakt op</th>
                                <th>Destroy</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td data-label="ID">{{ $user->id }}</td>
                                    <td data-label="Naam">{{ $user->first_name }} {{ $user->last_name }}</td>
                                    <td data-label="Email">{{ $user->email }}</td>
                                    <td data-label="Land">{{ $user->address->country }}</td>
                                    <td data-label="Aangemaakt op">{{ $user->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        @if(auth()->user()->is_administrator && !$user->is_administrator)
                                        <form method="POST" action="{{ route('beheer.gebruikers.destroy', $user->id) }}" onsubmit="return confirm('Weet je zeker dat je deze gebruiker wilt verwijderen?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Verwijderen</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $users->appends(request()->except('page'))->links() }}
            @endif
        </div>
    </div>
</div>

<script>
    function resetForm() {
        document.querySelector('input[name="search"]').value = '';

        document.querySelector('select[name="per_page"]').value = 25; // Zet het aantal per pagina terug naar standaard
        document.querySelector('select[name="sort_by"]').value = 'first_name'; // Zet sorteren op standaardwaarde
        document.querySelector('select[name="sort_order"]').value = 'asc'; // Zet sorteerorde terug naar oplopend

        document.querySelector('form').submit();
    }
</script>


<style>
    label {
        margin-right: 10px;
        font-weight: bold;
    }

    select {
        padding: 10px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        background-color: #fff;
        color: #495057;
        margin-right: 15px;
        transition: border-color 0.3s ease;
    }

    select:focus {
        border-color: #ed6809;
        outline: none;
    }

    select:hover {
        border-color: #adb5bd;
    }

    .table {
        width: 100%;
        margin-bottom: 1rem;
        color: #212529;
        border-collapse: collapse;
    }

    .table thead th {
        background-color: #0d6efd;
        color: #ffffff;
        font-weight: 600;
        text-align: left;
        padding: 12px;
        border-bottom: 2px solid #dee2e6;
    }

    .table tbody tr td {
        transition: background-color 0.15s ease-in-out;
    }

    .table tbody tr:hover td {
        background-color: #f1f1f1;
        cursor: pointer;
    }

    .table tbody td {
        padding: 12px;
        border-bottom: 1px solid #dee2e6;
    }

    .table tbody tr:last-child td {
        border-bottom: 0;
    }

    .pagination {
        justify-content: center;
        margin-top: 20px;
    }

    @media (max-width: 768px) {
        .table thead {
            display: none;
        }

        .table tbody tr {
            display: block;
            margin-bottom: 1rem;
        }

        .table tbody td {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem;
            border: none;
        }

        .table tbody td:before {
            content: attr(data-label);
            font-weight: bold;
            flex: 1;
        }
    }
</style>
@endsection
