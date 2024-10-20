<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class AdminController extends Controller
{
    public function statistieken()
    {
        return view('account.beheer.statistieken.index');
    }

    public function formulieren()
    {
        return view('account.beheer.formulieren.index');
    }

    public function gebruikers()
    {
        return view('account.beheer.gebruikers.index');
    }

    public function instellingen()
    {
        return view('account.beheer.instellingen.index');
    }
}