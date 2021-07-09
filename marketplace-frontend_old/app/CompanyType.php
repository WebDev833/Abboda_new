<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyType extends Model
{
    use SoftDeletes;

    public $table = 'company_types';

    public function scopeActive($q,$status=1)
    {
      $q->whereActive($status);
    }
}
