<footer class="py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-4 text-center">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <!-- <img src="{{ asset('images/logos/Logo_Tekst.svg') }}" alt="{{ config('app.name', 'Laravel') }}" style="width: 200px; height: auto;" height="67px" width="200px"> -->
                    <img src="{{ asset('images/logos/Logo_round_Comp.webp') }}" alt="{{ config('app.name', 'Laravel') }}" style="width: 150px; height: 115px;" height="115px" width="150px">
                </a>
                <p class="text-start">Een moderne tool voor het beheren van al jouw Scrum boards.</p>
            </div>
            <div class="col-md-4">
                <h5>Links</h5>
                <ul class="list-unstyled">
                    <li><a href="/" class="footer-link {{ Request::is('/') ? 'active' : '' }}">Home</a></li>
                    @auth
                    <li><a href="/dashboard" class="footer-link {{ Request::is('dashboard') ? 'active' : '' }}">Dashboard</a></li>
                    @endauth
                    <li><a href="/over-ons" class="footer-link {{ Request::is('over-ons') ? 'active' : '' }}">Over ons</a></li>
                    <li><a href="/contact" class="footer-link {{ Request::is('contact') ? 'active' : '' }}">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Contact</h5>
                <p>Email: 
                    <a class="footer-link" href="mailto:111229@student.dcterra.nl">111229@student.dcterra.nl</a>
                </p>
                <p>Telefoon: 
                    <a class="footer-link" href="tel:310612345678">+31 (0)6-12345678</a>
                </p>
                <div class="social-icons">
                    <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="footer-icon">
                        <i class="bi bi-facebook"></i>
                        <span> </span>
                    </a>
                    <a href="https://x.com" target="_blank" rel="noopener noreferrer" class="footer-icon">
                        <i class="bi bi-twitter-x"></i>
                        <span> </span>
                    </a>
                    <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" class="footer-icon">
                        <i class="bi bi-linkedin"></i>
                        <span> </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="text-center mt-3">
            <p>&copy; 2024 {{ config('app.name', 'Laravel') }}. Alle rechten voorbehouden.</p>
            <div class="">
                <a class="footer-link {{ Request::is('over-ons/algemene-voorwaarden') ? 'active' : '' }}"
                   href="/over-ons/algemene-voorwaarden">Algemene voorwaarden</a>
                <span> | </span>
                <a class="footer-link {{ Request::is('over-ons/privacy-statement') ? 'active' : '' }}"
                   href="/over-ons/privacy-statement">Privacy statement</a>
                <span> | </span>
                <a class="footer-link {{ Request::is('over-ons/cookie-statement') ? 'active' : '' }}"
                   href="/over-ons/cookie-statement">Cookie statement</a>
                <span> | </span>
                <a class="footer-link {{ Request::is('sitemap') ? 'active' : '' }}"
                   href="/sitemap">Sitemap</a>
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
                <h5 class="modal-title" id="welcomeModalLabel">Welkom bij SprintSync!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="alert alert-warning w-100" role="alert">
                    <strong>Let op!</strong> Deze website is momenteel in ontwikkeling. Sommige functies zijn mogelijk nog niet beschikbaar.
                </div>
                <div class="modal-tekst" style="padding: 1rem 2rem;">
                    <p>
                        SprintSync is een platform waar je eenvoudig scrumborden kunt aanmaken en beheren. Dit helpt teams om hun werk efficiënt te organiseren, de voortgang bij te houden en de samenwerking te verbeteren. Met tools zoals taakbeheer, deadlines en teamcommunicatie willen we je helpen om projecten soepel te laten verlopen.
                    </p>
                    <p>
                        Houd er rekening mee dat dit project een studentinitiatie is en dat het nog in ontwikkeling is. We doen ons best om een gebruiksvriendelijke ervaring te bieden, maar er kunnen nog bugs of andere problemen optreden. Er is ook een kans op gegevensverlies, dus we raden je aan om belangrijke informatie elders op te slaan.
                    </p>
                    <p>
                        Jouw feedback is van groot belang voor ons! We waarderen je geduld en we moedigen je aan om ons te laten weten wat je denkt. Samen kunnen we deze applicatie verbeteren en nog gebruiksvriendelijker maken. Dank je wel voor je bezoek aan SprintSync, en we hopen dat je een goede ervaring zult hebben terwijl we verder bouwen aan dit platform!
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sluiten</button>
            </div>
        </div>
    </div>
</div>