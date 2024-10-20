@extends('account.mijn-account.index')

@section('account-content')
<div id="preferences" class="tab-pane fade show active" role="tabpanel" aria-labelledby="preferences-tab">
    <div class="container px-4 py-4">
        <h3 class="mb-4">Voorkeuren & Meldingen</h3>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('mijn-account.update-visibility') }}" method="POST">
            @csrf

            <div class="form-group mb-4">
                <label for="show_email">Toon mijn e-mail:</label>
                <div class="form-check">
                    <input type="hidden" name="show_email" value="0" />
                    <input type="checkbox" class="form-check-input" name="show_email" id="show_email" value="1" {{ $user->visibilitySettings->show_email ? 'checked' : '' }}>
                    <label class="form-check-label" for="show_email">Ja, toon mijn e-mail aan andere gebruikers</label>
                </div>
            </div>

            <div class="form-group mb-4">
                <label for="show_phone">Toon mijn telefoonnummer:</label>
                <div class="form-check">
                    <input type="hidden" name="show_phone" value="0" />
                    <input type="checkbox" class="form-check-input" name="show_phone" id="show_phone" value="1" {{ $user->visibilitySettings->show_phone ? 'checked' : '' }}>
                    <label class="form-check-label" for="show_phone">Ja, toon mijn telefoonnummer aan andere gebruikers</label>
                </div>
            </div>

            <div class="form-group mb-4">
                <label for="show_address">Toon mijn adres:</label>
                <div class="form-check">
                    <input type="hidden" name="show_address" value="0" />
                    <input type="checkbox" class="form-check-input" name="show_address" id="show_address" value="1" {{ $user->visibilitySettings->show_address ? 'checked' : '' }}>
                    <label class="form-check-label" for="show_address">Ja, toon mijn adres aan andere gebruikers</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Opslaan</button>
        </form>


    </div>
</div>
<style>
    .form-check-input {
        width: 1.125em;
        height: 1.125em;
    }
</style>
@endsection
