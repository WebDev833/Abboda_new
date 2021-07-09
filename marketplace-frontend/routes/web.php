<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/switch-lang/{lang?}', 'StaticPagesController@switchLanguage')->name('switchlang');

Route::get('/', 'StaticPagesController@homePage')->name('home');

Route::get('/deliver-with-abboda', 'DriverController@drivewithabboda')->name('drivewith');

Route::post('/deliver-save', 'DriverController@deliverabbodapost')->name('deliverpost');
/*Route::get('/about-us', 'StaticPagesController@aboutUs')->name('aboutus');
Route::get('/our-services', 'StaticPagesController@ourServices')->name('ourservices');
Route::get('/contact-us', 'StaticPagesController@contactUs')->name('contactus');
*/
Auth::routes();

/*
Route::get('/home', 'HomeController@index')->name('home');
 */

/**
 * User Login Routes -
 * @ Login - GET - Show Login Form
 * @ Login - POST - Login user
 */
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');



Route::post('/login', 'Auth\LoginController@login')->name('loginPost');
Route::get('/driver-login', 'Auth\LoginController@showdriverlogin')->name('driver.login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

/** Social Login URL start */
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider')->name('socialLogin');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
/** Social Login URL end */

/**
 * User Register Routes -
 * @ Register - GET - Show Register Form
 * @ Register - POST - Register user
 */
Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');

Route::post('/register', 'Auth\RegisterController@register')->name('registerform');

Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('forgotpasswordpage');

Route::post('/password/reset', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('sendResetLinkEmail');

/**
 *
 * Authenticated customer Routes.
 *
 */
Route::group(['prefix' => 'user', 'middleware' => 'customer'], function () {


    /* get open order location of driver*/
    Route::get('/get-destiantion-Location/{id}', 'UserController@getDestiantionLocation')->name('user.getDestiantionLocation');
    Route::get('/status-Auto-Update', 'UserController@statusAutoUpdate')->name('user.statusAutoUpdate');
    
    /**
     * only user routes.
     */
    /**
     * Cart Routes
     *
     * Add item to cart
     * Cart Page
     * Cart Item Delete
     * Update Cart Items
     */
    Route::get('/add-to-cart/{product}/{restaurant}', 'UserController@addItemToCart')->name('addtocartpage');

    Route::get('/cart', 'UserController@myCart')->name('cartpage');

    Route::get('/cart-item-delete/{id}', 'UserController@deleteCartItem')->name('cartitemdelete');

    Route::post('/update-cart', 'UserController@updateCart')->name('updatecart');

    /**
     * Create Order Routes
     *
     * Shipping Page
     * Update totals -> refresh to sync the shipping details
     * Checkout Page
     *
     *
     */
    //  Route::get('/shipping', 'UserController@myShipping')->name('shippingpage');
    Route::post('/update-totals', 'UserController@updateDeliveryDetails')->name('updatetotals');

    Route::get('/checkout', 'UserController@myCheckout')->name('checkoutpage');
    Route::get('/checkout-confirm', 'UserController@myCheckoutconfirm')->name('checkoutpageconfirm');

    Route::post('/place-order', 'UserController@myPlaceOrder')->name('placeorder');

    Route::post('/tips', 'UserController@tipssave')->name('user.tipssave');


    Route::get('payment', 'UserController@onlinePaymentView')->name('user.onlinePayment');

    Route::post('/complete-payment', 'UserController@completeOnlinePayment')->name('user.completePayment');

    Route::get('/order-confirmation/{id}', 'UserController@myOrderPlacedConfirmation')->name('orderconfirmationpage')->where('id', '[0-9]+');

    Route::get('/my-dashboard', 'UserController@dashboard')->name('user.dashboard');
    Route::get('/my-orders', 'UserController@myOrders')->name('user.myorders');

    Route::get('/edit-profile', 'UserController@editProfileView')->name('user.editProfilepage');

    Route::post('/edit-profile', 'UserController@editProfileUpdate')->name('user.editProfilePost');

    Route::get('/order-details/{id}', 'UserController@orderDetails')->name('user.orderDetails')->where('id', '[0-9]+');

    Route::get('/cancel-order/{id}', 'UserController@cancelOrder')->name('user.cancelorder')->where('id', '[0-9]+');

});


/**
 * 
 *  Address Book by AIMFOX 
 * 
 */

 
Route::get('/my-addresses', 'UserController@showAddress')->name('user.addressBook');
Route::post('/my-addresses', 'UserController@saveAddress')->name('user.addressBookSave');
Route::post('/my-addresses/update', 'UserController@updateAddressStatus')->name('user.addressBookupdateStatus');

Route::get('/test_x', function(){

    $prodcuts = App\ModelsByBabar\Product::where('price','LIKE','$%')->get();
    foreach($prodcuts as $product)
    {
        $pricexx = str_replace("$","",$product->price);
        $product->price = $pricexx;
        $product->save();
        echo $pricexx."<br>";
    }

});

/**
 *
 * Authenticated driver Routes.
 *
 */

Route::group(['prefix' => 'driver', 'middleware' => 'driver'], function () {

    Route::get('/', 'DriverController@dashboard')->name('driver.dashboard');
    Route::get('/my-dashboard', 'DriverController@dashboard')->name('driver.dashboard1');

    Route::post('/go-online', 'DriverController@goOnline')->name('driver.goOnline');
    Route::get('/status-Auto-Update', 'DriverController@StatusAutoUpdate')->name('driver.StatusAutoUpdate');
    Route::get('/get-destiantion-Location/{id}', 'DriverController@getDestiantionLocation')->name('driver.getDestiantionLocation');


    Route::get('/my-orders', 'DriverController@myOrders')->name('driver.myorders');
    Route::get('/new-orders', 'DriverController@newOrders')->name('driver.neworders');
    Route::get('/my-ratings', 'DriverController@myRatings')->name('driver.myratings');
    Route::get('/my-earnings', 'DriverController@myEarnings')->name('driver.myearnings');

    Route::get('/edit-profile', 'DriverController@editProfileView')->name('driver.editProfilepage');

    Route::post('/edit-profile', 'DriverController@editProfileUpdate')->name('driver.editProfilePost');

    Route::get('/order-details/{id}', 'DriverController@orderDetails')->name('driver.orderDetails')->where('id', '[0-9]+');
    Route::post('/update-order/{id}', 'DriverController@updateOrder')->name('driver.updateOrder')->where('id', '[0-9]+');

    Route::get('/accept-order/{id}', 'DriverController@acceptOrder')->name('driver.acceptorder')->where('id', '[0-9]+');

    Route::get('/cancel-order/{id}', 'DriverController@cancelOrder')->name('driver.cancelorder')->where('id', '[0-9]+');

    Route::get('/pickup-order/{id}', 'DriverController@pickupOrder')->name('driver.pickuporder')->where('id', '[0-9]+');

    Route::get('/complete-order/{id}', 'DriverController@completeOrder')->name('driver.completeorder')->where('id', '[0-9]+');
    
    Route::get('/delivery-details/{id}', 'DriverController@deliveryDetails')->name('driver.deliverydetails')->where('id', '[0-9]+');

});

/**
 * Authenticated Manager Routes.
 */
Route::group(['prefix' => 'manager', 'middleware' => 'manager'], function () {

    Route::get('/noareas', 'ManagerController@myNoAreas')->name('manager.noareas');

    Route::get('/my-dashboard', 'ManagerController@dashboard')->name('manager.dashboard');

    Route::get('/my-orders', 'ManagerController@myOrders')->name('manager.myorders');

    Route::get('/new-orders', 'ManagerController@newOrders')->name('manager.neworders');

    Route::get('/order-details/{id}', 'ManagerController@orderDetails')->name('manager.orderDetails')->where('id', '[0-9]+');

    Route::get('/edit-profile', 'ManagerController@editProfileView')->name('manager.editProfilepage');

    Route::post('/edit-profile', 'ManagerController@editProfileUpdate')->name('manager.editProfilePost');

    /**
     * Manager Specific
     */

    /**
     * System pays
     */
    Route::get('/my-transactions', 'ManagerController@myTransactions')->name('manager.transactions');

    Route::get('/transaction/create', 'ManagerController@createTransactionView')->name('manager.createTransaction');

    Route::post('/transaction/create', 'ManagerController@storeTransaction')->name('manager.storeTransaction');

    Route::get('/transaction/{id}/edit', 'ManagerController@editTransactionView')->name('manager.editTransaction')->where('id', '[0-9]+');

    Route::patch('/transaction/{id}/edit', 'ManagerController@editTransaction')->name('manager.editTransaction')->where('id', '[0-9]+');

    /**
     * Order settlements
     */
    Route::get('/order-settlements', 'ManagerController@orderSettlements')->name('manager.ordersettlements');

    Route::get('/complete-settlement/{id}/edit', 'ManagerController@completeSettlement')->name('manager.completeSettlement')->where('id', '[0-9]+');

});

/**
 * Authenticated Admin Routes.
 */
Route::group(['prefix' => 'admin', 'middleware' => ['admin', 'backend']], function () {

    /**
     * admin redirect to /dashboard
     */
    Route::get('/', function () {
        return redirect(route('admin.dashboard'));
    });

    /**
     * Admin Dashboard
     */
    Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');

    Route::get('/edit-profile', 'AdminController@adminProfile')->name('admin.myprofile');
    Route::patch('/edit-profile', 'AdminController@adminProfileSave')->name('admin.myprofilesave');

    Route::post('/addsubmerchant', 'AdminController@addsubmerchant')->name('admin.addsubmerchant');
    /**
     * Dynamic Pages Modules
     */
    Route::get('/add-page', 'AdminController@addPage')->name('admin.addpage');
    Route::post('/add-page', 'AdminController@addPageSave')->name('admin.addpageSave');

    Route::get('/edit-page/{page}', 'AdminController@editPage')->name('admin.editpage');

    Route::patch('/edit-page/{page}', 'AdminController@editPageSave')->name('admin.editpageSave');

    Route::get('/pages', 'AdminController@allPages')->name('admin.allpages');
    Route::get('/legal-pages', 'AdminController@legalPages')->name('admin.legalpages');

    Route::get('/delete-page/{page}', 'AdminController@deletePage')->name('admin.deletepage');
    
    Route::get('/delete-location/{id}/{merchantid}', 'AdminController@deletelocation')->name('admin.deletelocation');

    /**
     * Static Pages
     */

    // Route::get('/edit-static-page/{page}', function(){
    //   return view('admin.pages.editstaticpage');
    // })->name('admin.editstaticpage');

    Route::get('/static-pages', 'AdminController@allStaticPages')->name('admin.allstaticpages');

    // page Secti
    Route::get('/add-section', 'AdminController@addSection')->name('admin.addsection');
    Route::post('/add-section', 'AdminController@addSectionSave')->name('admin.addsectionSave');

    Route::get('/edit-section/{section}', 'AdminController@editSection')->name('admin.editsection');

    Route::patch('/edit-section/{section}', 'AdminController@editSectionSave')->name('admin.editsectionSave');

    Route::get('/sections', 'AdminController@allSections')->name('admin.allsections');

    Route::get('/delete-section/{section}', 'AdminController@deleteSection')->name('admin.deletesection');

    /**
     * Appearance Module
     */

    Route::group(['as' => 'admin.'], function () {
        // settlement
        Route::resource('widgets', 'WidgetController', ['except' => ['show', 'destroy']]);
        Route::get('widgets/{widget}/delete', 'WidgetController@destroy')->name('widgets.destroy');
    });

    /**
     * Media Library
     */
    // All media
    Route::get('/medias', 'UploadController@index')->name('admin.medias');
    Route::get('/uploads/all/{collection?}', 'UploadController@all')->name('admin.allmedia');
    Route::get('/uploads/collectionsNames', 'UploadController@collectionsNames')->name('admin.collectionsnames');
    Route::post('/uploads/clear', 'UploadController@clear')->name('admin.mediadelete');
    Route::post('/uploads/store', 'UploadController@store')->name('admin.mediascreate');

    /**
     * Users
     */
    // customers
    Route::get('/customers', 'AdminController@customers')->name('admin.customers');

    //managers
    Route::get('/managers', 'AdminController@managers')->name('admin.managers');

    Route::get('/add-manager', 'AdminController@addManager')->name('admin.addmanager');
    Route::post('/add-manager', 'AdminController@addManagerSave')->name('admin.addmanagersave');

    Route::get('/edit-manager/{manager}', 'AdminController@editManager')->name('admin.editmanager');

    Route::patch('/edit-manager/{manager}', 'AdminController@editManagerSave')->name('admin.editmanagersave');

    Route::get('/delete-manager/{manager}', 'AdminController@deleteManager')->name('admin.deletemanager');

    Route::post('/remove-manager-avatar', 'AdminController@removeManagerAvatarMedia')->name('admin.deletemanagermedia');

    //drivers
    Route::get('/drivers', 'AdminController@drivers')->name('admin.drivers');

    Route::get('/add-driver', 'AdminController@addDriver')->name('admin.adddriver');
    Route::post('/add-driver', 'AdminController@addDriverSave')->name('admin.adddriversave');

    Route::get('/edit-driver/{driver}', 'AdminController@editDriver')->name('admin.editdriver');

    Route::patch('/edit-driver/{driver}', 'AdminController@editDriverSave')->name('admin.editdriversave');

    Route::get('/delete-driver/{driver}', 'AdminController@deleteDriver')->name('admin.deletedriver');

    Route::post('/remove-driver-avatar', 'AdminController@removeDriverAvatarMedia')->name('admin.deletedriveravatarmedia');
    Route::post('/remove-driver-identity-image', 'AdminController@removeDriverIdentityMedia')->name('admin.deletedriveridentitymedia');

    /**
     * -------------------------------------------------------------------
     * Region module
     */

    // country
    Route::get('/countries', 'AdminController@countries')->name('admin.countries');

    Route::get('/add-country', 'AdminController@addCountry')->name('admin.addcountry');
    Route::post('/add-country', 'AdminController@addCountrySave')->name('admin.addcountrysave');

    Route::get('/edit-country/{country}', 'AdminController@editCountry')->name('admin.editcountry');

    Route::patch('/edit-country/{country}', 'AdminController@editCountrySave')->name('admin.editcountrysave');

    Route::get('/delete-country/{country}', 'AdminController@deleteCountry')->name('admin.deletecountry');

    //state
    Route::get('/states', 'AdminController@states')->name('admin.states');

    Route::get('/add-state', 'AdminController@addState')->name('admin.addstate');
    Route::post('/add-state', 'AdminController@addStateSave')->name('admin.addstatesave');

    Route::get('/edit-state/{state}', 'AdminController@editState')->name('admin.editstate');

    Route::patch('/edit-state/{state}', 'AdminController@editStateSave')->name('admin.editstatesave');

    Route::get('/delete-state/{state}', 'AdminController@deleteState')->name('admin.deletestate');

    //city
    Route::get('/cities', 'AdminController@cities')->name('admin.cities');

    Route::get('/add-city', 'AdminController@addCity')->name('admin.addcity');
    Route::post('/add-city', 'AdminController@addCitySave')->name('admin.addcitysave');

    Route::get('/edit-city/{city}', 'AdminController@editCity')->name('admin.editcity');

    Route::patch('/edit-city/{city}', 'AdminController@editCitySave')->name('admin.editcitysave');

    Route::get('/delete-city/{city}', 'AdminController@deleteCity')->name('admin.deletecity');

    // Areas
    Route::get('/areas', 'AdminController@areas')->name('admin.areas');

    Route::get('/add-area', 'AdminController@addArea')->name('admin.addarea');
    Route::post('/add-area', 'AdminController@addAreaSave')->name('admin.addareasave');

    Route::get('/edit-area/{area}', 'AdminController@editArea')->name('admin.editarea');

    Route::patch('/edit-area/{area}', 'AdminController@editAreaSave')->name('admin.editareasave');

    Route::get('/delete-area/{area}', 'AdminController@deleteArea')->name('admin.deletearea');
/**
 * -------------------------------------------------------------------------
 */

    // Area manager
    Route::get('/area-managers', 'AdminController@areaManagers')->name('admin.areamanagers');
    Route::get('/add-area-manager', 'AdminController@addAreaManager')->name('admin.addareamanager');
    Route::post('/add-area-manager', 'AdminController@addAreaManagerSave')->name('admin.addareamanagersave');
    Route::get('/delete-area-manager/{am}', 'AdminController@deleteAreaManager')->name('admin.deleteareamanager');

    // Merchants
    Route::get('/merchants', 'MerchantController@index')->name('admin.merchants');

    Route::get('/add-merchant', 'MerchantController@create')->name('admin.addmerchant');
    Route::post('/add-merchant', 'MerchantController@store')->name('admin.addmerchantsave');

    Route::get('/edit-merchant/{merchant}', 'MerchantController@edit')->name('admin.editmerchant');

    Route::post('/edit-locations', 'MerchantController@editlocations')->name('admin.editlocations');

    Route::patch('/edit-merchant/{merchant}', 'MerchantController@update')->name('admin.editmerchantsave');

    Route::get('/delete-merchant/{merchant}', 'MerchantController@destroy')->name('admin.deletemerchant');
    Route::post('/remove-merchant-image', 'MerchantController@removeMerchantImageMedia')->name('admin.deletemerchantimagemedia');

    Route::post('/get-merchant-categories', 'MerchantController@categories')->name('admin.merchantcategories');

    /**
     * Categories
     */
    Route::get('/categories', 'CategoryController@index')->name('admin.categories');

    Route::get('/add-category', 'CategoryController@create')->name('admin.addcategory');
    Route::post('/add-category', 'CategoryController@store')->name('admin.addcategorysave');

    Route::get('/edit-category/{category}', 'CategoryController@edit')->name('admin.editcategory');

    Route::patch('/edit-category/{category}', 'CategoryController@update')->name('admin.editcategorysave');

    Route::get('/delete-category/{category}', 'CategoryController@destroy')->name('admin.deletecategory');

    Route::post('/remove-category-image', 'CategoryController@removeCategoryImageMedia')->name('admin.deletecategoryimagemedia');

    /**
     * Workdays
     */
    Route::get('/workdays', 'WorkdayController@index')->name('admin.workdays');

    Route::get('/add-workday', 'WorkdayController@create')->name('admin.addworkday');
    Route::post('/add-workday', 'WorkdayController@store')->name('admin.addworkdaysave');

    Route::get('/edit-workday/{workday}', 'WorkdayController@edit')->name('admin.editworkday');

    Route::patch('/edit-workday/{workday}', 'WorkdayController@update')->name('admin.editworkdaysave');

    Route::get('/delete-workday/{workday}', 'WorkdayController@destroy')->name('admin.deleteworkday');

    /**
     * Products
     */
    Route::get('/products', 'ProductController@index')->name('admin.products');

    Route::get('/add-product', 'ProductController@create')->name('admin.addproduct');
    Route::post('/add-product', 'ProductController@store')->name('admin.addproductsave');

    Route::get('/edit-product/{product}', 'ProductController@edit')->name('admin.editproduct');

    Route::patch('/edit-product/{product}', 'ProductController@update')->name('admin.editproductsave');

    Route::get('/delete-product/{product}', 'ProductController@destroy')->name('admin.deleteproduct');

    Route::post('/remove-product-image', 'ProductController@removeProductImageMedia')->name('admin.deleteproductimagemedia');

    // Fianace

    Route::group(['as' => 'admin.'], function () {
        /**
         * Transaction Resource
         */
        Route::resource('transactions', 'TransactionController', ['except' => ['show', 'destroy']]);
        Route::get('transactions/{transaction}/delete', 'TransactionController@destroy')->name('transactions.destroy');

        // settlement
        Route::resource('settlements', 'SettlementController', ['except' => ['show', 'destroy']]);
        Route::get('settlements/{settlement}/delete', 'SettlementController@destroy')->name('settlements.destroy');

        //Online payments
        Route::get('online-payments', 'AdminController@onlinePayments')->name('onlinepayments');

    });

    // Orders
    Route::get('/orders', 'OrderController@index')->name('admin.orders');
    Route::get('/view-order/{order}', 'OrderController@show')->name('admin.vieworder');

    // Settings
    Route::get('/front-settings', 'AdminController@frontSettings')->name('admin.frontsettings');
    Route::patch('/front-settings', 'AdminController@frontSettingsSave')->name('admin.frontsettingssave');

    Route::post('/remove-media', 'AdminController@removeMedia')->name('admin.removemedia');
    Route::get('/restaurants-import', 'AdminController@restaurantsImport')->name('admin.restaurantsImport');
    Route::post('/restaurants-import', 'AdminController@restaurantsImportSave')->name('admin.restaurantsImportSave');


});

Route::group(['prefix' => 'superdev', 'middleware' => 'superdev'], function () {
    Route::get('/dashboard', 'SuperdevController@dashboard');
});
//
/**
 * E-commerce Routes
 */

//Route::get('/store', 'StaticPagesController@myStore')->name('store');

/**
 * Main store Routes
 *
 */

/**
 * Store Types
 */
Route::get('/restaurants/{type?}', 'StaticPagesController@allRestaurants')->name('restaurants');
Route::get('/locations/{slug?}', 'CompanyController@showlocations')->name('locations');
Route::get('/grocery-stores', 'StaticPagesController@allGroceryStores')->name('grocerystores');
Route::get('/medical-stores', 'StaticPagesController@allMedicalStores')->name('medicalstores');

/**
 * Search Page
 */

Route::get('/search-tags', 'DataStoreController@searchTags')->name('searchtags');
Route::get('/search{keyword?}', 'CompanyController@search')->name('search');
Route::POST('/setDeliveryaddress', 'UserController@setdeliveryaddress')->name('setdeliveryaddress');

/**
 * Single store
 */
Route::get('/store/{slug?}', 'CompanyController@show')->name('store');

Route::get('/merchants/{country?}', 'CompanyController@merhcantcountry')->name('merhcantcountry');


Route::get('/test', 'StaticPagesController@myTestPage');

/*
* Tests
*/
Route::get('/testmap', 'Test@loadMapTest')->name('loadMapTest');

//This should at the end for pages.

Route::get('/add-address-api', 'UserController@addAddressApi')->name('addAddressApi');

Route::get('/testb', 'BhTestController@sendmail')->name('test');
Route::get('commandimport/{slug?}', function ($slug) {
    /* php artisan migrate */
    $cmds = array('wsg:companyimporter','wsg:productimporter');
    if(in_array($slug, $cmds))
    {
         \Artisan::call($slug);
         dd("Done");
    }else{
        dd('invalid');
    }
});

Route::get('/{slug?}', 'StaticPagesController@showpage')->name('page');

