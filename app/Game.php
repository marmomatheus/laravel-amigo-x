<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $casts = [
        'exchange_date' => 'date:d/m/Y'
    ];

    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function matches()
    {
        return $this->hasMany('App\GameMatch');
    }
}
