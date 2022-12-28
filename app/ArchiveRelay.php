<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArchiveRelay extends Model
{
    public function cadry()
    {
        return $this->belongsTo(Relay::class,'user_id');
    }
}
