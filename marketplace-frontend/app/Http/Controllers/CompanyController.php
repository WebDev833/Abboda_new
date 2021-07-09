<?php

namespace App\Http\Controllers;

use App\Helpers\Front;
use App\Models\Company;
use Exception;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use DB;
use  App\Models\Category;
use DateTime;
use Illuminate\Support\Facades\Http;
use App\Area;


class CompanyController extends Controller
{
    /**
     * Get Products from a collection
     *
     * @param Array $products
     *
     * @return array
     */
    private $maxPageRecords = 21;

    private function getProducts($products = [])
    {
        $proArray = [];
        foreach ($products as $product) {
            $proArray[] = [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'image' => Front::myMediaUrl($product, 'product_image', 'product'),
            ];
        }
        return $proArray;
    }
    public function merhcantcountry(Request $request, $country = null)
    {
        if ($country == null || !$request->is('merchants/*')) {
            // null url or not store page.
            return redirect(route('home'));
        }
        $country_merchants = Company::where(['country'=> $country,'active'=>1])->where('parent_id',0)->with([
            'locations' => function ($q) {
                $q->select('id', 'parent_id','slug','address','latitude','longitude');
            },
            ])->paginate($this->maxPageRecords);

            $companies = new collection();

        foreach ($country_merchants as $company) {
            $companies->push([
                'id' => $company->id,
                'distance'=>$company->distance,
                'latitude'=>$company->latitude,
                'longitude'=>$company->longitude,
                'parent_id'=>$company->parent_id,
                'address'=>$company->address,
                'area_id' => $company->area_id,
                'name' => $company->name,
                'slug' => $company->slug,
                'rating' => intval($company->rating),
                'description' => $company->description,
                'address' => $company->address,
                'image' => Front::myMediaUrl($company, 'company_image', 'banner'),
            ]);
        }
        
            $total= $companies->count();
           
            $pagination=$this->maxPageRecords;
            
            if ($request->ajax()) {
                $companies=$companies->toArray();
                
             
                $view=view('storepanels.country-list-item', compact('companies'))->render();
    
                return response()->json(['html'=>$view]);
                
            }
    
         
            $pageConfigs = [
                'newsletter' => true,
                'breadcrumb' => false,
                'title' => 'Abboda Stores',
            ];
            return view('pages.merchants', [
                'pageConfigs' => $pageConfigs,
                'companies'=>$companies->toArray(),
                'paginate'=>$pagination,
                'total'=> $total
             
                
            ]);

        
    }

    /**
     * Store method - Show store
     *
     * @param Request $request
     * @param String $slug
     *
     * @return mixed
     */

    public function show(Request $request, $slug = null)
    {
        if ($slug == null || !$request->is('store/*')) {
            // null url or not store page.
            return redirect(route('home'));
        }
        try {
            $childorParent = Company::where(['slug'=> $slug,'active'=>1])->firstOrFail();

            $ischild=0;
            
            if ($childorParent->parent_id > 0){ //if is child
                $ischild=1;
                $company = Company::where(['id'=>$childorParent->parent_id,'active'=>1])->firstOrFail();
            }else{
                ///if not child then assign partent to parent as well..
                
                $company=$childorParent;
            }
           
            $categories = $company->categories()->where([
                'active' => 1,
            ])->with([
                'products' => function ($product) {
                    $product->where(['active' => 1])->with('media');
                //
                    // optimize the query by specific column...
                    // $product->select(['id','name','description','price']);
                },
                'media',
            ])->select('id', 'name')->get();
            //company

          
            $Country=Area::addSelect('countries.*')
            ->join('cities', 'cities.id', '=', 'areas.city_id')
            ->join('states', 'states.id', '=', 'cities.state_id')
            ->join('countries', 'countries.id', '=', 'states.country_id')
            ->where('areas.id', '=', $company->area_id)->first();

            $companyArray = [
                'id' => $company->id,
                'acceptingOrders' => Front::workingCompany($company->id),
                'area_id' => $company->area_id,
                'name' => $company->name,
                'slug' => $company->slug,
                'rating' => intval($company->rating),
                'description' => $company->description,
                'address' => $company->address,
                'longitude' => $company->longitude,
                'latitude' => $company->latitude,
                'image' => Front::myMediaUrl($company, 'company_image', 'logo'),
            ];
            // get workdays.
            $workdays = $company->workdays()->select('id', 'day', 'open_time', 'close_time')->get();
            // categories
            $ncats = new Collection();
            foreach ($categories as $category) {
                $ncats->push([
                    'id' => $category->id,
                    'name' => $category->name,
                    'image' => Front::myMediaUrl($category, 'category_image'),
                    'products' => $this->getProducts($category->products),
                ]);
            }




            // ########is close or open store.
            //date_default_timezone_set("US/Arizona");
            //#######
            $time = time();
            //  $response = Http::get('https://maps.googleapis.com/maps/api/timezone/json', [
            //      'location' => $company->latitude.','.$company->longitude,
            //     'timestamp' => $time,
            //     'key' =>env('GOOGLE_MAP_KEY')
            //     ]);

            // $timezonApi=$response->json();


            //date_default_timezone_set("America/New_York");
            // date_default_timezone_set("Asia/Karachi");
            // date_default_timezone_set($timezonApi['timeZoneId']);
            $query= $company->workdays()->select('id', 'day', 'open_time', 'close_time');
            //if($company->area_id !=0 && $Country->name =='Egypt'){
            $query->where('day', date('l'));
            //}
            $todayworkdays =$query->first();


            $is_open = false;
            if ($todayworkdays && ($todayworkdays->open_time !='' && $todayworkdays->close_time !='')) {
                // echo $todayworkdays->open_time."<br>";
                // echo "ok ".$todayworkdays->close_time."<br>";


                $now_time = new DateTime(date('Y-m-d H:i:s'));
                //echo $open_time=date('Y-m-d H:i:s', strtotime($todayworkdays->open_time))."<br>";
                //echo $now_time->format('Y-m-d H:i:s')."<br>";
                //***open time
                $open_time = new DateTime(date('Y-m-d H:i:s', strtotime($todayworkdays->open_time)));
                //echo $open_time=date('Y-m-d H:i:s', strtotime($todayworkdays->open_time))."<br>";
  //echo $open_time->format('Y-m-d H:i:s')."<br>";
  $open_time = strtotime($open_time->format('Y-m-d H:i:s')); //convert to timstamp

  //***Close time
                $close_time = new DateTime(date('Y-m-d H:i:s', strtotime($todayworkdays->close_time)));
                $close_time->modify('+1 day');
                //echo date('Y-m-d H:i:s', strtotime($close_time->format('Y-m-d H:i:s')))."<br>"; //way other
  //echo $close_time->format('Y-m-d H:i:s');
  $close_time = strtotime($close_time->format('Y-m-d H:i:s')); //convert to timstamp
  if ($time > $open_time && $close_time>$time) {
      $is_open = true;
  } else {
      $is_open = false;
  }
            }

            // Complete company
            $workday=$workdays->toArray();
            $store = [
              'company' => $companyArray, // already an array.
              'categories' => $ncats->toArray(),
              'workdays' => $workday,
              'is_open' =>$is_open,
          ];
            ///calculating current store open.
            $pageConfigs = [
                'newsletter' => false,
                'breadcrumb' => false,
                'title' => $company->name, //store page
            ];
          
            return view('pages.store', [
                'pageConfigs' => $pageConfigs,
                'store' => $store,
                'childorParent' => $childorParent,
            ]);
        } catch (Exception $e) {
            //   dd($e);
            //  Marketing Mind :)
            // We can show interactive message here -> like register or refer a restaturant..... like that..
            // For now lets redirect to home..
            return redirect(route('home'));
        }
    }

    /**
     * Search Method - Search based on keyword
     *
     * @param String $keyword
     * @return mixed
     */
    public function search(Request $request)
    {
        $keyword = request()->input('keyword');
        $foodtype = request()->input('foodtype');


        /**
         * we have location - Do some hack here :)
         */
        if (Session::has('deliverydetails.address') && Session::has('deliverydetails.lat')) {
            $latitude=Session::get('deliverydetails.lat');
            $longitude=Session::get('deliverydetails.lon');
            $dist='front_resturant_distance_limit:'.\App::getLocale();
            $dist = config('roms.frontSettings.'.$dist); // This is the maximum distance (in miles) away from $origLat, $origLon in which to search
        //below query calcalating if distance is b/w store and customer 5 mile or less then show that resturant.
        } else {
            return redirect()->route('home')->withErrors(['You must enter delivery address!']);
        }

        /*
                * using eloquent approach, make sure to replace the "Restaurant" with your actual model name
                * replace 6371000 with 6371 for kilometer and 3956 for miles
                */
        $query = Company::addSelect(
            ['id'=>'companies.id','name'=>'companies.name','rating'=>'companies.rating','parent_id'=>'companies.parent_id'
            ,'slug'=>'companies.slug','distance'=>DB::raw('(SELECT (3956 * 2 * ASIN(SQRT( POWER(SIN(( '.$latitude.' - latitude) *  pi()/180 / 2), 2) + COS( '.$latitude.' * pi()/180) * COS(latitude * pi()/180) * POWER(SIN(( '.$longitude.' - longitude) * pi()/180 / 2), 2) ))) as distance FROM `companies` as c WHERE `c`.`id` = `companies`.`id`) AS distance')
          
          ]
          )->join("categories",function($join){
            $join->on("categories.company_id","=","companies.id")
                ->oron("categories.company_id","=","companies.parent_id");
        })
        // )->join('categories', 'categories.company_id', '=', 'companies.id')
      ->join('products', 'products.category_id', '=', 'categories.id')
      ->where([
            'companies.active' => 1,
        ]);
        $query->where(function ($query) use ($keyword) {
            if (!empty($keyword)) {
                $query->orwhere('companies.name', 'like', '%' . $keyword . '%');
                $query->orwhere('categories.name', 'like', '%' . $keyword . '%');
                $query->orwhere('products.name', 'like', '%' . $keyword . '%');

//          return $query->whereLike(['companies.name','products.name','categories.name'],$keyword);
            }
           
            return $query;
        });

        ///food types conditions
        $query->where(function ($query) use ($foodtype) {
            if (!empty($foodtype)) {
                foreach ($foodtype as $key => $type) { //list selected type
                    $foodkeywords=config('roms.foodtypes:'.\App::getLocale().'.'.$type);
                    //get keywords for seleced type.
                    $foodkeywords=explode(',', $foodkeywords['keywords']);
                    foreach ($foodkeywords as $keywords) { //apply filter onf the keyword
                        $query->orwhere('companies.name', 'like', '%' . $keywords . '%');
                        $query->orwhere('categories.name', 'like', '%' . $keywords . '%');
                        $query->orwhere('products.name', 'like', '%' . $keywords . '%');
                        //$query->whereLike(['name','address','products.name','categories.name'],$keywords);
                    }
                }
                return $query;
            } else { //if no type select
                return $query;
            }
        });

        $query->having('distance', '<=', $dist)
      
      
         ->groupBy('companies.name'); ///here checking the distance for getting resturants.
        // ->groupBy('companies.id', 'companies.name', 'companies.rating', 'companies.slug', 'distance','companies.parent_id'); ///here checking the distance for getting resturants.

        $query->with('media');
        $compQuery=$query->orderBy('distance', 'asc')->paginate($this->maxPageRecords);
        $islocation=false;
        $count = count($compQuery);

   if(!empty($keyword) && $count == 0){

    $query = Company::addSelect(
        ['id'=>'companies.id','name'=>'companies.name','rating'=>'companies.rating','parent_id'=>'companies.parent_id'
        ,'slug'=>'companies.slug'
      
      ]
      )->join("categories",function($join){
        $join->on("categories.company_id","=","companies.id")
            ->oron("categories.company_id","=","companies.parent_id");
    })

  ->join('products', 'products.category_id', '=', 'categories.id')
  ->join('companies as c', 'c.parent_id', '=', 'companies.id')
  ->where([
        'companies.active' => 1,
        'companies.parent_id' => 0,
    ]);


    $query->where(function ($query) use ($keyword) {
        if (!empty($keyword)) {
            $query->orwhere('companies.name', 'like', '%' . $keyword . '%'); 
        }
       
        return $query;
    });

    $query->groupBy('companies.name');    
    $query->with('media');
    $compQuery=$query->paginate($this->maxPageRecords);

  $islocation=true;

   }
        //->limit(20)->toSql();
        //echo      $compQuery=$query->orderBy('id', 'desc')->toSql();
        //die();
        //
      
        // dd($compQuery);


        
        $companies = new collection();

        foreach ($compQuery as $company) {
            $companies->push([
                'id' => $company->id,
                'distance'=>$company->distance,
                'latitude'=>$company->latitude,
                'longitude'=>$company->longitude,
                'parent_id'=>$company->parent_id,
                'address'=>$company->address,
                'area_id' => $company->area_id,
                'name' => $company->name,
                'slug' => $company->slug,
                'rating' => intval($company->rating),
                'description' => $company->description,
                'address' => $company->address,
                'image' => Front::myMediaUrl($company, 'company_image', 'banner'),
            ]);
        }
        
       
        if ($request->ajax()) {
            $companies=$companies->toArray();
            
            $view=view('storepanels.store-list-item', compact('companies','islocation'))->render();

            
            return response()->json(['html'=>$view]);
        }

        $pageConfigs = [
            'newsletter' => true,
            'breadcrumb' => true,
            'title' => 'Search results',
        ];
        $foodtypes=config('roms.foodtypes:'.\App::getLocale());
    
        return view('pages.search-results', [
            'pageConfigs' => $pageConfigs,
            'companies' => $companies->toArray(),
            'total'=> $compQuery->total(),
            'compQuery'=>$compQuery,
            'foodtypes'=>$foodtypes,
            'islocation' =>$islocation
        ]);
    }

    public function showlocations(Request $request, $slug = null)
    {
        if ($slug == null || !$request->is('locations/*')) {
            // null url or not store page.
            return redirect(route('home'));
        }

     
        $location = Company::where(['slug'=> $slug,'active'=>1])->with([
            'locations' => function ($q) {
                $q->select('id', 'parent_id','slug','address','latitude','longitude');
            },
            ])->firstOrFail();
            $workdays = $location->workdays()->select('id', 'day', 'open_time', 'close_time')->get();

            $workday=$workdays->toArray();
        
        $pageConfigs = [
            'newsletter' => true,
            'breadcrumb' => true,
            'title' => 'Search results',
        ];

        return view('pages.locations', [
            'pageConfigs' => $pageConfigs,
            'companies'=>$location,
            'workdays'=>$workday
        ]);
    }
}