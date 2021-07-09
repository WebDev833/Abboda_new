<?php

namespace App\ModelsByBabar;

use Illuminate\Database\Eloquent\Model;

class WorkDay extends Model
{
	protected $table = 'workdays';
           protected $fillable = [
		   "company_id",
		   "day",
		   "open_time",
		   "close_time"
		   ];
}
