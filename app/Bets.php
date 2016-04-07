<?php

namespace App;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Bets extends Model{

    protected $table = 'bets';

    protected $fillable = ['game_id', 'userid', 'sum','color'];

    public $timestamps = true;

}