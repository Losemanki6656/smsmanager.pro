<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public function organization()
    {
        return $this->belongsTo(Organization::class,'organization_id');
    }

    public function number()
    {
        return $this->belongsTo(Numbers::class,'number_id');
    }

    public function relays()
    {
        return $this->hasMany( Cadry::class, 'department_id');
    }

    
}
