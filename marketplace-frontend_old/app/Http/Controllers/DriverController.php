<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Providers\RouteServiceProvider;
use Auth;
use App\Http\Requests\DriverProfileUpdateRequest;

use Config;
use App\Order;
use App\OrderItem;
use App\OrderGps;
use App\AcceptOrder;
use App\Helpers\Front;


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
        'breadcrumb' => true,
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

    public function dashboard()
    {
        //
        // For now lets show -> New Orders....
        // -> later will create a dashboard for driver
        //

      // order must not in my cancelled orders.
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
      // order must not in my cancelled orders.
      $orders = Order::where([
        'orderstatus_id'=> 1,
        'area_id'=> $this->user->driverprofile->area_id,
      ])
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
        ])->orderBy('id', 'DESC')->get();

        return view('pages.driver.neworders', [
          'pageConfigs' => $this->pageConfigs,
          'user' => $this->user,
          'orders' => $orders,
          ]);
    }

    /**
     * Order Details
     * @method GET
     */
    public function orderDetails($id = null)
    {

      if(!$id) return redirect(route('driver.dashboard')); 

      $order = Order::where('id', $id)->with([
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
          $q->select('id','order_id','name','quantity','price');
        },
        'ordergps' => function($q){
          $q->select('order_id','driver_lat','driver_lon','drop_lat','drop_lon');
        }
      ])->first();
      
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
        $orderAcceptence->driver_lat = config::get('roms.dev.driver_lat');
        $orderAcceptence->driver_lon = config::get('roms.dev.driver_lon');
        
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

        return redirect(route('driver.dashboard'))->with('success','Order Accepted Successfully.');
      }

      /// here pocedure for other drivers
        $orderAcceptence = new AcceptOrder(); // not intrested to accept order. 
        $orderAcceptence->user_id = $order->user_id; // customer id
        $orderAcceptence->order_id = $order->id; // order id
        $orderAcceptence->driver_id = $this->user->id; // driver id
        $orderAcceptence->completed = false; // going 
        // driver location for synco :) 
        $orderAcceptence->driver_lat = config::get('roms.dev.driver_lat');
        $orderAcceptence->driver_lon = config::get('roms.dev.driver_lon');
        
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
            'system_amount' => Front::calcSystemAmount(($order->total - $item_costs)),
            'driver_amount' => Front::calcDriverAmount(($order->total - $item_costs)),
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
}
