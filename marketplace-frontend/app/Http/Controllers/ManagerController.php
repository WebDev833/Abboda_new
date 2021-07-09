<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Providers\RouteServiceProvider;
use Auth;
use App\Http\Resources\ProfileResource;
use App\Http\Requests\UserProfileUpdateRequest;
use App\Http\Requests\TransactionRequest;

use Config;
use App\Order;
use App\OrderItem;
use App\OrderGps;
use App\AcceptOrder;
use App\AreaManager;
use App\SystemPays;
use App\User;
use App\Driver;
use App\Helpers\Front;

class ManagerController extends Controller
{
    /**
     *
     * @var object
     */
    private $user;

    private $maxPageRecords = 10;

    private $myAreas;

    private $publicPathManager = [
      'manager/noareas',
      'manager/edit-profile',
    ];


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
            $this->myAreas = $this->myAreaList();
            //dd($this->myAreas);
            if((!$this->myAreas) && !(in_array(request()->path(),$this->publicPathManager)))
            {
              return redirect(route('manager.noareas'));
            }

            return $next($request);
        });
        //dd($this->user);
        // core Manager profile....
    }

    public function dashboard()
    {
      $orders = Order::whereIn('area_id',$this->myAreas)
      ->with([
        'orderstatus' => function($q){
          $q->select('id','name');
        },
        'company' => function($q){
          $q->select('id','name');
        }
        ])->orderBy('id', 'DESC')->paginate($this->maxPageRecords);
        
        return view('pages.manager.myorders', [
          'pageConfigs' => $this->pageConfigs,
          'user' => $this->user,
          'orders' => $orders,
        ]);
    }

    /**
     * My Orders
     *
     * @method GET
     * @description - Show all orders in which this manager in relation
     */
    public function myOrders()
    {

      $orders = Order::whereIn('area_id',$this->myAreas)
      ->with([
        'orderstatus' => function($q){
          $q->select('id','name');
        },
        'company' => function($q){
          $q->select('id','name');
        }
        ])->orderBy('id', 'DESC')->paginate($this->maxPageRecords);
        
        return view('pages.manager.myorders', [
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
        'orderstatus_id'=> 1        
      ])
      ->whereIn('area_id',$this->myAreas)
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
        ])->orderBy('id', 'DESC')->paginate($this->maxPageRecords);

        return view('pages.manager.neworders', [
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
      if(!$id) return redirect(route('manager.dashboard')); 

      $order = Order::where('id', $id)->with([
        'orderstatus' => function($q)
        {
          $q->select('id','name');
        },
        'company' => function($q)
        {
          $q->select('id','name','address');
        },
        'user' => function($q)
        {
          $q->select('id','name','phone','email');
        },
        'orderitems' => function($q)
        {
          $q->select('id','order_id','name','quantity','price');
        }
      ])->first();
      
      if(is_null($order)) return redirect(route('manager.dashboard'));


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
        return view('pages.manager.orderdetails', [
          'pageConfigs' => $this->pageConfigs,
          'user' => $this->user,
          'order' => $order,
          'driver' => $driver,
          ]);
    }


    /**
     * Edit Profile - View
     * used : false
     * @method GET
     */
    public function editProfileView()
    {
        return view('pages.manager.editprofile', ['pageConfigs' => $this->pageConfigs, 'user' => $this->user]);
    }

    /**
     * Edit Profile - Update
     * 
     * used : true
     * @method POST
     */    
    public function editProfileUpdate(UserProfileUpdateRequest $request)
    {
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->save();
        // $user->driverprofile->age = $request->input('age');
        // $user->driverprofile->vehicle_no = $request->input('vehicle');
        // $user->driverprofile->gender = $request->input('gender');
        // $user->driverprofile->save();
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

    private function myAreaList()
    {
     $areas = AreaManager::where('user_id',$this->user->id)->get('area_id')->pluck('area_id');
     return $areas->toArray();
    }

    /**
     * No area Assigned to manager yet.
     */
    public function myNoAreas()
    {
      //dd($this->myAreas);
      if($this->myAreas)
      {
       return redirect(route('manager.dashboard'));
      }
        return view('pages.manager.noareas', ['pageConfigs' => $this->pageConfigs, 'user' => $this->user]);
    }

    /**
     * @method myTransactions
     * 
     * @description : All amounts that current manager
     *  have paid to drivers or received from drivers
     *  will be listed here.
     * 
     */
    public function myTransactions()
    {
      $transactions = $this->user->carryforwards()
       ->with('receiver:id,name')
       ->select(['id','receiver_id','amount','paid','received','updated_at'])
      ->orderBy('id', 'DESC')
      ->paginate($this->maxPageRecords);

      return view('pages.manager.my-transactions', [
        'pageConfigs' => $this->pageConfigs,
        'user' => $this->user,
        'transactions' => $transactions,
        ]);
    }

    /**
     * Give money to driver view.
     */
    public function createTransactionView()
    {
      $drivers = [];
      $collection = User::where('user_type',4)
      ->whereHas('driverprofile',function($q){
        $q->where('active',1);        
        $q->whereIn('area_id',$this->myAreas);        
      })
      ->select(['id','name'])
      ->get();
      $drivers = $collection->pluck('name','id');
      return view('pages.manager.create-transaction', [
        'pageConfigs' => $this->pageConfigs,
        'user' => $this->user,
        'drivers' => $drivers,
        ]);
    }

    /**
     * give money to driver save.
     */

    public function storeTransaction(TransactionRequest $request)
    {
      $this->user->carryforwards()->create([
        'receiver_id' => $request->receiver_id,
        'amount' => $request->amount,
        'paid' => $request->paid,
        'received' => $request->received,
      ]);

       return redirect(route('manager.createTransaction'))->with('success','Transaction created successfully.');
    }

    /**
     * Receive money from driver. -> update view
     */
    public function editTransactionView(\App\SystemPays $id)
    {
      $drivers = [];
      $collection = User::where('user_type',4)
      ->whereHas('driverprofile',function($q){
        $q->where('active',1);        
        $q->whereIn('area_id',$this->myAreas);        
      })
      ->select(['id','name'])
      ->get();
      $drivers = $collection->pluck('name','id');
      return view('pages.manager.edit-transaction', [
        'pageConfigs' => $this->pageConfigs,
        'user' => $this->user,
        'drivers' => $drivers,
        'transaction' => $id,
        ]);
    }


    /**
     * Receive money from driver. -> update save
     */
    public function editTransaction(TransactionRequest $request, \App\SystemPays $id)
    {
      $id->update($request->all());
      
      return redirect(route('manager.editTransaction',$id->id))->with('success','Transaction Updated successfully.');
    }

    /**
     * Order Settlements
     */
    /*
    All order with completed status get.
    with order_payment
    with settlement
    if order payment online -> then paid column willl be filled.
    if order payment is COD ->then received column will be filled.
     
     */
    public function orderSettlements()
    {
      $orders = Order::where('orderstatus_id',8)
       ->with([
        'payment'=>function($q){

        },
        'settlement' => function($q){

        }
       ])
      // ->select(['id'])
      ->orderBy('id', 'DESC')
      ->paginate($this->maxPageRecords);

      return view('pages.manager.order-settlements', [
        'pageConfigs' => $this->pageConfigs,
        'user' => $this->user,
        'orders' => $orders,
        ]);
    }

    public function completeSettlement(Order $id)
    {
      if(in_array($id->area_id,$this->myAreas))
      {
        //dd('com');
        $id->settlement()->update([
          'settler_id' => $this->user->id,
          'received' => 1
        ]);
      return redirect(route('manager.ordersettlements'))->with('success','Settlement completed successfully.');
      }
      return redirect(route('manager.dashboard'))->with('error','error Completing settlement.');
    }



}
