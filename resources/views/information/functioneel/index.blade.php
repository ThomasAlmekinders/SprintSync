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
                                    Dit Functioneel Ontwerp (FO) beschrijft de kernfunctionaliteiten en technische aspecten van het project, een platform waarmee gebruikers scrumborden kunnen beheren. Het platform is ontworpen voor teams en individuen die projecten en taken op een eenvoudige en georganiseerde manier willen beheren. 
                                </p>
                                <p>
                                    Dit FO biedt een solide basis voor de huidige ontwikkeling, met een duidelijke focus op intuïtieve gebruikerservaring en schaalbaarheid. Het platform is ontwikkeld in het kader van een leerproject en kan in de toekomst verder worden uitgebreid met aanvullende functionaliteiten, zoals een live chatfunctie en premium accounts.
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
                                    <li><strong>Scrum boards aanmaken:</strong> Gebruikers kunnen scrumborden creëren en beheren.</li>
                                    <li><strong>Beheer van taken:</strong> Taken kunnen worden aangemaakt, toegewezen aan teamleden, en verplaatst tussen verschillende kolommen (To do, In progress, Done) met behulp van drag-and-drop functionaliteit.</li>
                                    <li><strong>Teambeheer:</strong> Gebruikers kunnen andere gebruikers zoeken en toevoegen aan specifieke scrumborden. Er is een optie om gebruikers binnen hetzelfde bedrijf/groep automatisch als suggestie te tonen.</li>
                                    <li><strong>Chatfunctie:</strong> Elk scrumbord biedt een chatoptie waar gebruikers berichten kunnen achterlaten. Een live chatfunctie is gepland voor toekomstige uitbreiding.</li>
                                    <li><strong>Registratie en inloggen:</strong> Gebruikers kunnen een account aanmaken met persoonlijke gegevens zoals naam, adres en telefoonnummer.</li>
                                    <li><strong>Profielinstellingen:</strong> Gebruikers kunnen hun accountgegevens bewerken, inclusief profielfoto's met CropperJS, wachtwoord en meldingsvoorkeuren.</li>
                                    <li><strong>Contactformulier:</strong> Een ingebouwd contactformulier stelt gebruikers in staat om vragen te stellen of feedback te geven.</li>
                                </ul>
                                <p>
                                    Het doel is om deze functionaliteiten zo gebruiksvriendelijk mogelijk te maken, zodat zowel technische als niet-technische gebruikers het platform effectief kunnen gebruiken.
                                </p>
                            </div>
                        </div>

                        <!-- Gebruikers Tab -->
                        <div class="tab-pane fade" id="gebruikers" role="tabpanel" aria-labelledby="gebruikers-tab">
                            <div class="p-3">
                                <h4>Gebruikers</h4>
                                <p>
                                    Het platform is ontworpen voor verschillende typen gebruikers, met specifieke rechten en functionaliteiten:
                                </p>
                                <ul>
                                    <li><strong>Beheerders:</strong> Hebben volledige controle over de scrumborden en kunnen gebruikers toevoegen of verwijderen, taken beheren en berichten modereren.</li>
                                    <li><strong>Teamleden:</strong> Kunnen samenwerken aan scrumborden, taken uitvoeren en communiceren via de chat. Ze hebben geen beheerrechten.</li>
                                    <li><strong>Individuele gebruikers:</strong> Kunnen scrumborden aanmaken en beheren voor persoonlijke projecten zonder samenwerking met anderen.</li>
                                </ul>
                                <p>
                                    Deze gebruikersgroepen hebben toegang tot dezelfde kernfunctionaliteiten, maar hun rechten verschillen afhankelijk van hun rol binnen een scrumbord.
                                </p>
                            </div>
                        </div>

                        <!-- Technische Details Tab -->
                        <div class="tab-pane fade" id="technisch" role="tabpanel" aria-labelledby="technisch-tab">
                            <div class="p-3">
                                <h4>Technische Details</h4>
                                <p>
                                    Het platform is gebouwd met behulp van moderne technologieën en tools om schaalbaarheid, beveiliging en gebruiksvriendelijkheid te waarborgen:
                                </p>
                                <ul>
                                    <li><strong>Backend:</strong> Laravel wordt gebruikt voor een robuuste backend, inclusief gehaste wachtwoorden voor gebruikersauthenticatie.</li>
                                    <li><strong>Frontend:</strong> Bootstrap zorgt voor een responsief design en intuïtieve gebruikersinterface.</li>
                                    <li><strong>Database:</strong> Gegevens worden opgeslagen in een MySQL-database, met tabellen voor gebruikers, teams, scrumborden, taken en chatberichten.</li>
                                    <li><strong>Afbeeldingen:</strong> CropperJS wordt gebruikt voor het bijsnijden en uploaden van profielfoto's.</li>
                                    <li><strong>Versiebeheer:</strong> Git wordt gebruikt om codeversies te beheren en samenwerking tussen ontwikkelaars te faciliteren.</li>
                                    <li><strong>Drag-and-drop:</strong> Gebouwd met behulp van JavaScript, geïntegreerd in de frontend voor het verplaatsen van taken.</li>
                                </ul>
                                <p>
                                    Deze technische opzet biedt een solide basis voor verdere ontwikkeling en uitbreiding van het platform.
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
