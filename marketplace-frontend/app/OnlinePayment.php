<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnlinePayment extends Model
{
    use SoftDeletes;

    public $table = 'online_payments';

    public $fillable = [
        'order_id',
        'amount',
        'status',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'order_id' => 'integer',
        'amount' => 'string',
        'status' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'order_id' => 'required',
        'amount' => 'required',
        'status' => 'required',
    ];

    public function order()
    {
      return $this->belongsTo('App\Order','order_id','id');
    }
}
