<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Driver extends Model implements HasMedia
{
    use SoftDeletes;
    use HasMediaTrait {
        getFirstMediaUrl as protected getFirstMediaUrlTrait;
    }
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
        'id_number',
        'social_security_number',
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
