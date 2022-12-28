<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    public function cadry()
    {
        return $this->belongsTo(Cadry::class,'user_id');
    }
}
