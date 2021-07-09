<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderPayment extends Model
{
    use SoftDeletes;

    public $table = 'order_payments';

    public $fillable = [
        'order_id',
        'payment_type',
        'amount',
        'system_amount',
        'driver_amount',
        'item_costs',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'order_id' => 'integer',
        'payment_type' => 'integer',
        'amount' => 'string',
        'system_amount' => 'string',
        'driver_amount' => 'string',
        'item_costs' => 'string',
    ];

  public function order()
  {
    return $this->belongsTo('App\Order');
  }


}
