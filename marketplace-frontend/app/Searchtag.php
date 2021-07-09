<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Searchtag extends Model
{
   
    use SoftDeletes;

    public $table = 'searchtags';
    
    public $fillable = [
        'name',
        'active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'active' => 'boolean'
    ];

    /**
     * only active tags
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
