<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relay extends Model
{
    protected $dates = ['date_vacation','date_pos'];
    protected $dateFormat = 'Y-m-d';
}
