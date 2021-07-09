<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderGps extends Model
{
    use SoftDeletes;
    public $table = 'order_gps';

    public $fillable = [
        'order_id',
        'driver_lat',
        'driver_lon',
        'drop_lat',
        'drop_lon',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'order_id' => 'integer',
        'driver_lat' => 'string',
        'driver_lon' => 'string',
        'drop_lat' => 'string',
        'drop_lon' => 'string',
    ];
    
    public function order()
    {
        return $this->belongsTo(\App\Models\Order::class);
    }
}
