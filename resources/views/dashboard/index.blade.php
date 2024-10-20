@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>{{ __('Mijn Scrumboards') }}</h2>
            </div>

        </div>
        <div class="col-12 col-md-4" style="height: 100px; position: relative;">
            <div>
                <button class="btn btn-primary text-nowrap" data-bs-toggle="modal" data-bs-target="#createScrumboardModal">
                    {{ __('Nieuw Scrumboard') }}
                </button>
            </div>
        </div>
        <div class="col-12">
            <!-- Scrumboard Overzicht -->
            <div class="row">

                @forelse($scrumboards as $scrumboard)
                <div class="col-12 col-md-6 col-xl-4 mb-4 scrumboard-item-wrap d-flex align-items-stretch"
                    data-isEnabled="{{ $scrumboard->active == 1 ? 'enabled' : 'disabled' }}">
                    <div class="scrumboard-card h-100 d-flex flex-column">
                        <div class="scrumboard-card-body d-flex flex-column flex-grow-1">
                            <div class="scrumboard-card-text flex-grow-1">
                                <a href="/dashboard/{{ $scrumboard->id }}" class="scrumboard-title-link text-decoration-none">
                                    <div class="scrumboard-item-title">
                                        <h3 class="scrumboard-title">{{ $scrumboard->title }}</h3>
                                    </div>
                                </a>
                                <p class="scrumboard-description">
                                    {{ $scrumboard->description }}
                                </p>
                            </div>
                            <div class="scrumboard-btns row">
                                <div class="col-12">
                                    <div class="scrumboard-creator d-inline-flex flex-column justify-content-center align-middle mb-3">
                                        <span class="small d-none d-lg-block">Aangemaakt door:</span>
                                        <div>
                                            <a href="/profile/{{ $scrumboard->creator->id }}" class="scrumboard-writer d-inline-flex text-decoration-none">
                                                <img src="{{ asset('images/profile_pictures/' . $scrumboard->creator->profile_picture) }}" class="mr-3 rounded-circle" width="56" height="56" alt="{{ $scrumboard->creator->first_name }} {{ $scrumboard->creator->last_name }}">
                                                    <span class="font-weight-bold">{{ $scrumboard->creator->first_name }} {{ $scrumboard->creator->last_name }}
                                                        <br />
                                                    <small class="text-muted">Aangemaakt op: {{ \Carbon\Carbon::parse($scrumboard->created_at)->format('d M Y') }}</small>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-7 mb-2 mb-sm-0">
                                    <a href="/dashboard/{{ $scrumboard->id }}" class="btn btn-info w-100 text-white">Bekijk Scrumboard</a>
                                </div>
                                <div class="col-12 col-sm-5">
                                    <button type="button" class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#editScrumboardModal" data-scrumboard-id="{{ $scrumboard->id }}" data-scrumboard-title="{{ $scrumboard->titel }}" data-scrumboard-description="{{ $scrumboard->beschrijving }}" data-scrumboard-actief="{{ $scrumboard->actief }}">
                                        Instellingen
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <p>Er zijn geen scrumborden beschikbaar.</p>
                @endforelse

            </div>
        </div>
    </div>
</div>

<style>
    .scrumboard-item-title h3 {
        max-height: 3em;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: normal;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .scrumboard-description {
        max-height: 9em;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: normal;
        display: -webkit-box;
        -webkit-line-clamp: 6;
        -webkit-box-orient: vertical;
    }

    .scrumboard-card-body {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-grow: 1;
    }

    .scrumboard-card-text {
        flex-grow: 1;
    }

    .scrumboard-btns .btn {
        white-space: nowrap;
    }

    .scrumboard-card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }


    .scrumboard-btns .btn {
        white-space: nowrap;
    }

    .scrumboard-card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .scrumboard-item-wrap {
        transition: transform 0.3s ease;
    }

    .scrumboard-item-wrap:hover {
        transform: translateY(-10px);
    }

    .scrumboard-card {
        background-color: #ffffff;
        border: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
    }

    .scrumboard-card-body {
        padding: 20px;
    }

    .scrumboard-item-title h3 {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 15px;
        color: #333;
    }

    .scrumboard-description {
        font-size: 1rem;
        color: #6c757d;
        margin-bottom: 20px;
    }

    .scrumboard-creator {
        display: flex;
        align-items: center;
    }

    .scrumboard-creator img {
        border-radius: 50%;
        margin-right: 10px;
    }

    .scrumboard-writer {
        font-size: 1rem;
        color: #007bff;
        font-weight: bold;
        text-decoration: none;
    }

    .scrumboard-writer:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .scrumboard-item-wrap {
            margin-bottom: 20px;
        }
    }

    .card:hover {
        transform: scale(1.05);
        transition: transform 0.2s;
    }

    #app {
        position: relative;
    }
    .fab {
        position: absolute;
        bottom: 2rem;
        right: 4rem;
        background-color: #007bff;
        color: white;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
    }

    .fab:hover {
        background-color: #0056b3;
    }

    .scrumboard-item-wrap .scrumboard-card {
        position: relative;
    }

    /* Ribbon rechtsboven */
    .scrumboard-item-wrap[data-isenabled="disabled"] .scrumboard-card::after {
        content: 'Disabled';
        position: absolute;
        top: 30px;
        right: -50px;
        width: 200px;
        height: 35px;
        background-color: rgba(0, 0, 0, 0.6);
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        transform: rotate(45deg);
        z-index: 2;
        border-radius: 3px;
        pointer-events: none;
    }

    .scrumboard-item-wrap[data-isenabled="disabled"] .scrumboard-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4);
        z-index: 1;
        border-radius: 5px;
        pointer-events: none;
    }

    #editScrumboardModal .form-check {
        margin-top: 15px;
    }

    #editScrumboardModal .form-check-label {
        vertical-align: middle;
        margin-left: 10px;
    }
</style>
@endsection
