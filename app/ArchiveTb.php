<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArchiveTb extends Model
{
    public function cadry()
    {
        return $this->belongsTo(Tb::class,'user_id');
    }
}
