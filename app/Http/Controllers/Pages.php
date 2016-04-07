<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Request;
use App\Bets;
use App\User;
use App\Game;

class Pages extends Controller
{
    public function about()
    {
        return view('pages.about');
    }


    public function shop()
    {
        return view('pages.shop');
    }

}
