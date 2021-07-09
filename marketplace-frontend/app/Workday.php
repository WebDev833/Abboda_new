<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models\Company;

class Workday extends Model
{

    public $table = 'workdays';

    public $fillable = [
        'company_id',
        'day',
        'open_time',
        'close_time',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'company_id' => 'integer',
        'day' => 'string',
        'open_time' => 'string',
        'close_time' => 'string',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

}
