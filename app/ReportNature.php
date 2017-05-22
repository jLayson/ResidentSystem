<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportNature extends Model
{
	protected $table = 'report_natures';

	protected $fillable = [
		'nature_name',
	];
}
