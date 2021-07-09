<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;

    public $table = 'cities';

    protected $fillable = [
        'name',
        'state_id',
        'region_bounds',
        'active',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'state_id' => 'integer',
        'region_bounds' => 'string',
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

  public function state()
  {
      return $this->belongsTo('App\State');
  }

  

}
