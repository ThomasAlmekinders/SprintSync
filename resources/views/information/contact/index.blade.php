@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Hero sectie -->
    <div class="row justify-content-center mb-5">
        <div class="col-12 text-center">
            <div class="pt-5 pb-3">
                <h1>Neem contact met ons op</h1>
            </div>
        </div>
    </div>

    <!-- Contactformulier en tekst naast elkaar -->
    <div class="row mb-5">
        <div class="col-md-6">
        <h2>Contacteer ons</h2>
        <p>Heeft u vragen, opmerkingen of feedback? We staan altijd klaar om te helpen. Vul het contactformulier in of bereik ons direct via e-mail. Ons team streeft ernaar om zo snel mogelijk te reageren.</p>
        <ul class="list-unstyled mt-4">
            <li><strong>E-mailadres:</strong> <a href="mailto:111229@student.dcterra.nl">111229@student.dcterra.nl</a></li>
            <li><strong>Telefoon:</strong> <a href="tel:310612345678">+31 (0)6-12345678</a></li>
            <li><strong>Adres:</strong> Oosterhoutstraat 48, 9401 NG Assen</li>
        </ul>
    </div>


        <div class="col-md-6">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div>

                <form method="POST" action="{{ route('contact.sendform') }}" class="form contact-form">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-12 col-md-5">
                            <label for="first_name">Voornaam</label>
                            <input type="text" name="first_name" class="form-control" id="first_name" placeholder="Uw voornaam" value="{{ Auth::user()->first_name ?? '' }}" required>
                        </div>
                        <div class="col-12 col-md-7">
                            <label for="last_name">Achternaam</label>
                            <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Uw achternaam" value="{{ Auth::user()->last_name ?? '' }}" required>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="email">E-mailadres</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Uw e-mailadres" value="{{ Auth::user()->email ?? '' }}" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="phone">Telefoonnummer <small>(optioneel)</small></label>
                        <input type="tel" name="phone" class="form-control" id="phone" placeholder="Uw telefoonnummer" value="{{ Auth::user()->phone_number ?? '' }}">
                    </div>
                    <div class="form-group mb-4">
                        <label for="subject">Onderwerp <small>(optioneel)</small></label>
                        <input type="text" name="subject" class="form-control" id="subject" placeholder="Kies een onderwerp">
                    </div>
                    <div class="form-group mb-4">
                        <label for="message">Bericht</label>
                        <textarea name="message" class="form-control" id="message" rows="5" placeholder="Uw bericht" required></textarea>
                    </div>
                    <div style="display:none;">
                        <label for="website">Laat dit veld leeg</label>
                        <input type="text" name="website" id="website" value="">
                    </div>

                    @if(Auth::check())
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    @endif

                    <div class="text-center">
                        <button class="btn btn-primary btn-lg" type="submit">Verstuur</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Informatie Blokken onder het formulier -->
    <div class="row text-center my-5 py-5">
        <div class="col-md-4">
            <i class="bi bi-envelope-fill text-primary" style="font-size: 3rem;"></i>
            <h4 class="mt-3">E-mail</h4>
            <p>Stuur ons een bericht op <a href="mailto:111229@student.dcterra.nl">111229@student.dcterra.nl</a></p>
        </div>
        <div class="col-md-4">
            <i class="bi bi-telephone-fill text-primary" style="font-size: 3rem;"></i>
            <h4 class="mt-3">Telefoon</h4>
            <p>Bel ons op +31 (0)6-12345678</p>
        </div>
        <div class="col-md-4">
            <i class="bi bi-geo-alt-fill text-primary" style="font-size: 3rem;"></i>
            <h4 class="mt-3">Adres</h4>
            <p>Oosterhoutstraat 48, 9401 NG Assen</p>
        </div>
    </div>

</div>

<!-- Google Maps -->
<div class="d-flex mt-5">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2401.6965421932928!2d6.561005612725568!3d52.98985900122035!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c824fcb5063f13%3A0x72b88fe478f66154!2sOosterhoutstraat%2048%2C%209401%20NG%20Assen!5e0!3m2!1snl!2snl!4v1727685559995!5m2!1snl!2snl" 
            width="100%" height="450px" 
            loading="lazy"
            style="border: 0;
                    width: 100%;
                    height: 500px;" 
            title="Onze locatie op Google Maps"
            allowfullscreen
            referrerpolicy="no-referrer-when-downgrade"></iframe>
            <noscript>
                <img src="{{ asset('images/Locatie_comp.webp') }}" alt="Google Maps locatie"
                     height="500px" width="100%"
                     loading="lazy"
                     style="height: 500px; width: 100%;">
            </noscript>
</div>
@endsection
