<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FormController;
use App\Http\Controllers\AccountController;


Route::get('/', function () {
    return view('home');
})->name('home.index');


Route::get('/functioneel-ontwerp', function () {
    return view('information.functioneel.index');
})->Name('functioneel-ontwerp.index');
Route::get('/technisch-ontwerp', function () {
    return view('information.technisch.index');
})->Name('technisch-ontwerp.index');

Route::get('/over-ons', function () {
    return view('information.about.index');
})->Name('over-ons.index');

Route::get('/over-ons/algemene-voorwaarden', function () {
    return view('information.algemeen.index');
})->Name('algemene-voorwaarden.index');
Route::get('/over-ons/privacy-statement', function () {
    return view('information.privacy.index');
})->Name('privacystatement.index');
Route::get('/over-ons/cookie-statement', function () {
    return view('information.cookies.index');
})->Name('cookiestatement.index');

Route::get('/contact', function () {
    return view('information.contact.index');
})->Name('contact.index');
Route::post('/contact/sendform', [FormController::class, 'storeContactFormData'])->name('contact.sendform')->middleware('throttle:5,1'); // Max 5 verzoeken per minuut

Route::get('/sitemap', function () {
    return view('information.sitemap.index');
})->Name('sitemap.index');

Auth::routes();

Route::group(['middleware' => ['auth']], function() {

    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard.index');


    Route::get('/mijn-account', function () {
        return view('account.mijn-account.index');
    })->name('mijn-account.index');
    Route::get('/mijn-account/profiel', [Controller::class, 'profiel'])->name('mijn-account.profiel');
        Route::post('/mijn-account/profiel/update-user', [AccountController::class, 'updateProfileUser'])->name('mijn-account.update-profile-user');
        Route::post('/mijn-account/profiel/update-picture', [AccountController::class, 'updateProfilePicture'])->name('mijn-account.update-profile-picture');

    Route::get('/mijn-account/persoonlijke-gegevens', [Controller::class, 'persoonlijkeGegevens'])->name('mijn-account.persoonlijke-gegevens');
        Route::post('/mijn-account/persoonlijke-gegevens/update-personal-data', [AccountController::class, 'updatePersonalData'])->name('mijn-account.update-personal-data');

    Route::get('/mijn-account/wachtwoord', [Controller::class, 'wachtwoord'])->name('mijn-account.wachtwoord');
        Route::post('/mijn-account/wachtwoord/update-wachtwoord', [AccountController::class, 'updatePassword'])->name('mijn-account.update-wachtwoord');

    Route::get('/mijn-account/voorkeuren', [Controller::class, 'voorkeuren'])->name('mijn-account.voorkeuren');
    Route::get('/mijn-account/activiteitslog', [Controller::class, 'activiteitslog'])->name('mijn-account.activiteitslog');


    Route::get('/connecties', function () {
        return view('account.connecties.index');
    })->name('connecties.index');
});