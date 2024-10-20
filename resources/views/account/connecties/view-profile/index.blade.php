@extends('layouts.app')

@section('content')
<div class="container-xxl py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <h1 class="mb-4">Profiel van {{ $user->first_name }} {{ $user->last_name }}</h1>

            <div class="card mb-4 shadow-sm">
                <div class="card-body text-center">
                    @if($user->profile_picture)
                        <img src="{{ asset('images/profile_pictures/' . $user->profile_picture) }}" alt="Profiel Foto" class="rounded-circle mb-3" style="width: 150px; height: 150px;">
                    @else
                        <img src="{{ asset('images/default-profile.png') }}" alt="Standaard Profiel Foto" class="rounded-circle mb-3" style="width: 150px; height: 150px;">
                    @endif
                    <h3 class="h4">{{ $user->first_name }} {{ $user->last_name }}</h3>
                    <p class="text-muted">{{ $user->email }}</p>
                </div>
            </div>

            <h5 class="mt-4">Over mij</h5>
            <p class="border p-3 rounded bg-light">{{ $user->profile_bio ?? 'Geen bio beschikbaar' }}</p>

            <h5 class="mt-4">Contactinformatie</h5>
            <ul class="list-unstyled">
                @if($user->visibilitySettings->show_email)
                    <li class="border-bottom pb-2"><strong>Email:</strong> {{ $user->email }}</li>
                @else
                    <li class="border-bottom pb-2"><strong>Email:</strong> Deze informatie is privé.</li>
                @endif

                @if($user->visibilitySettings->show_phone)
                    <li class="border-bottom pb-2"><strong>Telefoon:</strong> {{ $user->phone_number ?? 'Geen telefoonnummer beschikbaar' }}</li>
                @else
                    <li class="border-bottom pb-2"><strong>Telefoon:</strong> Deze informatie is privé.</li>
                @endif
            </ul>

            <h5 class="mt-4">Locatie</h5>
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <td><strong>Land:</strong></td>
                        <td>{{ $user->address->country ?? 'Locatie niet beschikbaar' }}</td>
                    </tr>
                    @if($user->visibilitySettings->show_address)
                        <tr>
                            <td><strong>Adres:</strong></td>
                            <td>
                                {{ $user->address->city ?? 'Geen stad beschikbaar' }} {{ $user->address->postcode ?? 'Geen postcode beschikbaar' }},<br />
                                {{ $user->address->street ?? 'Geen straat beschikbaar' }}, {{ $user->address->house_number ?? 'Geen huisnummer beschikbaar' }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td><strong>Adres:</strong></td>
                            <td>Deze informatie is privé.</td>
                        </tr>
                    @endif
                </tbody>
            </table>

        </div>
    </div>
</div>

<!-- Google Maps -->
@if($user->visibilitySettings->show_address)
    @php
        // Combineer het adres in één variabele
        $full_address = urlencode($user->address->street . ' ' . $user->address->house_number . ', ' . $user->address->city . ', ' . $user->address->postcode . ', ' . $user->address->country);
    @endphp
    <div class="d-flex mt-5">
        <iframe 
            src="https://www.google.com/maps/embed/v1/place?key={{ config('app.google_maps.api_key') }}&q={{ $full_address }}" 
            width="100%" 
            height="450px" 
            loading="lazy" 
            style="border: 0; height: 500px;" 
            title="{{ $user->first_name }}'s locatie op Google Maps"
            allowfullscreen>
        </iframe>
        <noscript>
            <img src="{{ asset('images/Locatie_comp.webp') }}" alt="Google Maps locatie"
                height="500px" width="100%"
                loading="lazy"
                style="height: 500px; width: 100%;">
        </noscript>
    </div>
@endif



<style>
    .card {
        border: none;
        border-radius: 0.5rem;
    }

    .card-body {
        padding: 2rem;
    }

    .rounded-circle {
        border-radius: 50%;
        border: 2px solid #ed6809; /* Hoofdkleur van de website */
    }

    h5 {
        border-bottom: 2px solid #ed6809; /* Accent kleur onder de kopjes */
        padding-bottom: 0.5rem;
    }

    .border-bottom {
        border-bottom: 1px solid #dee2e6;
    }

    .bg-light {
        background-color: #f8f9fa;
    }

    .pb-2 {
        padding-bottom: 0.5rem;
    }
</style>
@endsection
