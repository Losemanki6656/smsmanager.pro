<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb extends Model
{
    
    protected $dates = ['date_vacation'];
    protected $dateFormat = 'Y-m-d';
}
