@extends('layouts.app')

@section('content')

<main class="container py-4 mt-6">
    <div class="row g-4">
        <div class="col-lg-6">
            <a
                href="/over-ons"
                class="docs-card text-decoration-none d-flex flex-column justify-between rounded shadow bg-white p-4 transition duration-300 hover:text-black focus:outline-none border border-0 border-transparent hover:border-primary hover:shadow-lg"
                style="color: #000;"
            >
                <div>
                    <div class="position-relative w-100 flex-1">
                        <img
                            src="{{ asset('images/document_light.svg') }}"
                            alt="Laravel documentation screenshot"
                            class="w-100 rounded-3 img-doc"
                        />
                        <div class="position-absolute bottom-0 start-0 w-100 h-100 bg-gradient" style="background: linear-gradient(to bottom, transparent, white);"></div>
                    </div>

                    <div class="d-flex align-items-start gap-4 mt-3">
                        <div class="rounded-circle bg-dashboard-circles p-2">
                            <img src="{{ asset('images/book.svg') }}" alt="Book icon" style="height=: 1.5rem; width: 1.5rem;">
                        </div>
                        <div>
                            <h2 class="h5 fw-bold">Over SprintNest</h2>
                            <p class="mt-2 small">
                            SprintNest biedt uitgebreide ondersteuning voor scrum- en projectmanagement. Ons platform is ontworpen voor zowel beginners als ervaren teams en helpt je om je werkprocessen te optimaliseren. We adviseren je om ons aanbod te verkennen en de voordelen van efficiënter scrummen te ontdekken.                            </p>
                        </div>
                    </div>
                </div>
                <img src="{{ asset('images/arrow_right.svg') }}" alt="Arrow icon" class="mt-3" style="width: 2rem; height: 2rem;">
            </a>
        </div>

        <div class="col-lg-6 d-flex flex-column">
            <div class="d-flex flex-column h-100">
                <a
                    href="/mijn-account"
                    class="docs-card text-decoration-none d-flex align-items-start gap-4 rounded shadow bg-white p-4 transition duration-300 hover:text-black focus:outline-none flex-grow-1 mb-3 border border-0 border-transparent hover:border-primary border-hover hover:shadow-lg"
                    style="color: #000;"
                >
                    <div class="rounded-circle bg-dashboard-circles p-2">
                        <img src="{{ asset('images/play_video.svg') }}" alt="Play video icon" style="height=: 1.5rem; width: 1.5rem;">
                    </div>
                    <div>
                        <h2 class="h5 fw-bold">Mijn SprintNest</h2>
                        <p class="mt-2 small">
                        Je account biedt een persoonlijke ervaring voor projectbeheer. Pas je dashboard aan, volg je taken en krijg inzicht in de voortgang van je team. Ervaar overzicht en samenwerking met onze gebruiksvriendelijke interface!                    </div>
                    <img src="{{ asset('images/arrow_right.svg') }}" alt="Arrow icon" class="my-auto" style="width: 2rem; height: 2rem;">
                </a>

                <a
                    href="/dashboard"
                    class="docs-card text-decoration-none d-flex align-items-start gap-4 rounded shadow bg-white p-4 transition duration-300 hover:text-black focus:outline-none flex-grow-1 mb-3 border border-0 border-transparent hover:border-primary border-hover hover:shadow-lg"
                    style="color: #000;"
                >
                    <div class="rounded-circle bg-dashboard-circles p-2">
                        <img src="{{ asset('images/newspaper.svg') }}" alt="Newspaper icon" style="height=: 1.5rem; width: 1.5rem;">
                    </div>
                    <div>
                        <h2 class="h5 fw-bold">Nu beginnen</h2>
                        <p class="mt-2 small">
                        SprintNest biedt een intuïtieve oplossing voor scrum- en projectmanagement. Beheer je taken, plan sprints en volg de voortgang eenvoudig. Probeer het uit en verbeter de samenwerking en efficiëntie van je team!                        </p>
                    </div>
                    <img src="{{ asset('images/arrow_right.svg') }}" alt="Arrow icon" class="my-auto" style="width: 2rem; height: 2rem;">
                </a>

                <div class="docs-card d-flex align-items-start gap-4 rounded shadow bg-white p-4 transition duration-300 hover:text-black focus:outline-none flex-grow-1 border border-0 border-transparent hover:border-primary border-hover hover:shadow-lg">
                    <div class="rounded-circle bg-dashboard-circles p-2">
                        <img src="{{ asset('images/netball.svg') }}" alt="Network icon" style="height=: 1.5rem; width: 1.5rem;">
                    </div>
                    <div>
                        <h2 class="h5 fw-bold">Eenvoudig online scrummen</h2>
                        <p class="mt-2 small">
                        Eenvoudig online scrummen is nu binnen handbereik met SprintNest. Plan sprints, wijs taken toe en volg de voortgang van je team in real-time. Verbeter communicatie en samenwerking met gebruiksvriendelijke tools die je helpen gefocust te blijven.                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
