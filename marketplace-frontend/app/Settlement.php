<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Settlement extends Model
{
    use SoftDeletes;

    
    public $table = 'settlements';
    


    public $fillable = [
        'order_id',
        'settler_id',
        'received'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'order_id' => 'integer',
        'received' => 'boolean'
    ];




    /**
     * Order relation
     */
    public function settler()
    {
      return $this->belongsTo('App\User','settler_id','id');
    }

    /**
     * Order relation
     */
    public function order()
    {
      return $this->belongsTo('App\Order');
    }
}
