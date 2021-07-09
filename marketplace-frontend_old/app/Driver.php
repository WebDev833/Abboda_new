<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use SoftDeletes;

    public $table = 'drivers';

    public $fillable = [
        /*'name',
        'email',
        'phone',
        'password',
        'user_type',
         */
        'user_id',
        'area_id',
        'age',
        'vehicle_no',
        'gender',
        'active',
        'online',
    ];

    protected $attributes = [
        'active' => 0, // 0 - Default Not active
        'online' => 0, // 0 - Default Not online
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function area()
    {
        return $this->belongsTo('App\Area');
    }

    public function acceptedorders()
    {
        return $this->hasMany('App\AcceptOrder', 'user_id', 'driver_id');
    }



}
