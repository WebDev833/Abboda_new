<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Page extends Model implements TranslatableContract
{
   
    use SoftDeletes, Translatable;

    public $translatedAttributes = ['title','slug'];

    public $table = 'pages';
    
    public $fillable = [
         //'title',
         //'slug',
        'static',
        'country_id',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
         'title' => 'string',
         'slug' => 'string',
         'static'=>'integer',
         'country_id'=>'integer',
        'status' => 'boolean'
    ];

    /**
     * Active Scope
     */
    public function scopeStatic($query,$static=0)
    {
        return $query->whereStatic($static);
    }

    public function scopeActive($query,$status=0)
    {
        return $query->whereStatus($status);
    }

    public function sections()
    {
        return $this->belongsToMany('App\Section')
        ->using('App\PageSection')
        ->withTimestamps();
    }
    public function country()
    {

        return $this->belongsTo('App\Country', 'country_id', 'id');
    }

}
