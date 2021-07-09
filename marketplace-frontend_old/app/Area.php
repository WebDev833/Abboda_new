<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use SoftDeletes;

    public $table = 'areas';

    protected $fillable = [
        'city_id',
        'name',
        'active',
    ];
    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'city_id' => 'integer',
        'name' => 'string',
        'active' => 'boolean',
    ];

    public function areamanager()
    {
      return $this->hasOne('App\AreaManager');
    }

    public function merchants()
    {
        return $this->hasMany('App\Models\Company', 'area_id', 'id');
    }


}
