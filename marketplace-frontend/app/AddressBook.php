<?php

/**
 * 
 * Added by Aimfox IT Solutions
 * https://aimfox.net
 * 
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddressBook extends Model
{
    protected $fillable = ['user_id','latitude','longitude','map_address','street','floor_unit','notes','label','active'];
    protected $table = 'address_book';
}
