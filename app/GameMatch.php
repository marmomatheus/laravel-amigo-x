<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameMatch extends Model
{
    protected $table = 'game_matches';
    
    protected $fillable = [
        'user_id',
        'friend_id'
    ];
    
    public function game()
    {
        return $this->belongsTo('App\Game');
    }
}
