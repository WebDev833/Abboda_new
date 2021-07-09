<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Log;


class BhTestController extends Controller
{
    function loadMapTest()
  {
	  return view('tests.map');
  }  

   function sendmail()
  {
      

        exit();
   Log::info('This is some useful information.');
   // Front::SendNotification();
    echo "sent email";
  }  

  function test()
  {
    print_r(setting('front_app_name'));
    print_r(setting('front_extra_km_charges'));
  }  

  function cleanUpAll()
  {
    DB::table('accept_orders')->truncate();
    DB::table('address_book')->truncate();
    DB::table('carts')->truncate();
   // DB::table('drivers')->truncate();
    DB::table('notification_settings')->truncate();
    DB::table('online_payments')->truncate();
    DB::table('orders')->truncate();
    DB::table('order_gps')->truncate();
    DB::table('order_items')->truncate();
    DB::table('order_payments')->truncate();
  }

}
