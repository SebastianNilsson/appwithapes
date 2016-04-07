<?php namespace App\Http\Controllers;

use App\Bets;
use App\Game;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RandomOrgClient;
use App\User;
use Request;

class Games extends Controller
{


    public $red = [1, 2, 3, 4, 5, 6, 7];
    public $black = [8, 9, 10, 11, 12, 13, 14];
    public $game;

    const NEW_BET = 'new.bet';

    public function __construct()
    {
        parent::__construct();
        $this->game = $this->getLastGame();
    }


    public function index()
    {

        $bets = Bets::orderBy('id', 'desc')->where('game_id', $this->game->id)->get();
        $games = Game::orderBy('id', 'desc')->where('status', 2)->take(14)->get();
        $red = Bets::where('game_id', $this->game->id)->where('color', 'red')->sum('sum');
        $black = Bets::where('game_id', $this->game->id)->where('color', 'black')->sum('sum');
        $zero = Bets::where('game_id', $this->game->id)->where('color', 'zero')->sum('sum');
        foreach ($games as $i) {
            $win_variant = "zero";
            if (in_array($i->number, $this->red)) {
                $win_variant = "red";
            } else if (in_array($i->number, $this->black)) {
                $win_variant = "black";
            }
            $i->color = $win_variant;
        }
        foreach ($bets as $bet) {
            $bet->user = User::find($bet->userid);
        }
        return view('pages.index', compact('bets', 'games', 'red', 'zero', 'black'));

    }

    public function getBalance()
    {
        return $this->user->money;
    }

    public function getWinners()
    {
        $win_variant = "zero";
        if (in_array($this->game->number, $this->red)) {
            $win_variant = "red";
        } else if (in_array($this->game->number, $this->black)) {
            $win_variant = "black";
        }
        $this->game->color = $win_variant;
        $winners = Bets::where("color", $win_variant)->where('game_id', $this->game->id)->get();
        foreach ($winners as $i) {
            $user = User::find($i->userid);
            $amount = $user->money + ($i->sum * 2);
            if ($win_variant == "zero") {
                $amount = $user->money + ($i->sum * 8);
            }
            $user->money = $amount;
            $user->save();
        }
        return $this->game;

    }

    public function setGameStatus()
    {
        $this->game->status = Request::get('status');
        $this->game->save();
        return $this->game;
    }

    public function getCurrentGame()
    {
        return $this->game;
    }

    public function getLastGame()
    {
        $game = Game::orderBy('id', 'desc')->first();
        if (is_null($game)) $game = $this->newGame();
        return $game;
    }

    public function newgame()
    {

        if ($this->game->status == 2) {

            $random = new RandomOrgClient();
            $arrRandomInt = $random->generateIntegers(1, 0, 14, false, 10, true);
            $game = Game::create(['random' => json_encode($random->last_response['result']['random']), 'signature' => $random->last_response['result']['signature'],
                'number' => $arrRandomInt[0]
            ]);
            return $game;
        }

    }


    public function newBetinapi()
    {
        $data = $this->redis->lrange('bets.list', 0, -1);
        foreach ($data as $newBetJson) {
            $bets = json_decode($newBetJson);
            $bet = Bets::create(['game_id' => $bets->gameid, 'userid' => $bets->userid, 'sum' => $bets->sum, 'color' => $bets->color]);
            $bet->user = User::find($bet->userid);
            $red = Bets::where('game_id', $bet->gameid)->where('color', 'red')->sum('sum');
            $black = Bets::where('game_id',$bet->gameid)->where('color', 'black')->sum('sum');
            $zero = Bets::where('game_id', $bet->gameid)->where('color', 'zero')->sum('sum');
            // $this->user->money -= Request::get('sum');
            //  $this->user->save();
            $this->redis->publish(self::NEW_BET, json_encode(['status' => 'success', 'id' => $bet->id, 'all' => $zero + $red + $black, 'red' => $red, 'zero' => $zero, 'black' => $black, 'game_id' => $bet->game_id, 'html' => view('includes.bet', compact('bet'))->render()]));
            $this->redis->lrem('bets.list', 0, $newBetJson);
        }
        return response()->json(['success' => true]);

    }

    function newbet()
    {


        $bets = Bets::where('game_id', $this->game->id)->where('userid', $this->user->id);


        if (empty($this->user->trade_link)) return ["status" => "error_steam", "msg" => "Укажите ссылку на обмен!"];

        if ($this->user->money < Request::get('sum')) return ["status" => "error_game", "msg" => "Пополните баланс ! "];

        if (Request::get('sum') < 1) return ["status" => "error_game", "msg" => "Минимальная ставка 1 коин"];

        if (Request::get('sum') > 1500000) return ["status" => "error_game", "msg" => "Максимальная ставка на цвет 1500000 коинов!"];

        if ($bets->where('color', Request::get('operation'))->sum('sum') >= 1500000) return ["status" => "error_game", "msg" => "Максимальная ставка на цвет 1500000 коинов!"];

        if ($this->game->status != 0) {
            // $this->_responseMessageToSite('Ваша ставка пойдёт на следующую игру.', $user->steamid64);
            // $this->redis->lrem('bets.list', 0, $newBetJson);
            $bets->userid = $this->user->id;
            $bets->sum =  Request::get('sum');
            $bets->color = Request::get('operation');
            $bets->gameid = $this->game->id + 1;
            $this->redis->rpush('bets.list', json_encode($bets));
            return ["status" => "error_game", "msg" => "Игра закончена ! Ваша ставка пойдёт на следующую игру."];
        }


        $bet = Bets::create(['game_id' => $this->game->id, 'userid' => $this->user->id, 'sum' => Request::get('sum'), 'color' => Request::get('operation')]);

        $bet->user = User::find($this->user->id);
        $red = Bets::where('game_id', $this->game->id)->where('color', 'red')->sum('sum');
        $black = Bets::where('game_id', $this->game->id)->where('color', 'black')->sum('sum');
        $zero = Bets::where('game_id', $this->game->id)->where('color', 'zero')->sum('sum');
        // $this->user->money -= Request::get('sum');
        //  $this->user->save();
        $this->redis->publish(self::NEW_BET, json_encode(['status' => 'success', 'id' => $bet->id, 'all' => $zero + $red + $black, 'red' => $red, 'zero' => $zero, 'black' => $black, 'game_id' => $this->game->id, 'html' => view('includes.bet', compact('bet'))->render()]));

    }


}
