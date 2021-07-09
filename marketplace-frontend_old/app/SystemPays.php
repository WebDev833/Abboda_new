<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemPays extends Model
{

    use SoftDeletes;

    public $table = 'system_pays';

    public $fillable = [
        'sender_id',
        'receiver_id',
        'amount',
        'paid',
        'received',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'sender_id' => 'integer',
        'receiver_id' => 'integer',
        'amount' => 'float',
        'paid' => 'boolean',
        'received' => 'boolean',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'sender_id' => 'required',
        'receiver_id' => 'required',
        'amount' => 'required',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * One who sent the money.
     */
    public function sender()
    {
        return $this->hasOne('App\User','id','sender_id');
    }

    /**
     * One who received the money.
     */
    public function receiver()
    {
        return $this->hasOne('App\User','id','receiver_id');
    }

}
