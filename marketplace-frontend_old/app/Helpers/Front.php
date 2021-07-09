<?php

namespace App\Helpers;

use Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Front
{
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
            $upObj->addMediaFromUrl($mediaUrl) //  Full Url
                ->withCustomProperties(['uuid' => $upObj->uuid])
                ->toMediaCollection($collectionName);
            $media = $upObj->getMedia($collectionName)->first();
            $media->copy($relModel, $collectionName);
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
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
            ->where('close_time', '>', date('H:i'))
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
    
    public static function getDeliveryCharges($distance = '')
    {
      $max_order_kms = config::get('roms.frontSettings.max_order_kms');
      $fixed_shipping = config::get('roms.frontSettings.front_fixed_shipping');
      $extra_km_charges = config::get('roms.frontSettings.front_extra_km_charges');

      if($distance <= $max_order_kms)
      {
        return $fixed_shipping;
      }
        return (round(($distance*$extra_km_charges),2));
    }

/*
https://maps.googleapis.com/maps/api/distancematrix/json?origins=30.0385231,31.2227123&destinations=30.1128268,31.3997904&departure_time=now&key=AIzaSyDmuQZuyvtLoog7Yi_s48Gwj4Y3vTT6PKs

https://maps.googleapis.com/maps/api/distancematrix/json?origins=3 El Thawra Council St Zamalek&destinations=Cairo International Airport (CAI), Road، El Nozha, Egypt&departure_time=now&key=AIzaSyDmuQZuyvtLoog7Yi_s48Gwj4Y3vTT6PKs
 */


    /**
     * Driver commision 
     * userd : true 
     */

    public static function calcDriverAmount($profit = null)
    {
      if(!$profit) return 0;
      $driverShare = config::get('roms.frontSettings.front_driver_share');
      return round((($profit*$driverShare)/100),2);
    }

    /**
     * System amount 
     * userd : true 
     */

    public static function calcSystemAmount($profit = null)
    {
      if(!$profit) return 0;
      $driverShare = config::get('roms.frontSettings.front_driver_share');
      $driverAmount = (($profit*$driverShare)/100);
      return round(($profit-$driverAmount),2);
    }

    public static function availableTags()
    {
      $tags = \App\Searchtag::active()->get('name');
      return ($tags->count()) ? $tags->pluck('name') : [];
    }

}
