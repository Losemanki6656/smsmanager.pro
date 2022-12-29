<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    public function relays()
    {
        return $this->hasMany( Cadry::class, 'organization_id');
    }
}
