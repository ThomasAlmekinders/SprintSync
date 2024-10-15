<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;


Route::get('/', function () {
    return view('home');
});


Route::get('/functioneel-ontwerp', function () {
    return view('information.functioneel.index');
});
Route::get('/technisch-ontwerp', function () {
    return view('information.technisch.index');
});
Route::get('/over-ons', function () {
    return view('information.about.index');
});
Route::get('/over-ons/algemene-voorwaarden', function () {
    return view('information.algemeen.index');
});
Route::get('/over-ons/privacy-statement', function () {
    return view('information.privacy.index');
});
Route::get('/over-ons/cookie-statement', function () {
    return view('information.cookies.index');
});
Route::get('/contact', function () {
    return view('information.contact.index');
});
Route::post('/contact/sendform', [FormController::class, 'storeContactFormData'])->name('contact.sendform')->middleware('throttle:5,1'); // Max 5 verzoeken per minuut
Route::get('/sitemap', function () {
    return view('information.sitemap.index');
});

Auth::routes();