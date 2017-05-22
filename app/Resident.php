<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
	protected $table = 'residents';

    protected $fillable = [
    	'name_first', 'name_middle', 'name_last', 'address',
    	'phone_number', 'mobile_number', 'birth_date',
    ];
}
