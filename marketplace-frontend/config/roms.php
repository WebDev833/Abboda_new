<?php

return [
  // set default values here.. for fallback. 
    'frontSettings' => [
        'front_app_name' => 'front_app_name',
        'front_email' => 'support@abboda.com', 
        'front_phone' => '+1 9876543210', 
        'front_app_language' => 'en', 
        'front_timezone' => 'Africa/Cairo', 
        'front_country_code' => '+20', 
        'google_geocoding_api_key' => 'AIzaSyDmuQZuyvtLoog7Yi_s48Gwj4Y3vTT6PKs', 
        'max_order_kms' => '10',  // max order kms for fixed shipping
        'front_stripe_key' => 'pk_test_rqXwj4cHIkc7bp74WvII9YCF00ArTr5Asu', 
        'front_stripe_secret' => 'sk_test_kx9OmxdcMuxaubTeUGchEyg100hPynGXYK',

        'front_payment_currency' => 'EGP',
        
        'front_fixed_shipping' => '50', // fixed shipping charges
        'front_extra_km_charges' => '10', // if order distance more then max_order_kms then extra kms will be multiply by these charges. 
        'front_service_charges' => '5', // platform/system/service charges.
        'front_driver_share' => '90', // Driver share in percentage.
        'front_resturant_distance_limit:ar' => '5', //5 or less then 5 miles resturant can show.
        'front_resturant_distance_limit:en' => '5', //5 or less then 5 miles resturant can show.
        'front_base_shipping:en' => '1.99', // fixed shipping charges
        'front_base_shipping:ar' => '1.99', // fixed shipping charges
        'front_per_mile_charges:en' => '1.03', // if order distance more then
        'front_per_mile_charges:ar' => '1.03', // if order distance more then 


    ],
'foodtypes:en'=>[
    
    'Pizza'=>['value'=>'Pizza','keywords'=>'Pizza'],
    'Chicken-Wings'=>['value'=>'Chicken Wings','keywords'=>'Chicken Wings,Chicken,Wings'],
    'Indian-Food'=>['value'=>'Indian Food','keywords'=>'Indian Food,Indian'],
    'Fast-Food'=>['value'=>'Fast Food','keywords'=>'Fast Food,fast'],
    'Italian-Food'=>['value'=>'Italian Food','keywords'=>'Italian Food,Italian'],
    'Chinees-Food'=>['value'=>'Chinees Food','keywords'=>'Chinees Food,Chinees'],
    'Thai-Food'=>['value'=>'Thai Food','keywords'=>'Thai Food,Thai'],
    'Mexican-Food'=>['value'=>'Mexican Food','keywords'=>'Mexican Food,Mexican'],
    'American-Food'=>['value'=>'American Food','keywords'=>'Pizza,fast food,cheeseburgers'],
    'Steak'=>['value'=>'Steak','keywords'=>'Steak'],


    ],
'foodtypes:ar'=>[

    'Pizza'=>['value'=>'Pizza','keywords'=>'Pizza'],
    'Chicken-Wings'=>['value'=>'Chicken Wings','keywords'=>'Chicken Wings,Chicken'],
    'Indian-Food'=>['value'=>'Indian Food','keywords'=>'Indian Food,Indian'],
    'Fast-Food'=>['value'=>'Fast Food','keywords'=>'Fast Food,fast'],
    'Italian-Food'=>['value'=>'Italian Food','keywords'=>'Italian Food,Italian'],
    'Chinees-Food'=>['value'=>'Chinees Food','keywords'=>'Chinees Food,Chinees'],
    'Thai-Food'=>['value'=>'Thai Food','keywords'=>'Thai Food,Thai'],
    'Mexican-Food'=>['value'=>'Mexican Food','keywords'=>'Mexican Food,Mexican'],
    'American-Food'=>['value'=>'American Food','keywords'=>'Pizza,fast food,cheeseburgers'],
    'Steak'=>['value'=>'Steak','keywords'=>'Steak'],
    
    ],
    'dev' => [
      'address' => 'Cairo International Airport (CAI), Road، El Nozha, Egypt',
      'lat' => '30.1128268',
      'lon' => '31.3997904',
      'note' => '',
      'payment_method' => '1',
      'driver_lat' => '30.4128268',
      'driver_lon' => '31.6997904',
    ],
    'custom' => [
        'newsletter' => false, // Show newsletter section
        'breadcrumb' => true, // Show breadcrumb section
        'title' => 'Page Title', // Page Title
    ],
    'system' => [
      'currency' => 'EGP',
    ],
    'store' => [
        'defaultStoreBanner' => 'defaults/store/vendor.jpg',
        'defaultLogoImage' => 'defaults/store/vendor-store.jpg',
        'defaultProductImage' => 'defaults/store/1.jpg',
        'defaultCategoryImage' => 'defaults/store/vendor-store.jpg',
    ],
    'cart' => [
        'defaultThumbImage' => 'defaults/store/1.jpg',
    ],
    'dashboard' => [
        'defaultManagerImage' => 'defaults/user/manager.png',
    ],
];
