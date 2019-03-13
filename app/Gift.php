<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    protected $fillable = [
        'name'
    ];
    
    public function gifts()
    {
        return $this->belongsTo('App\Gift');
    }
}
