<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public function profiel()
    {
        return view('account.mijn-account.profiel.index');
    }

    public function persoonlijkeGegevens()
    {
        return view('account.mijn-account.persoonlijke-gegevens.index');
    }

    public function wachtwoord()
    {
        return view('account.mijn-account.wachtwoord.index');
    }

    public function voorkeuren()
    {
        return view('account.mijn-account.voorkeuren.index');
    }

    public function activiteitslog()
    {
        return view('account.mijn-account.activiteitslog.index');
    }
}
