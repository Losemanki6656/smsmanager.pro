<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Numbers extends Model
{
  
    public function relays()
    {
        return $this->hasMany( Cadry::class, 'number_id');
    }

}
