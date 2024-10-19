@extends('account.mijn-account.index')

@section('account-content')
<div id="password-set" class="tab-pane fade show active" role="tabpanel" aria-labelledby="password-set-tab">
    <div class="px-3 py-4">
        <h3>Wachtwoord Wijzigen</h3>
        
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

        <form method="POST" action="{{ route('mijn-account.update-wachtwoord') }}">
            @csrf

            <div class="mb-3">
                <label for="current_password" class="form-label">{{ __('Huidig Wachtwoord') }}</label>
                <div class="input-group">
                    <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" autocomplete="off" required>
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('current_password', this)">
                        <i class="bi bi-eye-slash" id="eye-icon-current"></i>
                    </button>
                </div>
            </div>

            <div class="mb-3">
                <label for="new_password" class="form-label">{{ __('Nieuw Wachtwoord') }}</label>
                <div class="input-group">
                    <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" autocomplete="off" required>
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('new_password', this)">
                        <i class="bi bi-eye-slash" id="eye-icon-new"></i>
                    </button>
                </div>
                <div class="form-text">
                    <ul>
                        <li>Minimaal 8 tekens</li>
                        <li>Moet een hoofdletter bevatten</li>
                        <li>Moet een cijfer bevatten</li>
                        <li>Moet een speciaal teken bevatten (bijv. !@#$%^&*)</li>
                    </ul>
                </div>
            </div>

            <div class="mb-3">
                <label for="new_password_confirmation" class="form-label">{{ __('Bevestig Nieuw Wachtwoord') }}</label>
                <div class="input-group">
                    <input id="new_password_confirmation" type="password" class="form-control" name="new_password_confirmation" autocomplete="off" required>
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('new_password_confirmation', this)">
                        <i class="bi bi-eye-slash" id="eye-icon-confirm"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                {{ __('Wachtwoord Wijzigen') }}
            </button>
        </form>


    </div>
</div>
<script>
    function togglePasswordVisibility(inputId, button) {
        const input = document.getElementById(inputId);
        const icon = button.querySelector('i');

        if (input.type === "password") {
            input.type = "text"; // Maak het wachtwoord zichtbaar
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        } else {
            input.type = "password"; // Maak het wachtwoord onzichtbaar
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        }
    }
</script>
@endsection
