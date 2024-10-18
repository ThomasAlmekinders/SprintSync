@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <h1 class="mb-4 text-center">Sitemap</h1>
            <p>Welkom bij SprintNest! Deze sitemap biedt een overzicht van alle belangrijke pagina's op onze website. Door gebruik te maken van deze site, krijgt u een beter inzicht in de beschikbare inhoud en functionaliteiten. U kunt eenvoudig navigeren naar de verschillende secties door op de links hieronder te klikken.</p>
            
            <div class="mt-5">
                <h2 class="h4">Hoofdpagina</h2>
                <ul>
                    <li><a href="{{ route('home.index') }}">Home</a></li>
                </ul>
            </div>

            <div class="mt-5">
                <h2 class="h4">Accountbeheer</h2>
                <ul>
                    <li><a href="{{ route('mijn-account.index') }}">Mijn account</a></li>
                    <li class="mb-3"><a href="{{ route('connecties.index') }}">Connecties</a></li>
                    <li><a href="{{ route('register') }}">Registratie</a></li>
                    <li><a href="{{ route('login') }}">Inloggen</a></li>
                    <li><a href="{{ route('password.request') }}">Wachtwoord Vergeten</a></li>
                </ul>
            </div>

            <div class="mt-5">
                <h2 class="h4">Functies</h2>
                <ul>
                    <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                </ul>
            </div>

            <div class="mt-5">
                <h2 class="h4">Informatie</h2>
                <ul>
                    <li><a href="{{ route('functioneel-ontwerp.index') }}">Functioneel ontwerp</a></li>
                    <li class="mb-3"><a href="{{ route('technisch-ontwerp.index') }}">Technisch ontwerp</a></li>
                    <li><a href="{{ route('over-ons.index') }}">Over ons</a></li>
                    <li class="mb-3"><a href="{{ route('contact.index') }}">Contact</a></li>
                    <li><a href="{{ route('algemene-voorwaarden.index') }}">Algemene voorwaarden</a></li>
                    <li><a href="{{ route('privacystatement.index') }}">Privacyverklaring</a></li>
                    <li><a href="{{ route('cookiestatement.index') }}">Cookieverklaring</a></li>
                </ul>
            </div>

            <div class="mt-5">
                <h2 class="h4">Sitemap</h2>
                <ul>
                    <li><a href="{{ route('sitemap.index') }}">Sitemap</a></li>
                </ul>
            </div>

            <div class="mt-5">
                <p class="text-muted">Laatst bijgewerkt: 29-09-2024</p>
            </div>

        </div>
    </div>
</div>
@endsection
