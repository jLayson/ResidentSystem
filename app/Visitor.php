<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $table = 'visitors';

    protected $fillable = [
    	'submitted_by', 'visitor_name', 'reason_for_visit', 'time_expected', 'time_arrived', 'visitor_code'
    ];
}
