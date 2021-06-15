<?php

namespace App\Traits;

use Carbon\Carbon;

trait ConvertDate {
	public function convertDate($date)
	{
		return Carbon::parse($date)->format('Y-m-d');
	}
}