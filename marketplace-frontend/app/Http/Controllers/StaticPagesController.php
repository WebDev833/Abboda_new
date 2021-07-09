<?php

namespace App\Http\Controllers;

//use Auth;
use App\Helpers\Front;
use App\Models\Company;
use App\Workday;
use Illuminate\Http\Request;

use Illuminate\Support\Collection;
use App\Page;
use App\Section;
use App\Country;
use Config;
use Session;
use App;
use DB;
class StaticPagesController extends Controller
{
/*
public function authenticateMs()
{
// admin attempt
// $attamp = Auth::attempt(['email' => 'admin@demo.com', 'password' => '123456','user_type'=> [2]]);
// user attemp
// $attamp = Auth::attempt(['email' => 'frontclient@gmail.com', 'password' => 'frontclient','user_type'=> [4,5]]);

// driver attempt
$attamp = Auth::attempt(['email' => 'driverfront@gmail.com', 'password' => 'driverfront','user_type'=> [4,5]]);
if($attamp)
{
//return redirect()->intended('dashboard');
dd(Auth::user());
} else
{
dd('Error credentials.... ');
}
}
 */
private $maxPageRecords = 20;
    public function switchLanguage($lang = null)
    {
        if(in_array($lang,['en','ar']))
        {
          Session::put('language',$lang);
        }
        return redirect()->back();
    }

    /**
     *show page
     */
   public function showpage(Request $request, $slug = null){

       if ($slug == null ) {
            // null url or not any page. 
           abort(404);
        }
      
      $country_id=2; ///default set
      if($request->has('country')){
        $country_id=$request->get('country');
      }

      $page = Page::whereHas('translations', function ($query) use ($slug) {
            $query->where('slug', $slug);
            //where('locale', Session::get('language'))
        })->Where(function($query) use ($country_id) {
                $query->where('country_id',$country_id)->orwhere('country_id',0);
            })->first();

      if($page){
        $sections = $page->sections()->get();
        $countries = Country::orderBy('id', 'DESC')
            ->get();
        //echo $sections[0]->translate('ar')->content;
        //print_r(count($sections));
        //exit();
        $pageConfigs = [
            'newsletter' => true,
            'breadcrumb' => true,
            'title' => $page->translate(App::getLocale())->title,
            'page'=>$page,
            'sections'=>$sections,
            'countries'=>$countries->pluck('name','id'),
            'country_id'=>$country_id
        ];
        return view('pages.page-template', ['pageConfigs' => $pageConfigs]);
        //echo $page->slug;
        //echo "<pre>";
       //print_r($sectionIds[0]);

      }else{
         abort(404);
      }
   }


    /**
     *
     */
    public function homePage()
    {
      // for devvvv..... 
      
        if(!Session::has('location'))
        {
          Session::put([
            'address' => '16 Saray El, Gezira St, Zamalek, Cairo Governorate 11211, Egypt',
            'lat' => '29.5641789', // 29.5641789,32.7699668
            'lon' => '32.7699668', //31.9097892,76.0376114
          ]);
        }

        $pageConfigs = [
            'newsletter' => false,
            'breadcrumb' => false,
            'title' => 'Home Page',
            'page'=>0,
            'sections'=>0
        ];

       $page = Page::whereHas('translations', function ($query) {
            $query->where('locale', App::getLocale())
            ->where('slug', 'home');
        })->where('status',1)->first();
        
      if($page){
        $sections = $page->sections()->get();
        $pageConfigs['page']=$page;
        $pageConfigs['sections']=$sections;
       }

        return view('pages.homepage', [
          'pageConfigs' => $pageConfigs,
          ]);
        // return view('pages.homepage');
    }

    /**
     *
     */
    public function aboutUs()
    {
        $pageConfigs = [
            'newsletter' => true,
            'breadcrumb' => true,
            'title' => 'About Us',
        ];
        return view('pages.aboutus', ['pageConfigs' => $pageConfigs]);
    }

    /**
     *
     */
    public function contactUs()
    {
        $pageConfigs = [
            'newsletter' => true,
            'breadcrumb' => true,
            'title' => 'Contact Us',
        ];
        
        return view('pages.contact', ['pageConfigs' => $pageConfigs]);
    }

    /**
     * allRestaurants
     * 
     * used : true 
     */
    public function allRestaurants($type='American-Food')
    {

      if(Session::has('deliverydetails.address'))
      {

       $latitude=Session::get('deliverydetails.lat');
        $longitude=Session::get('deliverydetails.lon');
        $dist='front_resturant_distance_limit:'.\App::getLocale();
        $dist = config('roms.frontSettings.'.$dist); // This is the maximum distance (in miles) away from $origLat, $origLon in which to search
        //below query calcalating if distance is b/w store and customer 5 mile or less then show that resturant.
      }else{
        return redirect()->route('home')->withErrors(['You must enter delivery address!']);
      }
  //am_food
      $Am_food=Front::GetNearbyResturants($latitude,$longitude,$dist,$type);
  //Mexican_food
     // $Mexican_food=Front::GetNearbyResturants($latitude,$longitude,$dist,'Mexican-Food');
  //Indian_food
      //$Indian_food=Front::GetNearbyResturants($latitude,$longitude,$dist,'Indian-Food');

  //you_may_food
      $you_maylike_food=Front::GetNearbyResturants($latitude,$longitude,$dist,'',['customer_may_like'=>'You-may-also-like']);

//dd($you_maylike_food);
  $companies = new collection();

        foreach ($Am_food as $company) {

            $companies->push([
                'id' => $company->id,
                'distance'=>$company->distance,
                'latitude'=>$company->latitude,
                'longitude'=>$company->longitude,
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


        $pageConfigs = [
            'newsletter' => true,
            'breadcrumb' => false,
            'title' => 'Abboda Restaurants',
        ];
        return view('pages.restaturants', [
            'pageConfigs' => $pageConfigs,
            //'companies' => $companies->toArray(),
            'foodtype'=>$type,
            //'reurtant_am_food'=>$Am_food,
            //'reurtant_Mexican_food'=>$Mexican_food,
            //'reurtant_Indian_food'=>$Indian_food,
            'you_maylike_food'=>$you_maylike_food,
            'companies' => $companies->toArray(),
        ]);
    }
    /**
     * allGroceryStores
     * 
     * used : true 
     */
    public function allGroceryStores()
    {
        $compQuery = Company::where([
            'active' => 1,
            'companytype_id' => 3, // grocery stores
        ])->get();

        $companies = new collection();
        foreach ($compQuery as $company) {
            $companies->push([
                'id' => $company->id,
                'area_id' => $company->area_id,
                'name' => $company->name,
                'slug' => $company->slug,
                'rating' => intval($company->rating),
                'description' => $company->description,
                'address' => $company->address,
                'image' => Front::myMediaUrl($company, 'company_image', 'banner'),
            ]);
        }
        //  dd($companies);

        $pageConfigs = [
            'newsletter' => true,
            'breadcrumb' => true,
            'title' => 'Abboda Grocery Stores',
        ];
        return view('pages.grocerystores', [
            'pageConfigs' => $pageConfigs,
            'companies' => $companies->toArray(),
        ]);
    }
    /**
     * allMedicalStores
     * used : true
     */
    public function allMedicalStores()
    {
        $compQuery = Company::where([
            'active' => 1,
            'companytype_id' => 3, // medical stores
        ])->get();

        $companies = new collection();

        foreach ($compQuery as $company) {
            $companies->push([
                'id' => $company->id,
                'area_id' => $company->area_id,
                'name' => $company->name,
                'slug' => $company->slug,
                'rating' => intval($company->rating),
                'description' => $company->description,
                'address' => $company->address,
                'image' => Front::myMediaUrl($company, 'company_image', 'banner'),
            ]);
        }
        //  dd($companies);

        $pageConfigs = [
            'newsletter' => true,
            'breadcrumb' => true,
            'title' => 'Abboda Medical Stores',
        ];
        return view('pages.medicalstores', [
            'pageConfigs' => $pageConfigs,
            'companies' => $companies->toArray(),
        ]);
    }

    /**
     * Store -> Will change in future.
     *
     * @depricated : true
     */
    public function myStore()
    {

        $pageConfigs = [
            'newsletter' => true,
            'breadcrumb' => true,
            'title' => 'Store Page',
        ];
        return view('pages.store', ['pageConfigs' => $pageConfigs]);
    }


    public function myTestPage()
    {
      /**
       * count of company where company id = 5 
       * and day = given day 
       * and close_time < given time.
       */
      // working hours check. 
      /*
      dd([
        'time'=> date('H:i'), // time in 24 hour format.
        'day'=> strtolower(date('l')), // Full day name inlowercase. 
        ]);
        */
        /*
       $query = Workday::has('company')
       ->where('company_id',5)
       ->where('day',5)
       ->where('close_time',5)->get();
       dd($query->toSql());
       */
    }


}
