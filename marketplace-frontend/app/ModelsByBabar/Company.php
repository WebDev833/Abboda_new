<?php

namespace App\ModelsByBabar;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
   protected $fillable = [
   "companytype_id",
   "area_id",
   "name",
   "description",
   "email",
   "phone",
   "rating",
   "slug",
   "latitude",
   "longitude",
   "coverImgUrl",
   "address"
   ];
}
