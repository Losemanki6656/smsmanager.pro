<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cadry extends Model
{
    protected $fillable = [
        'fullname','department', 'phone', 'date_vacation',
    ];

    protected $dates = ['last_date','next_date'];
    protected $dateFormat = 'Y-m-d';

    public function department()
    {
        return $this->belongsTo(Department::class,'department_id');
    }

    public function number()
    {
        return $this->belongsTo(Numbers::class,'number_id');
    }
}
