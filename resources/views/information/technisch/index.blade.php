@extends('layouts.app')

@section('content')
<div class="container-xxl py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <div class="card">
                <div class="card-header">{{ __('Technisch Ontwerp') }}</div>

                <div class="card-body">
                    <!-- Navigatie voor tabbladen -->
                    <ul class="nav nav-tabs" id="technicalTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="architecture-tab" data-bs-toggle="tab" href="#architecture" role="tab" aria-controls="architecture" aria-selected="true">Architectuur</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="database-tab" data-bs-toggle="tab" href="#database" role="tab" aria-controls="database" aria-selected="false">Database</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="security-tab" data-bs-toggle="tab" href="#security" role="tab" aria-controls="security" aria-selected="false">Beveiliging</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="tools-tab" data-bs-toggle="tab" href="#tools" role="tab" aria-controls="tools" aria-selected="false">Tools en Frameworks</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="technicalTabContent">
                        <!-- Architectuur -->
                        <div class="tab-pane fade show active p-3" id="architecture" role="tabpanel" aria-labelledby="architecture-tab">
                            <h5>MVC Architectuur</h5>
                            <p>Dit project is opgebouwd met het Laravel-framework, dat de populaire MVC-architectuur (Model-View-Controller) gebruikt. Dit houdt in dat we de logica, data en presentatie van elkaar scheiden, wat het onderhoud en de ontwikkeling een stuk eenvoudiger maakt.</p>
                            <p>Hier is een korte uitleg van de drie belangrijkste componenten:</p>
                            <ul>
                                <li><strong>Model</strong>: Dit zijn de data-structuren die de database-entiteiten vertegenwoordigen. Denk aan <em>User</em> voor gebruikersinformatie, <em>Scrumboard</em> voor het beheren van scrumborden, en <em>Chat</em> voor alle chatberichten. Elk model heeft de nodige relaties gedefinieerd, zodat alles soepel samenwerkt.</li>
                                <li><strong>View</strong>: De frontend van onze applicatie, waarin we gebruikmaken van Blade-sjablonen voor dynamische content. Door Bootstrap toe te voegen, zorgen we ervoor dat onze interface er niet alleen goed uitziet, maar ook responsief is op verschillende apparaten.</li>
                                <li><strong>Controller</strong>: Dit is de schakel tussen Model en View. Controllers behandelen binnenkomende verzoeken, verwerken ze, en geven de juiste gegevens door aan de Views. Bijvoorbeeld, wanneer een gebruiker inlogt, zal de controller de gebruikersinformatie ophalen en deze naar de view sturen voor weergave.</li>
                            </ul>
                        </div>

                        <!-- Database -->
                        <div class="tab-pane fade p-3" id="database" role="tabpanel" aria-labelledby="database-tab">
                            <div class="container">
                                <h2 class="text-primary mb-4">Databaseontwerp</h2>
                                <p>De database van SprintSync is ontworpen volgens een relationeel model en wordt beheerd via Laravel-migraties. Dit model biedt ondersteuning voor gebruikersbeheer, scrumborden, takenbeheer, en communicatie via chat.</p>

                                <!-- Tabellenoverzicht -->
                                <div class="card mb-4">
                                    <div class="card-header bg-primary text-white">
                                        <h4>Tabellenoverzicht</h4>
                                    </div>
                                    <div class="card-body">
                                        <p>Hieronder volgt een overzicht van de belangrijkste tabellen:</p>
                                        <ul>
                                            <li><strong>Users:</strong> Bevat gebruikersinformatie zoals profielinstellingen.</li>
                                            <li><strong>Scrumboards:</strong> Beheert scrumborden en hun details.</li>
                                            <li><strong>Scrumboard_tasks:</strong> Beheert taken binnen scrumborden.</li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Users tabel -->
                                <div class="card mb-4">
                                    <div class="card-header bg-secondary text-white">
                                        <h5>Users</h5>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Functie:</strong> Bevat informatie over gebruikers, zoals inloggegevens en profielinstellingen.</p>
                                        <h6>Belangrijke attributen:</h6>
                                        <ul>
                                            <li><strong>id:</strong> Primaire sleutel (PK), unieke identificatie.</li>
                                            <li><strong>username:</strong> Unieke gebruikersnaam.</li>
                                            <li><strong>email:</strong> Uniek e-mailadres.</li>
                                            <li><strong>profile_picture:</strong> Link naar profielfoto.</li>
                                        </ul>
                                        <h6>Relaties:</h6>
                                        <ul>
                                            <li>Een gebruiker kan meerdere scrumborden aanmaken.</li>
                                            <li>Een gebruiker kan verbonden zijn met meerdere scrumborden.</li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Scrumboards tabel -->
                                <div class="card mb-4">
                                    <div class="card-header bg-secondary text-white">
                                        <h5>Scrumboards</h5>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Functie:</strong> Beheert scrumborden en hun details.</p>
                                        <h6>Belangrijke attributen:</h6>
                                        <ul>
                                            <li><strong>id:</strong> Primaire sleutel (PK), unieke identificatie.</li>
                                            <li><strong>creator_id:</strong> Buitenlandse sleutel (FK) verwijzend naar een gebruiker.</li>
                                            <li><strong>title:</strong> Titel van het scrumbord.</li>
                                        </ul>
                                        <h6>Relaties:</h6>
                                        <ul>
                                            <li>Een scrumbord bevat meerdere sprints en taken.</li>
                                            <li>Een scrumbord kan gedeeld worden met meerdere gebruikers.</li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Scrumboard_tasks tabel -->
                                <div class="card mb-4">
                                    <div class="card-header bg-secondary text-white">
                                        <h5>Scrumboard_tasks</h5>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Functie:</strong> Beheert taken binnen scrumborden.</p>
                                        <h6>Belangrijke attributen:</h6>
                                        <ul>
                                            <li><strong>id:</strong> Primaire sleutel (PK), unieke identificatie.</li>
                                            <li><strong>sprint_id:</strong> Buitenlandse sleutel (FK) verwijzend naar een sprint.</li>
                                            <li><strong>title:</strong> Titel van de taak.</li>
                                            <li><strong>status:</strong> Status van de taak (bijv. "to_do").</li>
                                        </ul>
                                        <h6>Relaties:</h6>
                                        <ul>
                                            <li>Elke taak behoort tot een sprint.</li>
                                            <li>Een taak kan toegewezen worden aan één gebruiker.</li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Relaties en beheer -->
                                <div class="card mb-4">
                                    <div class="card-header bg-primary text-white">
                                        <h4>Relaties en beheer</h4>
                                    </div>
                                    <div class="card-body">
                                        <p>De database is relationeel en gebruikt primaire en vreemde sleutels voor gegevensintegriteit. Laravel-migraties worden gebruikt voor beheer en versiecontrole.</p>
                                        <ul>
                                            <li>Relationeel model voor data-consistentie.</li>
                                            <li>Veel-op-veel relaties tussen gebruikers en scrumborden.</li>
                                        </ul>
                                        <img src="{{ asset('images/SprintNest_DB_ontwerp.png') }}" alt="DB ontwerp" class="img-fluid" style="width: 100%; height: auto;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Beveiliging -->
                        <div class="tab-pane fade p-3" id="security" role="tabpanel" aria-labelledby="security-tab">
                            <h5>Beveiliging</h5>
                            <p>Beveiliging is een essentieel onderdeel van elk project, en gelukkig biedt Laravel een solide basis. Op dit moment maken we gebruik van enkele ingebouwde beveiligingsmechanismen, zoals:</p>
                            <ul>
                                <li>Authenticatie via Laravel's standaard <em>auth</em>-systeem, waardoor gebruikers veilig kunnen inloggen.</li>
                                <li>Wachtwoord-hashing met <em>bcrypt</em> om de wachtwoorden veilig op te slaan in de database.</li>
                                <li>CSRF-bescherming om ervoor te zorgen dat onze formulieren niet kunnen worden misbruikt door kwaadwillenden.</li>
                            </ul>
                            <p>In de toekomst willen we ook kijken naar meer geavanceerde beveiligingsopties, zoals OAuth-authenticatie en bescherming tegen SQL-injecties en XSS-aanvallen. Beveiliging is iets dat altijd in ontwikkeling is!</p>
                        </div>

                        <!-- Tools en Frameworks -->
                        <div class="tab-pane fade p-3" id="tools" role="tabpanel" aria-labelledby="tools-tab">
                            <h5>Tools en Frameworks</h5>
                            <p>In dit project maken we gebruik van een aantal handige tools en frameworks die de ontwikkeling vergemakkelijken:</p>
                            <ul>
                                <li><strong>Laravel</strong>: Ons favoriete framework voor de backend, dat ons in staat stelt om snel en efficiënt te ontwikkelen.</li>
                                <li><strong>Bootstrap</strong>: Voor een mooie, responsieve frontend. Het maakt onze site toegankelijk en gebruiksvriendelijk op verschillende apparaten.</li>
                                <li><strong>Git</strong>: Versiebeheer via GitHub, waar we regelmatig branches maken. Zo kunnen we nieuwe functies uitproberen zonder de hoofdversie te verstoren.</li>
                                <li><strong>CropperJS</strong>: Een handige tool voor het uploaden en bijsnijden van profielfoto's, zodat onze gebruikers altijd een mooi profiel kunnen hebben.</li>
                                <li><strong>VSCode</strong>: De favoriete editor voor de meeste ontwikkelaars, en het is ook onze keuze voor dit project!</li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
