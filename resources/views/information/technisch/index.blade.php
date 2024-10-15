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
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="performance-tab" data-bs-toggle="tab" href="#performance" role="tab" aria-controls="performance" aria-selected="false">Prestaties & Schaling</a>
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
                            <h5>Databaseontwerp</h5>
                            <p>We gebruiken XAMPP voor het draaien van de database, wat het leven een stuk makkelijker maakt. De database is opgebouwd met verschillende tabellen die de basisgegevens van de applicatie bevatten. Hier zijn de belangrijkste tabellen en hun attributen:</p>
                            <ul>
                                <li><strong>Users</strong>:
                                    <ul>
                                        <li>id (PK)</li>
                                        <li>first_name</li>
                                        <li>last_name</li>
                                        <li>email</li>
                                        <li>profile_picture</li>
                                    </ul>
                                </li>
                                <li><strong>Scrumboards</strong>:
                                    <ul>
                                        <li>id (PK)</li>
                                        <li>name</li>
                                        <li>description</li>
                                        <li>owner_id (FK naar Users)</li>
                                    </ul>
                                </li>
                                <li><strong>Chats</strong>:
                                    <ul>
                                        <li>id (PK)</li>
                                        <li>message</li>
                                        <li>sender_id (FK naar Users)</li>
                                        <li>scrumboard_id (FK naar Scrumboards)</li>
                                    </ul>
                                </li>
                            </ul>
                            <p>Voor het beheren van de database gebruiken we migraties in Laravel, waarmee we eenvoudig wijzigingen kunnen aanbrengen zonder gegevens te verliezen.</p>
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

                        <!-- Prestaties en Schaling -->
                        <div class="tab-pane fade p-3" id="performance" role="tabpanel" aria-labelledby="performance-tab">
                            <h5>Prestaties & Schaling</h5>
                            <p>Een soepel lopende applicatie is cruciaal. Daarom hebben we enkele plannen om de prestaties te optimaliseren:</p>
                            <ul>
                                <li>We implementeren lazy loading voor afbeeldingen, zodat de laadtijden van pagina's worden verminderd. Hierdoor hoeven gebruikers niet te wachten op afbeeldingen die ze misschien nooit bekijken.</li>
                                <li>Daarnaast richten we ons op een efficiënt gebruik van database queries om ervoor te zorgen dat alles snel en soepel werkt, zelfs als het aantal gebruikers toeneemt.</li>
                            </ul>
                            <p>Op dit moment zijn er geen plannen om het project op grotere schaal uit te breiden, omdat we lokaal werken en ons richten op kleinere toepassingen. Maar wie weet wat de toekomst brengt?</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
