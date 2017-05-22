<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'vehicles';

    protected $fillable = [
    	'plate', 'sticker_id', 'resident_owned', 'owner_name', 'resident_owner',
    ];
}
