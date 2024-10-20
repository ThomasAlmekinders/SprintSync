<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ConnectionsController;
use App\Http\Controllers\DashboardController;

/* De simpele view routes (zonder controllers) */
Route::view('/', 'home')->name('home.index');
Route::view('/functioneel-ontwerp', 'information.functioneel.index')->name('functioneel-ontwerp.index');
Route::view('/technisch-ontwerp', 'information.technisch.index')->name('technisch-ontwerp.index');
Route::view('/contact', 'information.contact.index')->name('contact.index');
Route::view('/sitemap', 'information.sitemap.index')->name('sitemap.index');

/* Groeperen van over-ons routes */
Route::prefix('over-ons')->group(function () {
    Route::view('/', 'information.about.index')->name('over-ons.index');
    Route::view('/algemene-voorwaarden', 'information.algemeen.index')->name('algemene-voorwaarden.index');
    Route::view('/privacy-statement', 'information.privacy.index')->name('privacystatement.index');
    Route::view('/cookie-statement', 'information.cookies.index')->name('cookiestatement.index');
});

/* Contactformulier route, met throttle (max 5 per minuut) */
Route::post('/contact/sendform', [FormController::class, 'storeContactFormData'])->name('contact.sendform')->middleware('throttle:5,1');

// Auth routes
Auth::routes();

/* Beschermde routes (alleen ingelogde gebruikers) */
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    /* Account (instellingen) routes */
    Route::prefix('mijn-account')->group(function () {
        Route::get('/profiel', [AccountController::class, 'profiel'])->name('mijn-account.profiel');
        Route::post('/profiel/update-user', [AccountController::class, 'updateProfileUser'])->name('mijn-account.update-profile-user');
        Route::post('/profiel/update-picture', [AccountController::class, 'updateProfilePicture'])->name('mijn-account.update-profile-picture');

        Route::get('/persoonlijke-gegevens', [AccountController::class, 'persoonlijkeGegevens'])->name('mijn-account.persoonlijke-gegevens');
        Route::post('/persoonlijke-gegevens/update-personal-data', [AccountController::class, 'updatePersonalData'])->name('mijn-account.update-personal-data');

        Route::get('/wachtwoord', [AccountController::class, 'wachtwoord'])->name('mijn-account.wachtwoord');
        Route::post('/wachtwoord/update-wachtwoord', [AccountController::class, 'updatePassword'])->name('mijn-account.update-wachtwoord');

        Route::get('/voorkeuren', [AccountController::class, 'voorkeuren'])->name('mijn-account.voorkeuren');
        Route::post('/voorkeuren/update-voorkeuren', [AccountController::class, 'updateVisibility'])->name('mijn-account.update-visibility');

        Route::get('/activiteitslog', [AccountController::class, 'activiteitslog'])->name('mijn-account.activiteitslog');
    });

    /* connecties routes */
    Route::prefix('connecties')->group(function () {
        Route::get('/', [ConnectionsController::class, 'index'])->name('connecties.index');
        Route::get('/zoeken', [ConnectionsController::class, 'search'])->name('connecties.zoeken');
        Route::post('/toevoegen/{userId}', [ConnectionsController::class, 'addConnection'])->name('connecties.toevoegen');
        Route::get('/bekijk/{first_name}-{last_name}/{userId}', [ConnectionsController::class, 'viewProfile'])->name('connecties.view');
    });
});
