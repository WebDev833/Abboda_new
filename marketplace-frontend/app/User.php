<?php

namespace App;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
//use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements HasMedia
{
    //use Notifiable;
    use SoftDeletes;
    use HasMediaTrait {
        getFirstMediaUrl as protected getFirstMediaUrlTrait;
    }

    protected $connection = 'mysql';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'api_token',
        'password',
        'device_token',
        'user_type',
        'longitude',
        'latitude',
        'isOnline',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'api_token' => 'string',
        'password' => 'string',
        'user_type' => 'integer',
        'device_token' => 'integer',
        'user_image' => 'string',
    ];

    protected $attributes = [
        'user_type' => 5, // 5 - For Client
    ];

    /**
     * @param Media|null $media
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(\Spatie\MediaLibrary\Models\Media $media = null)
    {
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


    public function identities()
    {
        return $this->hasMany('App\SocialIdentity');
    }

    /**
     * Basically one with multiple cart items :)
     */
    public function carts()
    {
        return $this->hasMany('App\Cart');
    }

    public function driverprofile()
    {
        return $this->hasOne('App\Driver');
    }

    public function areamanagers()
    {
        return $this->hasMany('App\AreaManager');
    }

    /* System Pays Driver */
    /**
     * Which I have received.
     */
    public function borrows()
    {
      return $this->hasMany('App\SystemPays','receiver_id','id');
    }

    /**
     * Which I have paid.
     */
    public function carryforwards()
    {
      return $this->hasMany('App\SystemPays','sender_id','id');
    }


    public function userType($user_type)
    {
        return boolval($this->user_type == $user_type);
    }

    /** Get name */
    public function getName()
    {
        return $this->name;
    }

    /** Get Email */
    public function getEmail()
    {
        return $this->email;
    }

    /** Get Phone */
    public function getPhone()
    {
        return $this->phone;
    }

    /** Get UserType */
    public function getUserType()
    {
        return $this->user_type;
    }

    /** Get user Carts count */
    public function getCartCount()
    {
        return ($count = $this->carts()->count()) ? $count : 0;
    }

    /**
     * user Scope
     */
    public function scopeType($query,$type=5)
    {
        return $query->where('user_type',$type);
    }



}
