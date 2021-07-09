<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Widget extends Model
{
    use SoftDeletes,  HasTranslations;
    
    public $table = 'widgets';

    public $translatable = ['body'];

    public $fillable = [
        'unique_key',
        'body',
        'status',
        'static',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'unique_key' => 'string',
        'body' => 'string',
        'status' => 'boolean',
        'static' => 'boolean',
    ];

    protected $attributes = [
        'static' => 0, // 0 - Default all widgets
    ];

    /**
     * Static Scope
     */
    public function scopeStatic($query,$type=0)
    {
        return $query->where('static',$type);
    }


    /**
     * Static Scope
     */
    public function scopeActive($query,$type=0)
    {
        return $query->where('status',$type);
    }
    

}
