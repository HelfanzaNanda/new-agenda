<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $guarded = [];

	protected $dates = [
		'start_date', 'end_date'
	];
}
