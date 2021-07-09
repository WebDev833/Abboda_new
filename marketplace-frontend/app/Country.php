<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;

    public $table = 'countries';

    protected $fillable = [
        'name',
        'currency',
        'language',
        'phonecode',
        'active',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'currency' => 'string',
        'language' => 'string',
        'phonecode' => 'string',
        'active' => 'boolean',
    ];
    /**
     * Active Scope
     */
    public function scopeActive($query,$active=1)
    {
        return $query->whereActive($active);
    }
    public function states()
    {
        return $this->hasMany('App\State', 'country_id', 'id');
    }


}
