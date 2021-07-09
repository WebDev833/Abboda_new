<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;




class Tips extends Model implements HasMedia
{
    use HasMediaTrait {
        getFirstMediaUrl as protected getFirstMediaUrlTrait;
    }
    use SoftDeletes;

    protected $primaryKey = 'id';

    public $table = 'tbl_order_tips';

    public $fillable = [
        'id',
        'order_id',
        'tip_payment_method',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'order_id' => 'integer',
        'tip_payment_method' => 'string',
       
    ];

    protected $attributes = [
        'catalog_enabled' => 0,
        'active' => 0,
    ];
}

