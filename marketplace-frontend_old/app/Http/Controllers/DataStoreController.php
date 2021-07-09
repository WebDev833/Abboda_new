<?php

namespace App\Http\Controllers;

use App\Area;
use App\CompanyType;
use App\Searchtag;
use App\Http\Resources\AreaResource;
use App\Http\Resources\CompanyTypeResource;
use App\Http\Resources\SearchtagResource;

class DataStoreController extends Controller
{
    /**
     * List all areas
     */
    public function areaList()
    {
        return AreaResource::collection(Area::where('active', 1)->get());
    }

    /**
     * List all companyTypes
     */
    public function companyTypeList()
    {
        return CompanyTypeResource::collection(CompanyType::where('active', 1)->get());
    }

    /**
     * List all tags available
     */
    public function searchTags()
    {
      //return SearchtagResource::collection(Searchtag::active()->get());
    //  return SearchtagResource::collection(Searchtag::active()->get('name')->pluck('name'));
      return Searchtag::active()->get('name')->pluck('name')->toJson();
    }

}
