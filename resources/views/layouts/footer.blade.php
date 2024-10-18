<footer class="py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-4 text-center">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/logos/Logo_round_Comp.webp') }}" alt="{{ config('app.name', 'Laravel') }}" style="width: 150px; height: 115px;" height="115px" width="150px">
                </a>
                <p class="text-start">Een moderne tool voor het beheren van al jouw Scrum boards.</p>
            </div>
            <div class="col-md-4">
                <h5>Links</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home.index') }}" class="footer-link {{ Route::currentRouteName() == 'home.index' ? 'active' : '' }}">Home</a></li>
                    @auth
                    <li><a href="{{ route('dashboard.index') }}" class="footer-link {{ Route::currentRouteName() == 'dashboard.index' ? 'active' : '' }}">Dashboard</a></li>
                    <li><a href="{{ route('mijn-account.profiel') }}" class="footer-link {{ Route::currentRouteName() == 'mijn-account.profiel' ? 'active' : '' }}">Mijn Account</a></li>
                    <li><a href="{{ route('connecties.index') }}" class="footer-link {{ Route::currentRouteName() == 'connecties.index' ? 'active' : '' }}">Connecties</a></li>
                    @endauth
                    <li><a href="{{ route('over-ons.index') }}" class="footer-link {{ Route::currentRouteName() == 'over-ons.index' ? 'active' : '' }}">Over ons</a></li>
                    <li><a href="{{ route('contact.index') }}" class="footer-link {{ Route::currentRouteName() == 'contact.index' ? 'active' : '' }}">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Contact</h5>
                <p>Email: 
                    <a class="footer-link" href="mailto:111229@student.dcterra.nl">111229@student.dcterra.nl</a>
                </p>
                <p>Telefoon: 
                    <a class="footer-link" href="tel:+31612345678">+31 (0)6-12345678</a>
                </p>
                <div class="social-icons">
                    <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="footer-icon">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="https://x.com" target="_blank" rel="noopener noreferrer" class="footer-icon">
                        <i class="bi bi-twitter-x"></i>
                    </a>
                    <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" class="footer-icon">
                        <i class="bi bi-linkedin"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="text-center mt-3">
            <p>&copy; 2024 {{ config('app.name', 'Laravel') }}. Alle rechten voorbehouden.</p>
            <div class="">
                <a class="footer-link {{ Route::currentRouteName() == 'algemene-voorwaarden.index' ? 'active' : '' }}" href="{{ route('algemene-voorwaarden.index') }}">Algemene voorwaarden</a>
                <span> | </span>
                <a class="footer-link {{ Route::currentRouteName() == 'privacystatement.index' ? 'active' : '' }}" href="{{ route('privacystatement.index') }}">Privacy statement</a>
                <span> | </span>
                <a class="footer-link {{ Route::currentRouteName() == 'cookiestatement.index' ? 'active' : '' }}" href="{{ route('cookiestatement.index') }}">Cookie statement</a>
                <span> | </span>
                <a class="footer-link {{ Route::currentRouteName() == 'sitemap.index' ? 'active' : '' }}" href="{{ route('sitemap.index') }}">Sitemap</a>
            </div>
        </div>
    </div>
</footer>

<div class="web-settings">
    <i class="bi bi-gear"></i>
</div>

<!-- Welkomst Modal -->
<div class="modal fade" id="welcomeModal" tabindex="-1" role="dialog" aria-labelledby="welcomeModalLabel" aria-hidden="true" style="color: #000000;">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="welcomeModalLabel">Welkom bij SprintNest!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="alert alert-warning w-100" role="alert">
                    <strong>Let op!</strong> Deze website is momenteel in ontwikkeling. Sommige functies zijn mogelijk nog niet beschikbaar.
                </div>
                <div class="modal-tekst" style="padding: 1rem 2rem;">
                    <p>
                        SprintNest is een platform waar je eenvoudig scrumborden kunt aanmaken en beheren. Dit helpt teams om hun werk efficiënt te organiseren, de voortgang bij te houden en de samenwerking te verbeteren. Met tools zoals taakbeheer, deadlines en teamcommunicatie willen we je helpen om projecten soepel te laten verlopen.
                    </p>
                    <p>
                        Houd er rekening mee dat dit project een studentinitiatie is en dat het nog in ontwikkeling is. We doen ons best om een gebruiksvriendelijke ervaring te bieden, maar er kunnen nog bugs of andere problemen optreden. Er is ook een kans op gegevensverlies, dus we raden je aan om belangrijke informatie elders op te slaan.
                    </p>
                    <p>
                        Jouw feedback is van groot belang voor ons! We waarderen je geduld en we moedigen je aan om ons te laten weten wat je denkt. Samen kunnen we deze applicatie verbeteren en nog gebruiksvriendelijker maken. Dank je wel voor je bezoek aan SprintNest, en we hopen dat je een goede ervaring zult hebben terwijl we verder bouwen aan dit platform!
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sluiten</button>
            </div>
        </div>
    </div>
</div>
