@isset($pageConfigs)
{!! Front::updatePageConfig($pageConfigs) !!}
@endisset
@php
$frontSettings = Front::frontSettings();
@endphp
@extends('layouts.static')
@section('content')
            <div class="ps-section--shopping ps-shopping-cart">
            <div class="container">

              
                <div class="ps-section__header d-none">
                    <h1>{{ trans('front.shipping_information') }}</h1>
                </div>
                <div class="ps-section__footer">
                <div class="row">
                    @include('bh_inc.address_add')

<!----left side---->
           <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12 checkout-left onlydesktop">
            <div class="inner">
                  <div class="alert alert-danger alert-dismissible fade show out-of-rang" role="alert" style="display: none;">Delivery address is out of range!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" ><span aria-hidden="true">&times;</span>
                </button>          
                </div>
                <input type="hidden" id="country" value="{{$company->country}}">
                <input type="hidden" id="limit_miles" value="{{setting('limit_range_miles')}}">
<input type="hidden" id="limit_km" value="{{setting('limit_range_km')}}">
                        <figure >
                        
                        <div class="label d-none" id="distanceandtime"></div>
                        <div id="mapcheckout"></div>
                        </figure>
                          </div>
                        </div>
    <!----right side------>             
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 checkout-right ">
                            <div class="inner">

 @php
$banner = $store->getFirstMedia('merchant_image');
    $storeimage='';
 if($banner){
    $storeimage=$banner->getUrl();
 }
@endphp                             
       <div class="cart-new">
                <div class="cart-store">
                    <div class="s-img">
                        <img  src="{{$storeimage}}" onerror="this.src='{{ asset(config('roms.cart.defaultThumbImage'))}}';" / alt="">
                    </div>
                    <h6 class="s-title">{{$store->name}}</h6>
                </div>

                <div class="cart-products">
                    @php
                      $total = 0;
                    @endphp

                     @foreach ($cartItems as $item)
                    @php
                      $total += $item['total'];
                    @endphp
                    <div class="cart-product">
                        <div class="cart-item-left">
                        <a href="javascript:void(0);">
                            <h6 class="cart-item-title">{{ $item['name'] }}</h6>
                        </a>
                         <div class="remove-item">
                                 <a href="{{ route('cartitemdelete',[$item['id']]) }}"><i class="icon-cross"></i></a>
                             </div>
                        </div>
                         <div class="cart-item-right">
                             <div class="price text-bdy2">{{ romsProPrice($item['total']) }}</div>
                            
                            <div class="form-group--number qty">
                                <button class="down minus">-</button>
                                <input class="form-control cartItemchange" type="text"
                                    value="{{ $item['quantity'] }}" readonly="readonly"
                                    data-cart-id="{{ $item['id']}}">
                                <button class="up plus">+</button>
                            </div>
                         </div>
                    </div>
                    @endforeach

                  @isset ($orderDetails['serviceFee'])
                  @php
                    $orderDetails['serviceFee'] = str_replace("%","",$orderDetails['serviceFee']);
                    $serviceFee = round($orderDetails['serviceFee'] * $total / 100,2);
                    $total += $serviceFee ;
                  @endphp
                  <div class="text-subtitle mt-20 mb-15">Order Detials</div>
                   <div class="cart_label text-bdy color-medium">
                    <p>Service Fee({{$orderDetails['serviceFee']}}%) </p>
                    <p>{{ str_replace(' ','',romsProPrice($serviceFee)) }}</p>
                   </div>
                   @endisset
                  
                  @isset ($orderDetails['shipping'])
                    @php
                        $total += $orderDetails['shipping'];
                    @endphp
                    <div class="cart_label text-bdy color-medium">
                      <p>Delivery</p>
                      <p> {{ str_replace(' ','',romsProPrice($orderDetails['shipping'])) }}
                      </p>
                    </div>
                  @endisset
                
                <div class="cart_label text-subtitle color-secondary">
                  <p>Total to pay</p>
                  <p>{{ str_replace(' ','',romsProPrice($total)) }}</p>
                </div>

 @if ($allowOrder)
{!! Form::open(['route'=> 'placeorder','method'=>'POST']) !!}
<button class="ps-btn ps-btn--fullwidth checkout-sbmt">{{ trans('front.place_order') }}</button>
{!! Form::close() !!}
@endif

                    </div> <!-----end products------>
                    </div>

                    </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>


@endsection

@section('page-scripts')  

<script>
function measureParms()
{
  myEndOrigin = $("#test_address").val();
  calcRoute();
}



@php 

  $address_book = \App\AddressBook::where(['user_id' =>Auth::user()->id,'active' => 1])->first();
  $latitude_dest =$store->latitude;
  $longitude_dest = $store->longitude;

 


if(Session::has('deliverydetails')){
  $latitude_dest = Session::get('deliverydetails.lat');
  $longitude_dest = Session::get('deliverydetails.lon');
}
  
  /*if(count((array) $address_book) > 0)
  {
    $latitude_dest = $address_book->latitude;
    $longitude_dest = $address_book->longitude;
  }*/

@endphp

  var myStartOrigin = 0.0;
  var myEndOrigin = 0.0;
  var directionsService = 0.0;
  var directionsRenderer = 0.0;


 function initMapStore() {
        
  var country=$('#country').val();
  var limit_miles=$('#limit_miles').val();
       var limit_km=$('#limit_km').val();
    directionsService = new google.maps.DirectionsService();
    directionsRenderer = new google.maps.DirectionsRenderer();

    myStartOrigin = new google.maps.LatLng({{$store->latitude}},{{$store->longitude}});
    myEndOrigin = new google.maps.LatLng({{$latitude_dest}}, {{$longitude_dest}});

        const mapcheckout = new google.maps.Map(document.getElementById("mapcheckout"), {
          zoom: 14,
          center: myStartOrigin,
        });
        directionsRenderer.setMap(mapcheckout);

      calcRoute();
      getDistance(country,limit_miles,limit_km);
      }
</script>
<script src="{{asset('js/bh_custom.js')}}"></script>
@endsection


@section('page-styles')
<style>
/* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
#map {
  height: 300px;
}
#mapcheckout {
  height: 300px;
}
.ps-section--shopping{
  background-color: #F6F6F6;
}
.checkout-left {
    padding-right:15px;
}
.checkout-left .inner{
    background-color: #fff;
    padding: 50px;
}
.checkout-right .inner{
    background-color: #fff;
    padding: 15px;
}

.cart_label {
    display: flex;
    flex-flow: row nowrap;
    justify-content: space-between;
    margin-right: 20px;
}
/* TAB*/
@media (max-width: 768px) {
.ps-section--shopping{
  background-color: #fff;
  }
.checkout-left .inner{
    padding: 20px 50px;
}
.checkout-right{
  flex: 100%;
  max-width: 100%;
}

}
</style>
@endsection