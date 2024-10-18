@extends('account.mijn-account.index')

@section('account-content')
<div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
    <div class="px-3 py-4">
        <h3>Persoonlijke Gegevens</h3>

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

        <form method="POST" action="{{ route('mijn-account.update-personal-data') }}">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="first_name" class="form-label">{{ __('Voornaam') }}</label>
                    <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name', Auth::user()->first_name) }}" required>
                </div>
                <div class="col-md-6">
                    <label for="last_name" class="form-label">{{ __('Achternaam') }}</label>
                    <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name', Auth::user()->last_name) }}">
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">{{ __('E-mailadres') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', Auth::user()->email) }}" required>
            </div>

            <div class="mb-3">
                <label for="phone_number" class="form-label">{{ __('Telefoonnummer') }}</label>
                <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number', Auth::user()->phone_number) }}">
            </div>

            <div class="row mb-3">
                <div class="col-md-8">
                    <label for="street" class="form-label">{{ __('Straat') }}</label>
                    <input id="street" type="text" class="form-control @error('street') is-invalid @enderror" name="street" value="{{ old('street', Auth::user()->address->street ?? '') }}">
                </div>
                <div class="col-md-4">
                    <label for="house_number" class="form-label">{{ __('Huisnummer') }}</label>
                    <input id="house_number" type="text" class="form-control @error('house_number') is-invalid @enderror" name="house_number" value="{{ old('house_number', Auth::user()->address->house_number ?? '') }}">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-8">
                    <label for="city" class="form-label">{{ __('Stad') }}</label>
                    <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city', Auth::user()->address->city ?? '') }}">
                </div>
                <div class="col-md-4">
                    <label for="postcode" class="form-label">{{ __('Postcode') }}</label>
                    <input id="postcode" type="text" class="form-control @error('postcode') is-invalid @enderror" name="postcode" value="{{ old('postcode', Auth::user()->address->postcode ?? '') }}">
                </div>
            </div>

            <div class="mb-3 mb-md-5">
                <label for="country" class="form-label">{{ __('Land') }}</label>
                <input id="country" type="text" class="form-control @error('country') is-invalid @enderror" name="country" value="{{ old('country', Auth::user()->address->country ?? '') }}">
            </div>

            <button type="submit" class="btn btn-primary">
                {{ __('Gegevens Bijwerken') }}
            </button>
        </form>
    </div>
</div>
@endsection
