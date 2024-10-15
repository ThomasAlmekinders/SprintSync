@extends('layouts.app')

@section('content')
<div class="container-xxl py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <div class="card">
                <div class="card-header">{{ __('Functioneel Ontwerp (FO)') }}</div>

                <div class="card-body">
                    <!-- Navigatie voor tabbladen -->
                    <ul class="nav nav-tabs" id="foTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active fw-bold" id="inleiding-tab" data-bs-toggle="tab" href="#inleiding" role="tab" aria-controls="inleiding" aria-selected="true">Inleiding</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link fw-bold" id="functionaliteiten-tab" data-bs-toggle="tab" href="#functionaliteiten" role="tab" aria-controls="functionaliteiten" aria-selected="false">Functionaliteiten</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link fw-bold" id="gebruikers-tab" data-bs-toggle="tab" href="#gebruikers" role="tab" aria-controls="gebruikers" aria-selected="false">Gebruikers</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link fw-bold" id="technisch-tab" data-bs-toggle="tab" href="#technisch" role="tab" aria-controls="technisch" aria-selected="false">Technische Details</a>
                        </li>
                    </ul>

                    <!-- Inhoud van de tabs met extra padding in een div -->
                    <div class="tab-content" id="foTabContent">
                        <!-- Inleiding Tab -->
                        <div class="tab-pane fade show active" id="inleiding" role="tabpanel" aria-labelledby="inleiding-tab">
                            <div class="p-3">
                                <h4>Inleiding</h4>
                                <p>
                                    Dit Functioneel Ontwerp (FO) beschrijft de kernfunctionaliteiten van het project, een platform dat gebruikers in staat stelt om scrum boards te beheren. Het platform is ontworpen voor teams die op een eenvoudige manier projecten en taken willen organiseren en samenwerken. Dit FO is geschreven in het kader van een leerproject en biedt een solide basis voor verdere ontwikkeling.
                                </p>
                                <p>
                                    In de volgende secties worden de belangrijkste functionaliteiten, gebruikersrollen, en technische details van het platform besproken. Het ontwerp richt zich op een intuïtieve gebruikerservaring, waarbij efficiëntie en eenvoud centraal staan.
                                </p>
                            </div>
                        </div>

                        <!-- Functionaliteiten Tab -->
                        <div class="tab-pane fade" id="functionaliteiten" role="tabpanel" aria-labelledby="functionaliteiten-tab">
                            <div class="p-3">
                                <h4>Functionaliteiten</h4>
                                <p>
                                    Het platform biedt de volgende functionaliteiten voor gebruikers:
                                </p>
                                <ul>
                                    <li><strong>Scrum boards aanmaken:</strong> Gebruikers kunnen gemakkelijk een nieuw scrum board aanmaken en aanpassen aan hun wensen.</li>
                                    <li><strong>Beheer van taken:</strong> Elk scrum board biedt de mogelijkheid om taken aan te maken, toe te wijzen en de voortgang te monitoren.</li>
                                    <li><strong>Teambeheer:</strong> Gebruikers kunnen andere gebruikers uitnodigen en koppelen aan specifieke scrum boards om samen te werken.</li>
                                    <li><strong>Chatfunctie:</strong> Op elk scrum board is er een chat, waar gebruikers berichten kunnen achterlaten om direct te communiceren over taken en projecten.</li>
                                    <li><strong>Registratie en inloggen:</strong> Nieuwe gebruikers kunnen een account aanmaken door hun gegevens in te vullen en kunnen daarna inloggen om toegang te krijgen tot hun scrum boards.</li>
                                    <li><strong>Profielinstellingen:</strong> Gebruikers kunnen hun accountgegevens bijwerken, waaronder profielfoto, wachtwoord en meldingsvoorkeuren.</li>
                                    <li><strong>Contactformulier:</strong> Een ingebouwd contactformulier stelt gebruikers in staat om vragen te stellen of feedback te geven aan de beheerders van het platform.</li>
                                </ul>
                                <p>
                                    Het doel is om deze functies zo intuïtief mogelijk te maken, zodat zelfs gebruikers met weinig technische kennis de scrum boards effectief kunnen gebruiken.
                                </p>
                            </div>
                        </div>

                        <!-- Gebruikers Tab -->
                        <div class="tab-pane fade" id="gebruikers" role="tabpanel" aria-labelledby="gebruikers-tab">
                            <div class="p-3">
                                <h4>Gebruikers</h4>
                                <p>
                                    Het platform is bedoeld voor verschillende typen gebruikers, waaronder projectleiders, teamleden, en individuele gebruikers die hun projecten willen beheren. Hieronder een overzicht van de belangrijkste gebruikersgroepen:
                                </p>
                                <ul>
                                    <li><strong>Beheerders:</strong> Zij kunnen scrum boards aanmaken, taken beheren en andere gebruikers uitnodigen. Beheerders hebben volledige controle over de scrum boards.</li>
                                    <li><strong>Teamleden:</strong> Gebruikers die zijn uitgenodigd voor een scrum board kunnen taken bekijken, uitvoeren en chatten met andere teamleden. Zij hebben echter geen beheerrechten.</li>
                                    <li><strong>Individuele gebruikers:</strong> Gebruikers die hun eigen scrum boards willen aanmaken om persoonlijke projecten te beheren. Ze hebben dezelfde rechten als beheerders, maar werken zelfstandig.</li>
                                </ul>
                                <p>
                                    Elk van deze gebruikersgroepen heeft toegang tot dezelfde kernfunctionaliteiten, maar hun rechten binnen een scrum board kunnen verschillen afhankelijk van hun rol.
                                </p>
                            </div>
                        </div>

                        <!-- Technische Details Tab -->
                        <div class="tab-pane fade" id="technisch" role="tabpanel" aria-labelledby="technisch-tab">
                            <div class="p-3">
                                <h4>Technische Details</h4>
                                <p>
                                    Dit project is ontwikkeld met behulp van de volgende technologieën en tools:
                                </p>
                                <ul>
                                    <li><strong>Backend:</strong> Het platform is gebouwd met Laravel, een PHP-framework dat zorgt voor een robuuste back-end en eenvoudige database-interacties.</li>
                                    <li><strong>Frontend:</strong> Voor de gebruikersinterface wordt gebruikgemaakt van Bootstrap, waardoor het platform responsief is en er professioneel uitziet op zowel desktop- als mobiele apparaten.</li>
                                    <li><strong>Database:</strong> De gegevens worden opgeslagen in een MySQL-database, met tabellen voor gebruikers, gebruikersgroepen, scrum boards, taken, en berichten in de chat.</li>
                                    <li><strong>Authenticatie:</strong> Gebruikers kunnen zich registreren en inloggen via een beveiligde authenticatie, mogelijk gemaakt door Laravel’s ingebouwde authenticatiesysteem.</li>
                                    <li><strong>Versiebeheer:</strong> Git wordt gebruikt voor het versiebeheer van de codebase, zodat aanpassingen gemakkelijk kunnen worden bijgehouden en beheerd.</li>
                                </ul>
                                <p>
                                    Het doel van deze technische keuze is om het platform eenvoudig te beheren en schaalbaar te maken, zodat nieuwe functies in de toekomst gemakkelijk kunnen worden toegevoegd.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
