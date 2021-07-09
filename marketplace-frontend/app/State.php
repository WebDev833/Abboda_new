<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class State extends Model
{
  use SoftDeletes;

    public $table = 'states';

    protected $fillable = [
        'country_id',
        'name',
        'active',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'country_id' => 'integer',
        'name' => 'string',
        'active' => 'boolean',
    ];
    /**
     * Active Scope
     */
    public function scopeActive($query,$active=1)
    {
        return $query->whereActive($active);
    }
    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public function cities()
    {
        return $this->hasMany('App\City', 'state_id', 'id');
    }

}
