<?php

namespace App\Http\Controllers;

use App\Helpers\Front;
use Illuminate\Support\Str;

class SuperdevController extends Controller
{

    public function index()
    {
        //Artisan::call('route:call',['uri'=>'']);

    }
//  mediaRel($mdiaUrl,$uploadId,$collectionName,$relModel)
    public function dashboard()
    {
      // import the data
        Artisan::call('wsg:areaimporter');
        Artisan::call('wsg:categoryimporter');
        Artisan::call('wsg:companyimporter');
        Artisan::call('wsg:productimporter');
        Artisan::call('wsg:workdayimporter');
    }

    /**
     *
     * Bulk Upload Companies
     *
     * */
    public function bulkUploadCompanies()
    {

    }

}
