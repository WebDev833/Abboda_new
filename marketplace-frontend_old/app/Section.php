<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Section extends Model implements TranslatableContract
{
   
    use SoftDeletes, Translatable;
    
    public $translatedAttributes = ['content'];

    public $table = 'sections';
    
    public $fillable = [
        'name',
        'status',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'status' => 'boolean'
    ];
    
    /**
     * Model accessor properties
     */
    protected $appends = [
      'unique_name',
      ];

    /**
     * Accessor Attribute
     */
    public function getUniqueNameAttribute()
    {
         $name = Str::slug("{$this->id} {$this->name}");
         return '#'.$name;
    }

    /**
     * Scopes
     */
    
    /**
     * Active Scope
     */
    public function scopeActive($query)
    {
        return $query->whereStatus(1);
    }


    public function pages()
    {
        return $this->belongsToMany('App\Page')
        ->using('App\PageSection')
        ->withTimestamps();
    }    
}
