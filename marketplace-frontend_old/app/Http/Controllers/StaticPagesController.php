<?php

namespace App\Http\Controllers;

//use Auth;
use App\Helpers\Front;
use App\Models\Company;
use App\Workday;
use Illuminate\Http\Request;

use Illuminate\Support\Collection;

use Config;
use Session;

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

    public function switchLanguage($lang = null)
    {
        if(in_array($lang,['en','ar']))
        {
          Session::put('language',$lang);
        }
        return redirect()->back();
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
        ];
        return view('pages.homepage', ['pageConfigs' => $pageConfigs]);
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
    public function allRestaurants()
    {
        $compQuery = Company::where([
            'active' => 1,
            'companytype_id' => 1, // restaurants
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
            'title' => 'Abboda Restaurants',
        ];
        return view('pages.restaturants', [
            'pageConfigs' => $pageConfigs,
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
