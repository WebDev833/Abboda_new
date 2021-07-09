<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    public $table = 'orders';

    public $fillable = [
        'unique_order_id',
        'area_id',
        'orderstatus_id',
        'company_id',
        'user_id',
        'total',
        'address',
        'note',
        'payment_method',
        'journey_kms',
        'service_fee',
        'shipping_charges',
        'tip_amount	',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'unique_order_id' => 'string',
        'area_id' => 'integer',
        'orderstatus_id' => 'integer',
        'company_id' => 'integer',
        'user_id' => 'integer',
        'total' => 'string',
        'address' => 'string',
        'note' => 'string',
        'payment_method' => 'integer',
        'journey_kms' => 'float',
        'service_fee' => 'float',
        'shipping_charges' => 'float',
        'tip_amount	'=>'float',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function orderstatus()
    {
        return $this->belongsTo('App\OrderStatus');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
    public function tips()
    {
        return $this->belongsTo('App\Models\Tips','id','order_id');
    }

    public function area()
    {
        return $this->belongsTo('App\Area');
    }

    public function orderitems()
    {
        return $this->hasMany('App\OrderItem');
    }
    
    // must have an driver : who completed the Order?


    public function ordergps()
    {
        return $this->hasOne('App\OrderGps');
    }

    /**
     * Many becouse - to track the order cancelations.
     */
    public function acceptorder()
    {
        return $this->hasMany('App\AcceptOrder');
    }

    public function payment()
    {
      return $this->hasOne('App\OrderPayment');
    }

    public function settlement()
    {
      return $this->hasOne('App\Settlement');
    }
    
    public function onlinepayment()
    {
      return $this->hasOne('App\OnlinePayment');
    }


}
