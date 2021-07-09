<?php

namespace App\Http\Controllers;

use App\AcceptOrder;
use App\Cart;
use App\Helpers\Front;
use App\Http\Requests\UserProfileUpdateRequest;
use App\Http\Resources\ProfileResource;
use App\Models\Product;
use App\Order;
use App\OrderGps;
use App\OrderItem;
use App\Providers\RouteServiceProvider;
use Auth;
use Config;
use Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Redirect;
use Session;

class UserController extends Controller
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
     * Attaching middleware to user.
     */
    public function __construct()
    {
        //  $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = $this->myProfile();
            return $next($request);
        });

        // core user profile....
    }

    /**
     * Add Item in cart
     *
     * Used : true
     */

    public function addItemToCart($pid = null)
    {
        // if pid null or not exist
        if (is_null($pid) || is_null($product = Product::where(['id' => intval($pid), 'in_stock' => 1, 'active' => 1])->first())) {
            return Redirect::back();
        }

        // check cart have items
        $cartItems = Cart::where(['user_id' => $this->user->id])->get();

        // if no items directly add item to cart
        if (!$cartItems->toArray()) {
            Cart::create([
                'company_id' => $product->company_id,
                'user_id' => $this->user->id,
                'product_id' => $product->id,
                'quantity' => 1,
            ]);

            // message cart item added..
        } // if cart have items -> select first item company_id
        elseif ($product->company_id === $cartItems->toArray()[0]['company_id']) {
            // check if product already in the cart ?
            if (count(array_intersect([$product->id], $cartItems->pluck('product_id')->toArray()))) {
                // already in cart
                // show message -> This item already in cart.
            } else {
                // this product not in cart
                Cart::create([
                    'company_id' => $product->company_id,
                    'user_id' => $this->user->id,
                    'product_id' => $product->id,
                    'quantity' => 1,
                ]);
            }
        } else {
            // message show...
            //dd('Your cart have items from another store. You can only order from one store at a time.');
        }
        // redirect back to store.
        return Redirect::back();
    }

    /**
     * Quick cart Delete :)
     */
    public function deleteCartItem($id = null)
    {
        if (intval($id)) {
            Cart::destroy($id);
        }
        return Redirect::back();
    }

    /**
     * Cartpage
     * completed : true
     */
    public function myCart()
    {
        /*
        Need to check login user
        if user logged inthen continue
        if not logged in
        then say You must be logged in to add and edit your cart items
         */
        // Our middleware doing this for us.

        /*
        get item of cart for this user.

        if logged in show items of the cart. or if no items
        in the cart then show no items in the cart.
         */

        // for cart page
        $carts = Cart::where(['user_id' => $this->user->id])->with([
            'product' => function ($cartItem) {
                $cartItem->with('media');
            },
        ])->get();

        $cartItems = new Collection();
        foreach ($carts as $cart) {
            $cartItems->push([
                'id' => $cart->id,
                'quantity' => $cart->quantity,
                'name' => $cart->product->name,
                'price' => Front::myPriceRound($cart->product->price),
                'image' => Front::myMediaUrl($cart->product, 'product_image', 'icon'),
                'total' => Front::myCartItemTotal($cart->product->price, $cart->quantity),
            ]);
        }
        $pageConfigs = [
            'newsletter' => true,
            'breadcrumb' => true,
            'title' => 'Cart Page',
        ];
        return view('pages.cart', [
            'pageConfigs' => $pageConfigs,
            'cartItems' => $cartItems->toArray(),
        ]);
    }

    /**
     * Update cart
     * compelted : true
     */
    public function updateCart(Request $request)
    {
        $ids = explode(',', trim($request->input('cartids')));
        $qtys = explode(',', trim($request->input('quantities')));
        // dd([$ids,$qtys]);
        $carts = array_combine($ids, $qtys);
        foreach ($carts as $id => $qty) {
            Cart::where('id', $id)->update(['quantity' => $qty]);
        }
        return redirect(route('cartpage'));
    }

    /**
     * Update delivery details
     * completed: false
     * validation pending..
     */
    public function updateDeliveryDetails(Request $request)
    {
        /*
        check the request (validation) and if all good
        Add delivery details to user session.
         */

        // get data from session and redirect back.
        Session::put('deliverydetails', [
            'address' => $request->input('address'),
            'lat' => $request->input('lat'),
            'lon' => $request->input('lon'),
            'note' => $request->input('note'),
            'payment_method' => $request->input('payment_method'),
        ]);
        return redirect(route('checkoutpage'));
    }
    /**
     * Checkout page
     * completed : false
     */
    public function myCheckout()
    {

        /*
        check user have items in the cart ?
        if have then continue otherwise redirect to homepage..
        if have items check have delivery details like -
        - delivery address.
        - lat.
        - lon.
        - Note (instructions to driver).

        if not having delivery details then do not show place order procedure.
        if have then autofill the delivery address and lat, lon, note.
        Get order details like -
        - cart items with detail.
        - delivery charges based on delivery address.  // this need to be calculated.
        // may be more but for now that\'s all.
         */

        /**
         * check user have items in the cart ?
         * if have then continue otherwise redirect to homepage..
         */
        if (Auth::user()->getCartCount() <= 0) {
            return redirect(route('home'));
        }

        /**
         * Order item details
         */
        $carts = Cart::where(['user_id' => $this->user->id])->with([
            'product' => function ($cartItem) {
                $cartItem->select('id', 'company_id', 'name', 'price');
            },
        ])->get();

        $cartItems = new Collection();
        foreach ($carts as $cart) {
            $cartItems->push([
                'id' => $cart->id,
                'quantity' => $cart->quantity,
                'name' => $cart->product->name,
                'total' => Front::myCartItemTotal($cart->product->price, $cart->quantity),
            ]);
        }

        $orderDetails = [
            'items' => $cartItems->toArray(),
            'serviceFee' => config::get('roms.frontSettings.front_service_charges'),
        ];

        /**
         * cart have items
         * check for delivery details
         */

        $allowOrder = false;
        if ($orderDetails['items']) {

            if (Session::get('deliverydetails')) {
                /*
                get distance between pick and drop.
                if distance lies under fixed shipping
                then go ahead otherwise calculate shipping
                by km shipping method.
                and then add deliverydetails and shipping to the orderdetails.
                 */
                $distance = Front::calcDistance(
                    $carts[0]->product->company_id, [
                        'lat' => Session::get('deliverydetails.lat'),
                        'lon' => Session::get('deliverydetails.lon'),
                    ]);
                if ($distance) {
                    $orderDetails['shipping'] = Front::getDeliveryCharges($distance);
                    $allowOrder = true;
                } else {
                    // we can log here to check distance ?
                    // for now just reset the address stuff i.e delivery details adddress..
                    session()->forget(['deliverydetails.address', 'deliverydetails.lat', 'deliverydetails.lon']);
                }
            }
        }

        $pageConfigs = [
            'newsletter' => true,
            'breadcrumb' => true,
            'title' => 'Checkout Page',
        ];
        return view('pages.checkout', [
            'pageConfigs' => $pageConfigs,
            'orderDetails' => $orderDetails,
            'allowOrder' => (bool) $allowOrder,
        ]);
    }

    /**
     *
     * Place order
     * @request - POST
     * @description - main method hadling order placement.
     * @date - 06-05-2020
     *
     * */
    public function myPlaceOrder(Request $request)
    {

        /**
         * check user have items in the cart ?
         * if have then continue otherwise redirect to homepage..
         *
         */
        if (Auth::user()->getCartCount() <= 0) {
            return redirect(route('home'));
        }

        /**
         * Order item details
         */
        $carts = Cart::where(['user_id' => $this->user->id])->with([
            'product' => function ($cartItem) {
                $cartItem->select('id', 'company_id', 'name', 'price');
            },
        ])->get();

        $total = 0;
        $cartItems = new Collection();
        foreach ($carts as $cart) {
            $cartItems->push([
                'id' => $cart->id,
                'product_id' => $cart->product->id,
                'quantity' => $cart->quantity,
                'name' => $cart->product->name,
                'total' => ($thistotal = Front::myCartItemTotal($cart->product->price, $cart->quantity)),
            ]);
            $total += $thistotal;
        }

        $orderDetails = [
            'items' => $cartItems->toArray(),
            'serviceFee' => config::get('roms.frontSettings.front_service_charges'),
        ];

        if ($orderDetails['items']) {
            if (Session::get('deliverydetails')) {
                $distance = Front::calcDistance(
                    $carts[0]->product->company_id, [
                        'lat' => Session::get('deliverydetails.lat'),
                        'lon' => Session::get('deliverydetails.lon'),
                    ]);
                if ($distance) {
                    $orderDetails['shipping'] = Front::getDeliveryCharges($distance);
                } else {
                    return redirect(route('orderconfirmationpage', ['status' => 'error']));
                }
            }
        }

        // company serving the order
        $company = \App\Models\Company::select('id', 'area_id')->findOrfail($carts[0]->product->company_id);
        $total += round(($orderDetails['serviceFee'] + $orderDetails['shipping']), 2);

        /**
         * start working with order
         */
        $newOrder = new Order();

        $lastOrder = Order::orderBy('id', 'desc')->first();

        if ($lastOrder) {
            $lastOrderId = $lastOrder->id;
            $newId = $lastOrderId + 1;
            $uniqueId = Hashids::encode($newId);
        } else {
            //first order
            $newId = 1;
        }
        $uniqueId = Hashids::encode($newId);
        $unique_order_id = 'OD' . '-' . date('m-d') . '-' . strtoupper($uniqueId);

        $newOrder->unique_order_id = $unique_order_id;
        $newOrder->area_id = $company->area_id;

        $newOrder->company_id = $company->id;
        $newOrder->user_id = $this->user->id;
        $newOrder->total = $total;
        $newOrder->address = session('deliverydetails.address');
        $newOrder->note = session('deliverydetails.note');
        $newOrder->payment_method = session('deliverydetails.payment_method');
        $newOrder->journey_kms = $distance;
        $newOrder->service_fee = $orderDetails['serviceFee'];
        $newOrder->shipping_charges = $orderDetails['shipping'];
        $newOrder->orderstatus_id = ($newOrder->payment_method == 2) ? 9 : 1; // this need to be 0 for online payment for smooth flow...
        $newOrder->save();

        foreach ($orderDetails['items'] as $orderItem) {
            $item = new OrderItem();
            $item->order_id = $newOrder->id;
            $item->product_id = $orderItem['id'];
            $item->name = $orderItem['name'];
            $item->quantity = $orderItem['quantity'];
            $item->price = $orderItem['total'];
            $item->save();
        }

        // add to GPS table --
        $ordergps = new OrderGps();
        $ordergps->order_id = $newOrder->id;
        $ordergps->drop_lat = session('deliverydetails.lat');
        $ordergps->drop_lon = session('deliverydetails.lon');
        $ordergps->save();

        // 2 for online payment - handle online payments..
        if ($newOrder->payment_method == 2) {
            // implement online payment
            // here save order to session ->
            // release payment view for the payment.
            session::put('onOrderDtls', [
                'order_id' => $newOrder->id,
                'unique_order_id' => $newOrder->unique_order_id,
                'amount' => $newOrder->total,
            ]);
            // empty cart and session for this order.
            Cart::where(['user_id' => $this->user->id])->delete();
            // clear delivery details.
            session()->forget(['deliverydetails']);

            return redirect(route('user.onlinePayment'));
        } else {
            //COD -> Cash on delivery
            // empty cart and session for this order.
            Cart::where(['user_id' => $this->user->id])->delete();
            // clear delivery details.
            session()->forget(['deliverydetails']);

            return redirect(route('orderconfirmationpage', ['status' => 'success']));
        }
    }

    /**
     *
     * Complete Online Payment View Page
     *
     */
    public function onlinePaymentView()
    {
        // here need a check that
        // this url only callable when necessary :) its not a joke baby.
        if (session('onOrderDtls') && session('onOrderDtls.amount') && session('onOrderDtls.order_id') && session('onOrderDtls.unique_order_id')) {
            $order = [];
            $order['amount'] = session('onOrderDtls.amount');
            $order['order_id'] = session('onOrderDtls.order_id');
            $order['unique_order_id'] = session('onOrderDtls.unique_order_id');
            // Forgot the session to disable reload payment.
            session()->forget(['onOrderDtls']);
        } else {
            // error in order session.
            return redirect(route('home'));
        }
        // check intent
        if ($intent = $this->stripePaymentIntent($order)) {
            return view('pages.user.online-payment', [
                'pageConfigs' => $this->pageConfigs,
                'user' => $this->user,
                'order' => $order,
                'payment' => $intent,
            ]);
        }

        // Go to hell..!!!
        return redirect(route('home'));
    }

    /**
     * Create intent for the client to charge a card.
     *
     *
     * @return json
     */
    private function stripePaymentIntent($order = [])
    {
        $order['publish_key'] = config::get('roms.frontSettings.front_stripe_key');
        $order['secret_key'] = config::get('roms.frontSettings.front_stripe_secret');
        $order['currency'] = config::get('roms.frontSettings.front_payment_currency');
        /*
        $order['amount'] = '5000';
        $order['order_id'] = 5;
        $order['unique_order_id'] = '331242';
         */
        $order['event'] = 'Order Payment for #' . $order['order_id'];

        \Stripe\Stripe::setApiKey($order['secret_key']);

        $intent = \Stripe\PaymentIntent::create([
            'amount' => ($order['amount'] * 100),
            'currency' => $order['currency'],
            'metadata' => [
                'event' => $order['event'],
                'unique_order_id' => $order['unique_order_id'],
            ],
        ]);

        // check for intent.
        // if do so -> return otherwise. or payment issue.
        return [
            'publishableKey' => $order['publish_key'],
            'clientSecret' => $intent->client_secret,
        ];
    }

    /**
     * Complete Online Order Payment
     *
     * AJAX Function
     */
    public function completeOnlinePayment(Request $request)
    {
      // if all goes good
      // add the online payment to the system. 
      // and then add the order payment 
      // order settlement. 
      
        if (!$request->input('order_id')) {
            return redirect(route('home'));
        }
       $id = $request->input('order_id');
       $order = Order::where('id', $id)->first();

        if(is_null($order))
        {
            return redirect(route('home'));
        }

      if ($order->payment_method == 2) {
          $item_costs = ($order->total - ($order->service_fee + $order->shipping_charges));

          $order->onlinepayment()->create([
            'amount' => $request->input('amount'),
            'status' => $request->input('status'),
          ]);

          $order->payment()->create([
              'payment_type' => $order->payment_method,
              'amount' => $order->total,
              'system_amount' => Front::calcSystemAmount(($order->total - $item_costs)),
              'driver_amount' => Front::calcDriverAmount(($order->total - $item_costs)),
              'item_costs' => $item_costs,
          ]);
          $order->orderstatus_id = 1; // order start now becouse payment started. -> flow back to normal. 
        }
        // create settlement to :)
        $order->settlement()->create([
            'received' => 0,
        ]);
        $order->save();

        //return redirect(route('orderconfirmationpage', ['status' => 'success']));

        return response()->json(['error'=>false]);

    }

    /**
     * Order placed successfully page
     */
    public function myOrderPlacedConfirmation(Request $request)
    {
        $pageConfigs = [
            'newsletter' => true,
            'breadcrumb' => true,
            'title' => 'Order Confirmaton Page',
        ];

        if ($request->query('status') == 'success') {
            $pageConfigs['data'] = [
                'success' => true,
            ];
        } else {
            $pageConfigs['data'] = [
                'success' => false,
            ];
        }
        return view('pages.order_confirmation', ['pageConfigs' => $pageConfigs]);
    }

    /**
     * Dashboard
     *
     * @method dashboard
     */
    public function dashboard()
    {
        // For now let it empty.

        // return view('pages.user.dashboard', ['pageConfigs' => $this->pageConfigs]);

        // get orders
        $orders = Order::where('user_id', $this->user->id)->with([
            'orderstatus' => function ($q) {
                $q->select('id', 'name');
            },
            'company' => function ($q) {
                $q->select('id', 'name');
            },
        ])->orderBy('id', 'DESC')->get();

        return view('pages.user.myorders', [
            'pageConfigs' => $this->pageConfigs,
            'user' => $this->user,
            'orders' => $orders,
        ]);
    }

    /**
     * MY Orders
     *
     */
    public function myOrders()
    {

        // get orders
        $orders = Order::where('user_id', $this->user->id)->with([
            'orderstatus' => function ($q) {
                $q->select('id', 'name');
            },
            'company' => function ($q) {
                $q->select('id', 'name');
            },
        ])->orderBy('id', 'DESC')->get();

        return view('pages.user.myorders', [
            'pageConfigs' => $this->pageConfigs,
            'user' => $this->user,
            'orders' => $orders,
        ]);
    }

    /**
     * Order Details
     */
    public function orderDetails($id = null)
    {
        if (!$id) {
            return redirect(route('user.dashboard'));
        }

        $order = Order::where('id', $id)->with([
            'orderstatus' => function ($q) {
                $q->select('id', 'name');
            },
            'company' => function ($q) {
                $q->select('id', 'name', 'address');
            },
            'user' => function ($q) {
                $q->select('id', 'name', 'phone', 'email');
            },
            'orderitems' => function ($q) {
                $q->select('id', 'order_id', 'name', 'quantity', 'price');
            },
        ])->first();

        if (is_null($order)) {
            return redirect(route('user.dashboard'));
        }

        // get driver details
        $driver = [];
        if (in_array($order->orderstatus->id, [6, 7, 8])) {
            $cOrder = AcceptOrder::where([
                'order_id' => $order->id,
                'active' => 1,
            ])
                ->with('driver:user_id,vehicle_no', 'driver.user:id,name')
                ->first();

            if (!is_null($cOrder)) {
                $driver['name'] = $cOrder->driver->user->name;
                $driver['vehicle'] = $cOrder->driver->vehicle_no;
            }
        }
        // FALSE - if do not want to show sidebar
        $this->pageConfigs['showProfileSidebar'] = true;
        // to do
        // order details get
        return view('pages.user.orderdetails', [
            'pageConfigs' => $this->pageConfigs,
            'user' => $this->user,
            'order' => $order,
            'driver' => $driver,
        ]);
    }

    /**
     * cancelOrder
     *
     * used : true
     */
    public function cancelOrder($id = null)
    {
        if (!$id) {
            return redirect(route('user.dashboard'));
        }

        $order = Order::where('id', $id)->first();

        if (is_null($order)) {
            return redirect(route('user.dashboard'));
        }

        $order->orderstatus_id = 3; // order cancelled by user.
        $order->save();

        return redirect()->back()->with('success', 'Order Updated Successfully.');

    }

    /**
     * Edit Profile
     */
    public function editProfileView()
    {
        return view('pages.user.editprofile', ['pageConfigs' => $this->pageConfigs, 'user' => $this->user]);
    }

    /**
     * Edit Profile
     */
    public function editProfileUpdate(UserProfileUpdateRequest $request)
    {
        $this->user->name = $request->input('name');
        $this->user->phone = $request->input('phone');
        $this->user->save();
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
