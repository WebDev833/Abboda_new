<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use SoftDeletes;

    public $table = 'order_items';

    public $fillable = [
        'order_id',
        'product_id',
        'name',
        'quantity',
        'price',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'order_id' => 'integer',
        'product_id' => 'integer',
        'name' => 'string',
        'quantity' => 'string',
        'price' => 'string',
    ];

    public function order()
    {
      return $this->belongsTo('App\Order');
    }
    
}
