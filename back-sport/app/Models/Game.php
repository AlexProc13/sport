<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'season', 'home_id', 'away_id', 'score_home', 'score_away', 'status', 'week'
    ];
}
