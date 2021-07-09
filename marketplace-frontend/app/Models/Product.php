<?php

namespace App\Models;

use Eloquent as Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Company;
use App\Models\Category;
use App\Cart;
use App\Area;

/**
 * Class Product
 * @package App\Models
 * @version April 20, 2020, 7:22 am UTC
 *
 * @property \App\Models\Company company
 * @property \App\Models\Category category
 * @property integer company_id
 * @property integer category_id
 * @property string name
 * @property string price
 * @property boolean in_stock
 * @property boolean active
 * @property string description
 */
class Product extends Model implements HasMedia
{
    use HasMediaTrait {
        getFirstMediaUrl as protected getFirstMediaUrlTrait;
    }
use SoftDeletes;
    public $table = 'products';
    


    public $fillable = [
        'company_id',
        'category_id',
        'name',
        'price',
        'in_stock',
        'active',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'company_id' => 'integer',
        'category_id' => 'integer',
        'name' => 'string',
        'price' => 'string',
        'in_stock' => 'boolean',
        'active' => 'boolean',
        'description' => 'string',
        'product_image' => 'string'
    ];

    protected $attributes = [
        'in_stock' => 1, 
        'active' => 1, 
    ];

    /**
     * @param Media|null $media
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null)
    {
      
        // for frontend
        $this->addMediaConversion('product')
            ->fit(Manipulations::FIT_CROP, 300, 300);
        
        // For Backend
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 200, 200)
            ->sharpen(10);

        $this->addMediaConversion('icon')
            ->fit(Manipulations::FIT_CROP, 100, 100)
            ->sharpen(10);

    }


    /**
     * to generate media url in case of fallback will
     * return the file type icon
     * @param string $conversion
     * @return string url
     */
    public function getFirstMediaUrl($collectionName = 'default',$conversion = '')
    {
        $url = $this->getFirstMediaUrlTrait($collectionName);
        $array = explode('.', $url);
        $extension = strtolower(end($array));
        if (in_array($extension,config('medialibrary.extensions_has_thumb'))) {
            return asset($this->getFirstMediaUrlTrait($collectionName,$conversion));
        }else{
            return asset(config('medialibrary.icons_folder').'/'.$extension.'.png');
        }
    }

  public function company()
  {
    return $this->belongsTo(Company::class);
  }

  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  public function carts()
  {
    return $this->hasMany(Cart::class);
  }

  public function dp()
  {
      return $this->hasManyThrough(Area::class, Company::class);
  }

}
