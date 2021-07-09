<?php

namespace App\Helpers;

use Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Page;
use App\Widget;
use App\Section;
use App\Models\Company;
use App\Order;
use DB;
use Mail;
use App\Models\Notification;

use Illuminate\Support\Facades\Auth;
class Front
{   


    
    public static function notificationLog($message='',$type=0,$order_id=0,$user_id,$title=''){

      $notify = new Notification;
      $notify->message = $message;
      $notify->type = $type;
      $notify->order_id = $order_id;
      $notify->user_id = $user_id;
      $notify->title = $title;
      $notify->save();
    }

    public static function SendNotification(){
        $user='';
        Mail::send('emails.order', ['user' => 'taleem'], 
          function ($m) use ($user) {
            $m->from(env('MAIL_FROM_ADDRESS', 'info@abboda.com'), env('APP_NAME', 'Abboda'));
            $m->to('taleem35@gmail.com','taleem')->subject('Abboda First email');
        });

        die('email sent');

    }
    public static function frontSettings()
    {
        $data = config('roms.custom');

        $frontSettings = [
            'newsletter' => $data['newsletter'],
            'breadcrumb' => $data['breadcrumb'],
            'title' => $data['title'],
        ];

        //return $frontSettings;
        return $data;
    }
    public static function IsactiveOrder($user_id,$Usertypeid,$orderId=0)
    {
        $orders=[];
        if($Usertypeid ==4){

            $query = Order::whereIn('orderstatus_id',[6,7]);
            if($orderId >0){
              $query->where('id','=',$orderId);
            }

            $orders=$query->whereHas('acceptorder',function($q)  use ($user_id){
                  $q->where('driver_id',$user_id);
                  $q->where('active',1);
                 })->get();

        }elseif ($Usertypeid == 5) {
           
            $query = Order::whereIn('orderstatus_id',[1,2,6,7])->where('user_id','=',$user_id);
            if($orderId > 0){
              $query->where('id','=',$orderId);
            }
            $orders=$query->get();
        }
       return count($orders);
    }

    public static function Menu()
    {
        $pages = Page::static(0)->active(2)
            ->orderBy('id', 'DESC')
            ->select('*') // will optimize
            ->get();

        return $pages;
    }
    
    public static function datetimeDiffrance($startdatetime,$enddateime,$diffranceIn){

        $startdatetime = new \Carbon\Carbon($startdatetime);
        if(empty($enddateime)){
          $enddateime =  \Carbon\Carbon::now();
        }
        switch ($diffranceIn) {
          case 'Seconds':
           return $startdatetime->diffInSeconds($enddateime);
            break;
          case 'Hours':
          return  $startdatetime->diffInHours($enddateime);
            break;
          case 'Minutes':
            return $startdatetime->diffInMinutes($enddateime);
            break;
          default:
            return $startdatetime->diffInDays($enddateime);
        }
      
    }
    public static function GetWidget($widgetId)
    {
        $widget = Widget::active(1)->where('unique_key',$widgetId)
            ->first();
            //$widget->getTranslation('body','en')
        return $widget;
    }
    
    public static function GetNearbyResturants($latitude,$longitude,$dist,$foodtype='',$option=[])
    {
        
        $query = Company::addSelect(
            ['id'=>'companies.id','name'=>'companies.name','rating'=>'companies.rating'
            ,'slug'=>'companies.slug','distance'=>DB::raw('(SELECT (3956 * 2 * ASIN(SQRT( POWER(SIN(( '.$latitude.' - latitude) *  pi()/180 / 2), 2) + COS( '.$latitude.' * pi()/180) * COS(latitude * pi()/180) * POWER(SIN(( '.$longitude.' - longitude) * pi()/180 / 2), 2) ))) as distance FROM `companies` as c WHERE `c`.`id` = `companies`.`id`) AS distance')          
          ])->join('categories', 'categories.company_id', '=', 'companies.id');
      $query->join('products', 'products.category_id', '=','categories.id');
    

    if (Auth::user())
     {

        $compnayids=Order::select('company_id')->where('user_id','=',Auth::user()->id)->get();
        $userproduct=Order::select('order_items.name as p_name','categories.name as c_name')
            ->join('categories','categories.company_id', '=','orders.company_id')
            ->join('products','products.category_id', '=','categories.id')
            ->join('order_items','order_items.product_id','=','products.id')
            ->where('orders.user_id','=',Auth::user()
                ->id)->groupBy('p_name','c_name')->get();
            //unique category name
$cat_name  = collect( $userproduct->pluck('c_name') )->unique();
             //uniq product name
$Product_name  = collect( $userproduct->pluck('p_name') )->unique();
            //merge both array
$userproducts=array_merge($Product_name->toArray(),$cat_name->toArray());

//dd($userproducts->pluck('p_name','c_name')->implode(','));
    if(count($option) && isset($option['customer_may_like']))
    {
    $query->where(function($query) use ($compnayids,$userproducts){
        $query->orWhereIn('companies.id',$compnayids->pluck('company_id'));
        $query->orWhereIn('categories.name',$userproducts);
        $query->orWhereIn('products.name',$userproducts);
         return $query;
         });
        }//if option
    }//if login
      $query->where([
            'companies.active' => 1,
            'companies.companytype_id' => 1, // restaurants
        ]);
      
       $query->where(function($query) use ($foodtype){
          
          if(!empty($foodtype))  
          {
             $foodkeywords=config('roms.foodtypes:'.\App::getLocale().'.'.$foodtype);
                //get keywords for seleced type.
                    $foodkeywords=explode(',',$foodkeywords['keywords']);
                    foreach ($foodkeywords as $keywords) { //apply filter onf the keyword
                    $query->orwhere('companies.name', 'like', '%' . $keywords . '%');
                    $query->orwhere('categories.name', 'like', '%' . $keywords . '%');
                    $query->orwhere('products.name', 'like', '%' . $keywords . '%');
//$query->whereLike(['name','address','products.name','categories.name'],$keywords);
          }
            return $query;
          }else{ //if no type select
              return $query;
            }
          });
        $query->having('distance','<=',$dist) ->groupBy('companies.id','companies.name','companies.rating','companies.slug','distance'); ///here checking the distance for getting resturants.
        $compQuery=$query->orderBy('distance', 'asc')->paginate(12);

        return $compQuery;
    }
    
    

    public static function updatePageConfig($pageConfigs)
    {
        $demo = 'custom';
        if (isset($pageConfigs)) {
            if (count($pageConfigs) > 0) {
                foreach ($pageConfigs as $config => $val) {
                    Config::set('roms.' . $demo . '.' . $config, $val);
                }
            }
        }
    }

    public static function topAreaList()
    {
        return app('App\Http\Controllers\DataStoreController')->areaList();
    }

    public static function topCompanyTypeList()
    {
        return app('App\Http\Controllers\DataStoreController')->companyTypeList();
    }

    /**
     *  used in media model
     */
    public static function formatedSize($bytes, $precision = 1)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Used in upload to uuid
     */
    public static function myUploadId()
    {
        // out format - xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $p1 = substr(str_shuffle($permitted_chars), 0, 8);
        $p2 = substr(str_shuffle($permitted_chars), 0, 4);
        $p3 = substr(str_shuffle($permitted_chars), 0, 3);
        $p4 = substr(str_shuffle($permitted_chars), 0, 4);
        $p5 = substr(str_shuffle($permitted_chars), 0, 12);

        return $p1 . '-' . $p2 . '-4' . $p3 . '-' . $p4 . '-' . $p5;
    }

    public static function myStats()
    {
        return self::myUploadId();
    }

    /**
     *
     * Media Relation for importer
     *
     */
    public static function relateMedia($mediaUrl, $collectionName, $relModel)
    {
        try {
            $upObj = new \App\Models\Upload;
            $upObj->uuid = self::myUploadId(); // get uuid
            
            $upObj->save();

            $upObj->addMedia($mediaUrl)
                ->withCustomProperties(['uuid' => $upObj->uuid])
                ->toMediaCollection($collectionName);
           // $upObj->addMediaFromUrl($mediaUrl) //  Full Url
           //     ->withCustomProperties(['uuid' => $upObj->uuid])
            //    ->toMediaCollection($collectionName);
            $media = $upObj->getMedia($collectionName)->first();
            $media->copy($relModel, $collectionName);
            return true;
        } catch (\Exception $e) {
          print_r($e->getMessage());

            //Log::error($e->getMessage());
            return false;
        }
    }

    /**
     * Convert text to slug
     */

    public static function mySlugify($title = '', $separater = '-')
    {
        return Str::slug($title, $separater);
    }

    /**
     *
     */

    public static function myMediaUrl($model, $collection = '', $conversion = 'icon')
    {
        if ($model->hasMedia($collection)) {
            return $model->getFirstMediaUrl($collection, $conversion);
        }
        return '';
    }

    /**
     * Cart Price total
     */

    public static function myCartItemTotal($price = 0, $qty = 1)
    {
        return self::myPriceRound($price * $qty);
    }

    /**
     * price round core. :)
     */

    public static function myPriceRound($price)
    {
      return (round($price,2));
      //  return number_format($price, 2, '.', ',');
    }

    /**
     * Company accepting order or not.
     * Check current company id close time is greater then now?
     *
     * @param $id integer
     *
     * @return bool
     */

    public static function workingCompany($id = 0)
    {
      
        $working = \App\Workday::whereHas('company', function ($q) {
            $q->where('active', 1);
            $q->select('id');
        })
            ->where('company_id', $id)
            ->where('day', strtolower(date('l')))
            ->where('close_time', '>', date('H:i:s'))
            ->count('id');
        return ($working) ? true : false;
        
    }

    /**
     * calculate distance between company and given location
     * used : true 
     */
    public static function calcDistance($id, $location = [])
    {
        try {
            $company = \App\Models\Company::select('id', 'latitude', 'longitude')->findOrfail($id);
            $distance = self::getDistance($company->latitude, $company->longitude, $location['lat'], $location['lon']);

            return (round($distance, 2));

        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get Distance
     * used : true 
     */
    public static function getDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
    {
        // way 1.
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        //return $angle * 6371;
        return $angle * 6682;
    }

    /**
     * Get distance copy 
     * used : false 
     * temporary : true
     */
    public static function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'Km')
    {
        $theta = $longitude1 - $longitude2;
        $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
        $distance = acos($distance);
        $distance = rad2deg($distance);
        return $distance;
        $distance = $distance * 60 * 1.1515;
        switch ($unit) {
            case 'Mi':
                break;
            case 'Km':
                $distance = $distance * 1.609344;
        }
        return (round($distance, 2));
    }

    /**
     * Get delivery charges
     * 
     * if distance lies under fixed shipping
     * then go ahead otherwise calculate shipping
     * by km shipping method.
     * 
     * used : true 
     * 
     */
    
    public static function getDeliveryCharges($distance = '' , $country)
    {
        /*$max_order_kms = config::get('roms.frontSettings.max_order_kms');
        $fixed_shipping = config::get('roms.frontSettings.front_fixed_shipping');
        $extra_km_charges = config::get('roms.frontSettings.front_extra_km_charges');*/
       
        $front_base_shipping=setting('base_shipping_charges');
        $front_base_shipping_eg=setting('base_shipping_charges_eg');

        $front_per_mile_charges=setting('shipping_per_mile_charges');
        $front_per_km_charges=setting('shipping_per_km_charges');
     
   
       
   

if($country=='US'){
    $distance=($distance/1000)*0.62137;//distance convert to miles
}
else {
    $distance=$distance/1000;//distance convert to km
}

      
      $distance=round($distance, 2);// number_format($distance, 2); 
     

    //$fixed_shipping =  setting('front_fixed_shipping');
      //$extra_km_charges =  setting('front_extra_km_charges');
//We need to add base amount, 1.99, plus $1.03 for each mile....
  //  e.g 2 miles 1.99+(2*1.03)
  if($country=='US'){
  $calcultedcost=$front_base_shipping+($distance*$front_per_mile_charges);
  }

  else{
    $calcultedcost=$front_base_shipping_eg+($distance*$front_per_km_charges);
    }


  
        return round($calcultedcost,2);
    }

/*
https://maps.googleapis.com/maps/api/distancematrix/json?origins=30.0385231,31.2227123&destinations=30.1128268,31.3997904&departure_time=now&key=AIzaSyDmuQZuyvtLoog7Yi_s48Gwj4Y3vTT6PKs

https://maps.googleapis.com/maps/api/distancematrix/json?origins=3 El Thawra Council St Zamalek&destinations=Cairo International Airport (CAI), Road، El Nozha, Egypt&departure_time=now&key=AIzaSyDmuQZuyvtLoog7Yi_s48Gwj4Y3vTT6PKs
 */


    /**
     * Driver commision 
     * userd : true 
     */

    public static function calcDriverAmount($shipping_charges = null , $country)
    {
      
      if(!$shipping_charges) return 0;
      if($country=='US'){
        $driverShare =  setting('front_driver_share');
      }
      else{
        $driverShare =  setting('front_driver_share_eg');
      }
      
      return round((($shipping_charges*$driverShare)/100),2); //calculate driver amount 
    }

    /**
     * System amount 
     * userd : true 
     */

    public static function calcSystemAmount($profit = null,$shipping_charges=null,$country)
    {
      if(!$shipping_charges) return 0;
      if($country=='US'){
        $driverShare =  setting('front_driver_share');
      }
      else{
        $driverShare =  setting('front_driver_share_eg');
      }
     
      $driverAmount = (($shipping_charges*$driverShare)/100); // Driver profit
      return round(($profit-$driverAmount),2);
    }

    public static function availableTags()
    {
      $tags = \App\Searchtag::active()->get('name');
      return ($tags->count()) ? $tags->pluck('name') : [];
    }

}
