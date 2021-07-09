<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcceptOrder extends Model
{
    use SoftDeletes;

    public $table = 'accept_orders';
    
    public $fillable = [
        'order_id',
        'user_id',
        'driver_id',
        'completed',
        'driver_lat',
        'driver_lon',
        'active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'order_id' => 'integer',
        'user_id' => 'integer',
        'driver_id' => 'integer',
        'completed' => 'boolean',
        'driver_lat' => 'string',
        'driver_lon' => 'string',
        'active' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'order_id' => 'required',
        'user_id' => 'required',
        'driver_id' => 'required'
    ];

  public function driver()
  {
    return $this->belongsTo('App\Driver','driver_id','user_id');
  }

}
