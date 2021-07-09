<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models\Product;
use App\Models\Company;
use App\User;

class Cart extends Model
{
    public $table = 'carts';

    public $fillable = [
        'company_id',
        'user_id',
        'product_id',
        'quantity',
    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'company_id' => 'integer',
        'user_id' => 'integer',
        'product_id' => 'integer',
        'quantity' => 'integer',
    ];

    public function company()
    {
      return $this->belongsTo(Company::class);
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function product()
    {
      return $this->belongsTo(Product::class);
    }

}
