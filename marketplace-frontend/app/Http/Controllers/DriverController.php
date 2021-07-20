<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Providers\RouteServiceProvider;
use Auth;
use App\Http\Requests\DriverProfileUpdateRequest;

use Config;
use App\Order;
use App\Helpers\Admin;
use App\OrderItem;
use App\OrderGps;
use App\AcceptOrder;
use App\Helpers\Front;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use App\Driver;
use App\Models\Media;
use App\Models\Upload;
use App\Models\Company;
use DB;
use App\Models\Notification;

class DriverController extends Controller
{
    /**
     *
     * @var object
     */
    private $user;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Common Pageconfigs of
     * dashboard for now.
     *
     * @var array
     */
    protected $pageConfigs = [
        'newsletter' => false,
        'breadcrumb' => false,
        'showProfileSidebar' => true,
        'title' => 'My Dashboard',
    ];

    /**
     * Attaching middleware to Driver.
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = $this->myProfile();
            return $next($request);
        });
        //dd($this->user);
        // core Driver profile....
    }

    public function getDestiantionLocation($id = null){

      if(Auth::user()->isOnline and $id !== null){

          $order = Order::whereIn('orderstatus_id',[6,7])
          ->where('id','=',$id)
         ->whereHas('acceptorder',function($q){
            $q->where('driver_id',$this->user->id);
            $q->where('active',1);
          })->with([
            'ordergps' => function($q){
            $q->select('order_id','driver_lat','driver_lon','drop_lat','drop_lon');
            },
            'company' => function($q){
              $q->select('id','latitude','longitude');
            }
            ])->first();
            
            if($order->orderstatus_id == 6){
              $latitude_dest=$order->company->latitude;
              $longitude_dest=$order->company->longitude; 
            }
            if($order->orderstatus_id == 7){
              $latitude_dest=$order->ordergps->drop_lat;
              $longitude_dest=$order->ordergps->drop_lon; 
            }
          return response()->json([
              'error' => false,
              'lat' => $latitude_dest,
              'lon'=>$longitude_dest,
          ]);

      }else{

          return response()->json([
          'error' => true,
          'message' => 'Error occured!'
          ]);
      }//online if;

    }
    public function StatusAutoUpdate(Request  $request){
      
      if(Auth::user()->isOnline){
        $user=User::where('id','=',Auth::user()->id)->first();
        //driver lat lon updating...
        $user->latitude=$request->input('lat');
        $user->longitude=$request->input('lon');
        $user->save();


      if(Front::IsactiveOrder($this->user->id, $this->user->user_type) > 0){
      //get order list
       $orders = Order::whereIn('orderstatus_id',[6,7])
       ->whereHas('acceptorder',function($q){
        $q->where('driver_id',$this->user->id);
        $q->where('active',1);
       })->get();

      //open order gps updating:
      foreach ($orders as $od) {
        $ordergps = OrderGps::where('order_id', $od->id)->first();
        $ordergps->driver_lat = $request->input('lat');
        $ordergps->driver_lon = $request->input('lon');
        $ordergps->save();
      }
    }//if active orders

      $notificaion=Notification::where('user_id','=',$this->user->id)->get();

      return response()->json([
          'error' => false,
          'message' => 'Update successfully!',
          'notifications'=>[],
      ]);
      }else{
          return response()->json([
          'error' => true,
          'message' => 'You are not online!',
      ]);
      }//online if;
      
    }

    public function dashboard()
    {
       if(Auth::user()->isOnline){
      // order must not in my cancelled orders.
      //echo $days=\carbon\Carbon::now()->subDays(30); //30 days before
      //$newDateTime = \carbon\Carbon::now()->subHour(3); //3 hours before  
        $latitude=Auth::user()->latitude;
        $longitude=Auth::user()->longitude;
        $dist='front_resturant_distance_limit:'.\App::getLocale();
        $dist = config('roms.frontSettings.'.$dist); // This is the maximum distance (in miles) away from $origLat, $origLon in which to search  
        $orders = Order::addSelect(
            ['*'=>'orders.*','name'=>'companies.name','slug'=>'companies.slug'
            ,'distance'=>DB::raw('(SELECT (3956 * 2 * ASIN(SQRT( POWER(SIN(( '.$latitude.' - latitude) *  pi()/180 / 2), 2) + COS( '.$latitude.' * pi()/180) * COS(latitude * pi()/180) * POWER(SIN(( '.$longitude.' - longitude) * pi()/180 / 2), 2) ))) as distance FROM `companies` as c WHERE `c`.`id` = `companies`.`id`) AS distance')
          ])->join('companies', 'orders.company_id', '=', 'companies.id')
            ->where([
              'orders.orderstatus_id'=> 1,
              //'orders.area_id'=> $this->user->driverprofile->area_id,
            ])
          ->where('orders.created_at', '>', \carbon\Carbon::now()->subHour(1))
            ->doesntHave('acceptorder','and',function($q){
              $q->where('active','=',0);
            })
            ->with([
              'orderstatus' => function($q){
                $q->select('id','name');
              },
              'company' => function($q){
                $q->select('id','name');
              }
              ])->having('distance','<=',$dist)
            ->orderBy('orders.id', 'DESC')->get();

        }else{
          $orders= collect(new Order);
        }

      return view('pages.driver.dashboard', [
          'pageConfigs' => $this->pageConfigs,
          'user' => $this->user,
          'orders' => $orders,
      ]);
    }

    /**
     * go online
     *
     * @method GET
     * @description - available for order 
     */
    public function goOnline(Request  $request)
    {
    
     $user=Auth::user();  

     if(! empty($request->input('lon')) &&  ! empty($request->input('lat'))){
       $user->latitude = $request->input('lat');
      $user->longitude = $request->input('lon');
      $user->isOnline = $request->input('isOnline');
      $user->save();
      }else if($request->input('isOnline') == 0){
      $user->latitude = $request->input('lat');
      $user->longitude = $request->input('lon');
      $user->isOnline = $request->input('isOnline');
      $user->save();
      }
      return redirect()->back();
    }

    /**
     * My Orders
     *
     * @method GET
     * @description - Show all orders in which this driver in relation
     */
    public function myOrders()
    {
      $orders = Order::whereIn('orderstatus_id',[6,7,8])
      ->whereHas('acceptorder',function($q){
        $q->where('driver_id',$this->user->id);
        $q->where('active',1);
      })
      ->with([
        'orderstatus' => function($q){
          $q->select('id','name');
        },
        'company' => function($q){
          $q->select('id','name');
        }
        ])->orderBy('id', 'DESC')->get();
        
        return view('pages.driver.myorders', [
          'pageConfigs' => $this->pageConfigs,
          'user' => $this->user,
          'orders' => $orders,
        ]);
    }

    /**
     * New Orders
     *
     * @method GET
     * @description - Show all orders in which no driver in relation
     * completed : true
     * 
     */
    public function newOrders()
    {

      if(Auth::user()->isOnline){
     // order must not in my cancelled orders.
//echo $days=\carbon\Carbon::now()->subDays(30); //30 days before
 //  $newDateTime = \carbon\Carbon::now()->subHour(1); //3 hours before

   //     print_r($newDateTime);
 //  echo Timezone::convertToLocal(\carbon\Carbon::now()->subHour(3));
//die();
        $latitude=Auth::user()->latitude;
        $longitude=Auth::user()->longitude;
        $dist='front_resturant_distance_limit:'.\App::getLocale();
        $dist = config('roms.frontSettings.'.$dist); // This is the maximum distance (in miles) away from $origLat, $origLon in which to search
        
            $orders = Order::addSelect(
            ['*'=>'orders.*','name'=>'companies.name','slug'=>'companies.slug'
            ,'distance'=>DB::raw('(SELECT (3956 * 2 * ASIN(SQRT( POWER(SIN(( '.$latitude.' - latitude) *  pi()/180 / 2), 2) + COS( '.$latitude.' * pi()/180) * COS(latitude * pi()/180) * POWER(SIN(( '.$longitude.' - longitude) * pi()/180 / 2), 2) ))) as distance FROM `companies` as c WHERE `c`.`id` = `companies`.`id`) AS distance')
          ])->join('companies', 'orders.company_id', '=', 'companies.id')
            ->where([
              'orders.orderstatus_id'=> 1,
              //'orders.area_id'=> $this->user->driverprofile->area_id,
            ])
         ->where('orders.created_at', '>', \carbon\Carbon::now()->subHour(1))
            ->doesntHave('acceptorder','and',function($q){
              $q->where('active','=',0);
            })
            ->with([
              'orderstatus' => function($q){
                $q->select('id','name');
              },
              'company' => function($q){
                $q->select('id','name');
              }
              ])
              ->having('distance','<=',$dist)
            ->orderBy('orders.id', 'DESC')->get();

      }else{
        $orders= collect(new Order);
      }

      return view('pages.driver.neworders', [
          'pageConfigs' => $this->pageConfigs,
          'user' => $this->user,
          'orders' => $orders,
          ]);
    }

    public function updateOrder(Request $request,$id = null)
    {
      if(!$id) return redirect(route('driver.dashboard')); 
      $items=$request->input('itemid');

      $order = Order::whereIn('orderstatus_id',[6])
      ->where('id','=',$id)
      ->whereHas('acceptorder',function($q){
        $q->where('driver_id',$this->user->id);
        $q->where('active',1);
      })->first();

      if($order){
       $unavailblecost=0;
      
      foreach ($items as $key => $Itemid) {
        # code...
        if($request->has('item_availability'.$Itemid)){
        $OrderItem=OrderItem::where('order_id','=',$id)->where('id','=',$Itemid)->first();
        $OrderItem->isavailable = $request->input('item_availability'.$Itemid); 
        $OrderItem->save();
        if($request->input('item_availability'.$Itemid) ==0){
          $unavailblecost=$unavailblecost+($OrderItem->price * $OrderItem->quantity);
          }
        }
      }

      //
       $itemtotal=OrderItem::where('order_id','=',$id)->where('isavailable','!=',0)->sum(\DB::raw('quantity * price'));
         $serviceFee = str_replace("%","",setting('front_service_charges'));
      $serviceFee = round($serviceFee * $itemtotal/ 100,2);
      $total = $itemtotal+$serviceFee+$order->shipping_charges;
      $order->service_fee=$serviceFee;
      $order->total=Front::myPriceRound($total);
      $order->save();
      return redirect()->back()->with('success','Order updated!');
    }else{
        return redirect()->back()->with('error','Order not updated!');
    }

    }
    /**
     * Order Details
     * @method GET
     */
    public function orderDetails($id = null)
    {

      if(!$id) return redirect(route('driver.dashboard')); 

      $order = Order::leftJoin('accept_orders', function($join) {
      $join->on('orders.id', '=', 'accept_orders.order_id');
      $join->on('accept_orders.driver_id','=',DB::raw($this->user->id));

    })->where('orders.id', $id)->with([
        'orderstatus' => function($q)
        {
          $q->select('id','name');
        },
        'company' => function($q)
        {
          $q->select('id','name','address','latitude','longitude');
        },
        'user' => function($q)
        {
          $q->select('id','name','phone','email');
        },
        'orderitems' => function($q)
        {
          $q->select('id','order_id','name','quantity','price','isavailable');
        },
        'ordergps' => function($q){
          $q->select('order_id','driver_lat','driver_lon','drop_lat','drop_lon');
        }
      ])->first(['orders.*','accept_orders.active']);
      
      if(is_null($order)) return redirect(route('driver.dashboard'));


      // get driver details
        $driver = [];
        if(in_array($order->orderstatus->id,[6,7,8])){
          $cOrder = AcceptOrder::where([
            'order_id'=>$order->id,
            'active'=>1,
            ])
          ->with('driver:user_id,vehicle_no','driver.user:id,name')
          ->first();

          if(!is_null($cOrder))
          {
            $driver['name'] = $cOrder->driver->user->name;
            $driver['vehicle'] = $cOrder->driver->vehicle_no;
          }
        }
        // FALSE - if do not want to show sidebar
        $this->pageConfigs['showProfileSidebar'] = true;
        // to do
        // order details get
        return view('pages.driver.orderdetails', [
          'pageConfigs' => $this->pageConfigs,
          'user' => $this->user,
          'order' => $order,
          'driver' => $driver,
          ]);
    }

    /**
     * Accept order by driver
     * must check : not already accepted?
     */

    public function acceptOrder($id = null)
    {
      if(!$id) return redirect(route('driver.dashboard')); 

      $order = Order::where('id', $id)
      ->whereIn('orderstatus_id',[1,6])->first();

      if(is_null($order)) return redirect(route('driver.dashboard'));

      // check for prev active acceptences. 

     $preOrdAcpt = AcceptOrder::where([
       'order_id'=> $order->id,
       'active'=> 1,
       ])->first();
      
      // No prev active acceptence
      if(is_null($preOrdAcpt))
      {
        $orderAcceptence = new AcceptOrder(); // not intrested to accept order. 
        $orderAcceptence->user_id = $order->user_id; // customer id
        $orderAcceptence->order_id = $order->id; // order id
        $orderAcceptence->driver_id = $this->user->id; // driver id
        $orderAcceptence->completed = false; // going 

        // driver location for synco :)
        $orderAcceptence->driver_lat = Auth::user()->latitude;
        $orderAcceptence->driver_lon = Auth::user()->longitude;
        
        $orderAcceptence->active = true; // active
        $orderAcceptence->save();

        // update order
        $order->orderstatus_id = 6; // order accepted by driver
        $order->save();

        // driver location in gps table ......

        $ordergps = OrderGps::where('order_id', $order->id)->first();
        $ordergps->driver_lat = $orderAcceptence->driver_lat;
        $ordergps->driver_lon = $orderAcceptence->driver_lon;
        $ordergps->save();

        //make notification log
          Front::notificationLog('Order Accepted by Driver!',1,$order->id,$order->user_id,'Order Accepted');

        return redirect()->back()->with('success','Order Accepted Successfully.');
        //return redirect(route('driver.dashboard'))
      }

      /// here pocedure for other drivers
        $orderAcceptence = new AcceptOrder(); // not intrested to accept order. 
        $orderAcceptence->user_id = $order->user_id; // customer id
        $orderAcceptence->order_id = $order->id; // order id
        $orderAcceptence->driver_id = $this->user->id; // driver id
        $orderAcceptence->completed = false; // going 
        // driver location for synco :)
        $orderAcceptence->driver_lat = Auth::user()->latitude;
        $orderAcceptence->driver_lon = Auth::user()->longitude;        
        $orderAcceptence->active = false; 
        $orderAcceptence->save();
        return redirect(route('driver.dashboard'))->with('error','Order was already accepted by someone else.');
    }

    /**
     * Cancel order by driver
     */

    public function cancelOrder($id = null)
    {
      if(!$id) return redirect(route('driver.dashboard')); 

      $order = Order::where('id', $id)->first();

      if(is_null($order)) return redirect(route('driver.dashboard'));
      $orderAcceptence = new AcceptOrder(); // not intrested to accept order.. 
      $orderAcceptence->user_id = $order->user_id; // customer id
      $orderAcceptence->order_id = $order->id; // order id
      $orderAcceptence->driver_id = $this->user->id; // driver id
      $orderAcceptence->completed = false; // not going (:
      $orderAcceptence->active = false; // not active (:
      $orderAcceptence->save();
      return redirect(route('driver.dashboard'))->with('success','Order cancelled Successfully.');
    }


  
    public function PickupOrder($id = null)
    {
      if(!$id) return redirect(route('driver.dashboard'));
      $order = Order::where('id', $id)->first();
        // update order
        $order->orderstatus_id = 7; // order pickup by driver
        $order->save();

      //make notification log
          Front::notificationLog('Order pickup by Driver!',1,$order->id,$order->user_id,'Order pickup');
      return redirect()->back()->with('success','Status updated!.');
    }

    /**
     * Complete Order by driver
     */
    public function completeOrder($id = null)
    {
      /*
      check order exist
      check current user is the driver for this order. 
      Cash on delivery. -> add record for order_payments. 
      mark accepted delivery to be completed. 
      order status to be completed. 
      // driver spec. payouts - finance relation.
      */
      if(!$id) return redirect(route('driver.dashboard')); 

      $order = Order::where('id', $id)->first();

      $company = Company::where('id',$order->company_id)->first();
      if(is_null($order)) return redirect(route('driver.dashboard'));

      $delivery = acceptOrder::where([
        'order_id'=>$order->id,
        'active'=>1,
        ])->first();

      // check current user is the driver for this order.. 
      if(!(is_null($delivery)) && $delivery->driver_id == $this->user->id)
      { // all good -> complete the order. 
        $delivery->completed = 1;
        $delivery->save(); // mark delivery as completed. 

        //check cash delivery -> Yes -> add order payment to system dude :)
        if($order->payment_method == 1)
        {
          $item_costs = ($order->total - ($order->service_fee + $order->shipping_charges));
          $order->payment()->create([
            'payment_type' => $order->payment_method,
            'amount' => $order->total,
            'system_amount' => Front::calcSystemAmount(($order->total - $item_costs),$order->shipping_charges,$company->country),
            'driver_amount' => Front::calcDriverAmount($order->shipping_charges,$company->country),
            'item_costs' => $item_costs,
            ]);
          $order->orderstatus_id = 8; // order completed. 
          
        } else {
          $order->orderstatus_id = 8; // order completed. 
        }

        // create settlement to :)
        $order->settlement()->create([
          'received' => 0,
        ]);
        $order->save();

        //make notification log
          Front::notificationLog('Order completed!',1,$order->id,$order->user_id,'Order completed');

        return redirect(route('driver.dashboard'))->with('success','Congratulations!!! Order Completed successfully.');

      }

      return redirect(route('driver.dashboard'))->with('error','There is an error. kindly contact your area manager.');
    }

    /**
     * My Ratings
     * @method GET
     */
    public function myRatings()
    {
        return view('pages.driver.myratings', ['pageConfigs' => $this->pageConfigs, 'user' => $this->user]);
    }

    /**
     * New Orders
     *
     * @method GET
     * @description - Show all orders in which no driver in relation
     * completed : true
     * 
     */


    public function myEarnings()
    {
      // order must not in my cancelled orders.
      /*
      select orders where status competed
      with order status
      with order payment
      with order settlement
      
       */

      $orders = Order::whereIn('orderstatus_id',[8])
      ->whereHas('acceptorder',function($q){
        $q->where('driver_id',$this->user->id);
        $q->where('active',1);
        $q->where('completed',1);
      })
      ->with([
        'orderstatus' => function($q){
          $q->select('id','name');
        }
      ])
      ->with([
        'payment' => function($q){
          $q->select('order_id','driver_amount');
        }
      ])
      ->with([
        'settlement' => function($q){
          $q->select('order_id','received');
        }
      ])
      ->orderBy('id', 'DESC')->get();
      // echo '<pre>';
      // print_r($orders);
      // die();
        return view('pages.driver.my-earnings', [
          'pageConfigs' => $this->pageConfigs,
          'user' => $this->user,
          'orders' => $orders,
          ]);
    }

    /**
     * Edit Profile - View
     * @method GET
     */
    public function editProfileView()
    {
        return view('pages.driver.editprofile', ['pageConfigs' => $this->pageConfigs, 'user' => $this->user]);
    }

    /**
     * Edit Profile - Update
     *
     * @method POST
     */
    public function editProfileUpdate(DriverProfileUpdateRequest $request)
    {
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->save();
        $user->driverprofile->age = $request->input('age');
        $user->driverprofile->vehicle_no = $request->input('vehicle');
        $user->driverprofile->gender = $request->input('gender');
        $user->driverprofile->save();
        $request->session()->flash('success', 'User Updated Successfully!!!');
        return redirect()->back();
    }

    /**
     *
     */
    private function myProfile()
    {
        return new ProfileResource(Auth::user());
    }

    public function drivewithabboda()
    {
      return view('pages.driver.drivewith', [
        'pageConfigs' => $this->pageConfigs,
     
    ]);

    }

    public function deliverabbodapost(Request $request)
    {
      $request->validate(
        [
'imageid' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
'carregister' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
'car_insurance' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
],
[
'imageid.required' => 'You have to choose Image ID!',
]
            );
        if ($request->vehicle_type == 'Car') {
            $request->validate(
                [
        
        'carregister' => 'required',
        'car_insurance' => 'required',
      ],
                [
          
          'carregister.required' => 'You have to choose Car Register!',
          'car_insurance.required' => 'You have to choose Car Insurance!'
      ]
            );
        }
    

  //   $imageName = time().'.'.$request->imageid->extension();  

 
  // $imageupload=  $request->imageid->move(public_path('images'), $imageName);
    

  $request->validate([
    'email' => 'bail|required|unique:users|max:250',
    'idnumber' => 'bail|required|max:250',
    'socialnumber' => 'bail|required|max:250',
    'vehicle_type' => 'bail|required|max:250',
  ],
    [
      'idnumber.required' => 'You have to choose ID Number!',
      'socialnumber.required' => 'You have to choose Social Security Number!'
  ]);





$deliverwith=User::insert(
  ['user_type' =>4,
  'email' =>$request->email, 
  'name' =>$request->fullname,
  'phone' =>$request->mobilenumber,
  'password'=>Hash::make(time())]
  
); 
$productId = DB::getPdo()->lastInsertId();


$yourModel = User::find($productId);


if(isset($request->imageid)){
 
  $input = ["avatar" => $request->imageid, "uuid" => $request->uuid2 , "field" =>'avatar'];

  $upload = Upload::create($input);
        
  $upload->addMedia($input['avatar'])
      ->withCustomProperties(['uuid' => $input['uuid']])
      ->toMediaCollection($input['field']);

      $cacheUpload = Admin::getByUuid(request()->input('uuid2'));
    
      $mediaItem = $cacheUpload->getMedia('avatar')->first();
     
          $mediaItem->copy($yourModel, 'avatar');
}

if (isset($request->carregister)) {

  
    $input = ["car_register" => $request->carregister, "uuid" => $request->uuid1 , "field" =>'identity_image'];

    $upload = Upload::create($input);
          
    $upload->addMedia($input['car_register'])
        ->withCustomProperties(['uuid' => $input['uuid']])
        ->toMediaCollection($input['field']);
  
        $cacheUpload = Admin::getByUuid(request()->input('uuid1'));
      
        $mediaItem = $cacheUpload->getMedia('identity_image')->first();
       
            $mediaItem->copy($yourModel, 'identity_image');
  
  }
  

if (isset($request->car_insurance)) {
  

  $input = ["car_insurance" => $request->car_insurance, "uuid" => $request->uuid , "field" =>'car_insurance'];

  $upload = Upload::create($input);
        
  $upload->addMedia($input['car_insurance'])
      ->withCustomProperties(['uuid' => $input['uuid']])
      ->toMediaCollection($input['field']);

      $cacheUpload = Admin::getByUuid(request()->input('uuid'));
      
      $mediaItem = $cacheUpload->getMedia('car_insurance')->first();
     
          $mediaItem->copy($yourModel, 'car_insurance');

}



   $deliverwith_driver=Driver::insert(
    ['user_id' =>$yourModel->id,
    'id_number' =>$request->idnumber,
    'social_security_number'=>$request->socialnumber,
    'vehicle_no'=>$request->vehicle_type]
    
 ); 


    return redirect(route('drivewith'))->with('success', 'Your request will successfully submitted.');


    } 

    public function deliveryDetails()
    {
      //&& 'id',$id
      $orders = Order::whereIn('orderstatus_id',[8] )
      ->whereHas('acceptorder',function($q){
        $q->where('driver_id',$this->user->id);
        $q->where('active',1);
        $q->where('completed',1);
        
      })
      ->with([
        'orderstatus' => function($q){
          $q->select('id','name');
        }
      ])
      ->with([
        'payment' => function($q){
          $q->select('order_id','driver_amount');
        }
      ])
      ->with([
        'settlement' => function($q){
          $q->select('order_id','received');
        }
      ])
      ->orderBy('id', 'DESC')->get();
      // echo '<pre>';
      // print_r($orders);
      // die();
      return view('pages.driver.deliverydetails', [
        'user' => $this->user,
        'pageConfigs' => $this->pageConfigs,

     
    ]);

    }


}
