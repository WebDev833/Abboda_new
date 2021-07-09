<?php

namespace App\ModelsByBabar;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
       protected $fillable = [
		   "company_id",
		   "name",
		   "cat_key"
		   ];
}
