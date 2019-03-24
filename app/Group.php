<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function creator()
    {
        return $this->belongsTo('App\User', 'creator_id');
    }
    
    public function participants()
    {
        return $this->belongsToMany('App\User')->withPivot('confirmed', 'token');
    }

    public function games()
    {
        return $this->belongsTo('App\Game');
    }
}
