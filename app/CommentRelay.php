<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentRelay extends Model
{
    public function cadry()
    {
        return $this->belongsTo(Cadry::class,'user_id');
    }
}
