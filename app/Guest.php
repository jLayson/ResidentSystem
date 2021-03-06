<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $table = 'guests';

    protected $fillable = [
    	'name', 'reason', 'vehicle_plate', 'person_to_visit', 'time_departed', 'created_at',
    ];
}
