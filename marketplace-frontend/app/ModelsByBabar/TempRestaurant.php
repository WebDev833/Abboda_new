<?php

namespace App\ModelsByBabar;

use Illuminate\Database\Eloquent\Model;

class TempRestaurant extends Model
{
    protected $table = 'temp_restaurant_data';

    protected $connection = 'mysql2';
}
