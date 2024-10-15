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
                    <li><a href="/">Home</a></li>
                </ul>
            </div>


            <div class="mt-5">
                <h2 class="h4">Accountbeheer</h2>
                <ul>
                    <li class=""><a href="/mijn-account">Mijn account</a></li>
                    <li class="mb-3"><a href="/connecties">Connecties</a></li>
                    <li><a href="/register">Registratie</a></li>
                    <li><a href="/login">Inloggen</a></li>
                    <li><a href="/password/reset">Wachtwoord Vergeten</a></li>
                </ul>
            </div>


            <div class="mt-5">
                <h2 class="h4">Functies</h2>
                <ul>
                    <li><a href="/dashboard">Dashboard</a></li>
                </ul>
            </div>


            <div class="mt-5">
                <h2 class="h4">Informatie</h2>
                <ul>
                    <li><a href="/functioneel-ontwerp">Functioneel ontwerp</a></li>
                    <li class="mb-3"><a href="/technisch-ontwerp">Technisch ontwerp</a></li>
                    <li><a href="/over-ons">Over ons</a></li>
                    <li class="mb-3"><a href="/contact">Contact</a></li>
                    <li><a href="/algemene-voorwaarden">Algemene voorwaarden</a></li>
                    <li><a href="/privacy-statement">Privacyverklaring</a></li>
                    <li><a href="/cookie-statement">Cookieverklaring</a></li>
                </ul>
            </div>


            <div class="mt-5">
                <h2 class="h4">Sitemap</h2>
                <ul>
                    <li><a href="/sitemap">Sitemap</a></li>
                </ul>
            </div>


            <div class="mt-5">
                <p class="text-muted">Laatst bijgewerkt: 29-09-2024</p>
            </div>

        </div>
    </div>
</div>
@endsection
