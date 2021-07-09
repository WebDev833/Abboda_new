<?php

namespace App\ModelsByBabar;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   protected $fillable = [
	   "company_id",
	   "category_id",
	   "name",
	   "description",
	   "sizeUUID",
	   "imageUrl",
	   "price"
   ];
}
