<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\is_administrator;

use App\Http\Controllers\FormController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ConnectionsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ScrumboardController;

use App\Http\Controllers\AdminController;

Route::view('/', 'home')->name('home.index');
Route::view('/functioneel-ontwerp', 'information.functioneel.index')->name('functioneel-ontwerp.index');
Route::view('/technisch-ontwerp', 'information.technisch.index')->name('technisch-ontwerp.index');
Route::view('/contact', 'information.contact.index')->name('contact.index');
Route::view('/sitemap', 'information.sitemap.index')->name('sitemap.index');

Route::prefix('over-ons')->group(function () {
    Route::view('/', 'information.about.index')->name('over-ons.index');
    Route::view('/algemene-voorwaarden', 'information.algemeen.index')->name('algemene-voorwaarden.index');
    Route::view('/privacy-statement', 'information.privacy.index')->name('privacystatement.index');
    Route::view('/cookie-statement', 'information.cookies.index')->name('cookiestatement.index');
});

Route::post('/contact/sendform', [FormController::class, 'storeContactFormData'])->name('contact.sendform')->middleware('throttle:5,1');

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::post('/create-scrumbord', [DashboardController::class, 'createScrumbord'])->name('dashboard.create-scrumbord');
        Route::post('/update-scrumboard-settings', [DashboardController::class, 'updateSettings'])->name('dashboard.update-scrumboard-settings');
        
        Route::prefix('bekijk/{slug}/{id}')->group(function () {
            Route::get('/', [DashboardController::class, 'bekijkScrumboard'])->name('scrumboard.index');
            Route::get('/instellingen', [DashboardController::class, 'bekijkScrumboardInstellingen'])->name('scrumboard.instellingen');
                Route::post('/instellingen/update', [ScrumboardController::class, 'updateScrumboardInstellingen'])->name('scrumboard.instellingen.update');
            Route::get('/beschrijving', [DashboardController::class, 'bekijkScrumboardBeschrijving'])->name('scrumboard.beschrijving');
            Route::get('/takenlijst', [DashboardController::class, 'bekijkScrumboardTakenlijst'])->name('scrumboard.takenlijst');
            Route::get('/tijdlijn', [DashboardController::class, 'bekijkScrumboardTijdlijn'])->name('scrumboard.tijdlijn');
        });
    });
    

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

    Route::prefix('connecties')->group(function () {
        Route::get('/', [ConnectionsController::class, 'index'])->name('connecties.index');
        Route::get('/zoeken', [ConnectionsController::class, 'search'])->name('connecties.zoeken');
        Route::post('/toevoegen/{userId}', [ConnectionsController::class, 'addConnection'])->name('connecties.toevoegen');
        Route::get('/bekijk/{first_name}-{last_name}/{userId}', [ConnectionsController::class, 'viewProfile'])->name('connecties.view');
    });
});


Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::prefix('beheer')->group(function () {
        Route::get('/statistieken', [AdminController::class, 'showStatistieken'])->name('beheer.statistieken');

        Route::get('/formulieren', [AdminController::class, 'showFormSubmissions'])->name('beheer.formulieren');
        Route::post('/formulieren/update/{id}', [AdminController::class, 'updateFormSubmissions'])->name('beheer.formulieren.update');
        Route::post('/formulieren/delete/{id}', [AdminController::class, 'deleteFormSubmissions'])->name('beheer.formulieren.delete');

        Route::get('/gebruikers', [AdminController::class, 'showGebruikers'])->name('beheer.gebruikers');
        Route::delete('/gebruikers/destroy/{id}', [AdminController::class, 'destroyGebruikers'])->name('beheer.gebruikers.destroy');

        Route::get('/instellingen', [AdminController::class, 'instellingen'])->name('beheer.instellingen');
    });
});


// Fallback route voor niet-bestaande pagina's (404 PAGINA)
Route::fallback(function () {
    return response()->view('layouts.404page', [], 404);
});