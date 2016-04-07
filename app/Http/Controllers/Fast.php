<?php namespace App\Http\Controllers;

use App\Bets;
use App\Game;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RandomOrgClient;
use App\User;
use Request;

class Fast extends Controller
{

    public function index()
    {
        return view('pages.fast');
    }


}
