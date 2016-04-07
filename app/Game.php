<?php

namespace App;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Game extends Model{

    protected $table = 'game';

    protected $fillable = ['random', 'signature', 'number'];

    public $timestamps = true;

}