<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

use App\Models\Product;
use App\Models\Category;
use App\Workday;
use App\Area;
use App\City;

class Company extends Model implements HasMedia
{
    use HasMediaTrait {
        getFirstMediaUrl as protected getFirstMediaUrlTrait;
    }
    use SoftDeletes;

    protected $primaryKey = 'id';

    public $table = 'companies';

    public $fillable = [
        'companytype_id',
        'area_id',
        'name',
        'description',
        'email',
        'phone',
        'rating',
        'slug',
        'country',
        'latitude',
        'longitude',
        'address',
        'active',
        'catalog_enabled',
        'parent_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'companytype_id' => 'integer',
        'area_id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'rating' => 'integer',
        'slug' => 'string',
        'latitude' => 'string',
        'longitude' => 'string',
        'address' => 'string',
        'active' => 'boolean',
        'catalog_enabled' => 'boolean',
        'company_image' => 'string',
        'parent_id'=>'integer',
    ];

    protected $attributes = [
        'catalog_enabled' => 0, 
        'active' => 0, 
    ];
    /**
     * Active Scope
     */
    public function scopeActive($query,$active=1)
    {
        return $query->whereActive($active);
    }


    /**
     * @param Media|null $media
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null)
    {
        // For backend
        $this->addMediaConversion('thumb')
        ->fit(Manipulations::FIT_CROP, 200, 200)
        ->sharpen(10);

        $this->addMediaConversion('icon')
        ->fit(Manipulations::FIT_CROP, 100, 100)
        ->sharpen(10);
         
         // For Frontend
        $this->addMediaConversion('banner')
            ->fit(Manipulations::FIT_CROP, 360, 210);

        $this->addMediaConversion('logo')
            ->fit(Manipulations::FIT_CROP, 270, 270);
    }

    /**
     * to generate media url in case of fallback will
     * return the file type icon
     * @param string $conversion
     * @return string url
     */
    public function getFirstMediaUrl($collectionName = 'default', $conversion = '')
    {
        $url = $this->getFirstMediaUrlTrait($collectionName);
        $array = explode('.', $url);
        $extension = strtolower(end($array));
        if (in_array($extension, config('medialibrary.extensions_has_thumb'))) {
            return asset($this->getFirstMediaUrlTrait($collectionName, $conversion));
        } else {
            return asset(config('medialibrary.icons_folder') . '/' . $extension . '.png');
        }
    }

  /**
   * Company - Area
   * @return mixed
   */
  public function area()
  {
    return $this->belongsTo('App\Area');
  }
  
  function locations(){
    return $this->hasMany(Company::class, 'parent_id');
}
  /**
   * Company - Workdays
   * 
   * @return mixed
   */
  public function workdays()
  {
    return $this->hasMany(Workday::class);
  }

  /**
   * Company - products
   * 
   * @return mixed
   */
  public function products()
  {
    return $this->hasMany(Product::class);
  }

  /**
   * Company - categories
   * 
   * @return mixed
   */
  public function categories()
  {
    return $this->hasMany(Category::class);
  }


}
