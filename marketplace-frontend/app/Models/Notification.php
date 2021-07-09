<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model 
{
    
    use SoftDeletes;

    protected $primaryKey = 'id';

    public $table = 'notifications';

    public $fillable = [
        'type',
        'message',
        'seen',
        'orderid',
        'userid',
        'title'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'type' => 'integer',
        'title' => 'string',
        'message' => 'string',
        'seen' => 'integer',
        'orderid' => 'integer',
        'userid' => 'integer',
    ];

    /**
     * Seen Scope
     */
    public function scopeActive($query,$seen=1)
    {
        return $query->whereSeen($seen);
    }

}
