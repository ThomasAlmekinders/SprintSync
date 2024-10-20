<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Models\ActivityLog;

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
        $user = auth()->user();

        return view('account.mijn-account.voorkeuren.index', compact('user'));
    }

    public function activiteitslog()
    {
        $activityLogs = ActivityLog::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
        return view('account.mijn-account.activiteitslog.index', compact('activityLogs'));
    }
}
