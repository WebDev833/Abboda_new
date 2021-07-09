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

              <div class="col-md-12 mb-5 d-none">
              <!-- input placeholder="Enter Dest Address tests" class="label" id="test_address"/><div class="btn btn-info" onClick="measureParms()">Calculate</div
               -->  
              <div class="label d-none" id="distanceandtime"></div>
              <div id="mapcheckout"></div> 
            </div>
                <div class="ps-section__header d-none">
                    <h1>{{ trans('front.shipping_information') }}</h1>
                </div>
                <div class="ps-section__footer">
                <div class="row">
                    @include('bh_inc.address_add')

<!----left side---->
           <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12 checkout-left">
            <div class="inner">
                  <div class="alert alert-danger alert-dismissible fade show out-of-rang" role="alert" style="display: none;">Delivery address is out of range!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" ><span aria-hidden="true">&times;</span>
                </button>          
                </div>
<input type="hidden" id="country" value="{{$company->country}}">
<input type="hidden" id="limit_miles" value="{{setting('limit_range_miles')}}">
<input type="hidden" id="limit_km" value="{{setting('limit_range_km')}}">
                        <figure>
                            <h5>Order Checkout</h5>
                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{session('success')}} <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            @endif


                                
                                <div class="address">
                                <div class="address-title">
                                 @if (Session::has('deliverydetails.address')) 
                                <i class="fa fa-map-marker"></i>  {{ Session::get('deliverydetails.address') }}  
                                 @endif   
                                </div>
                                 <div class="add-new-address">
                                  <i class="fa fa-map-marker" href="#add-new-address"  data-toggle="modal" data-target="#addAddressModel" onclick="loadModel()" >
                                   Add New</i>
                                 </div>

                                </div>

                               

                                {!! Form::open(['route'=>'updatetotals','class'=>'','method'=>'POST']) !!}
                                <input type='hidden' name="distance" id="form_distance" />
                                

                               
                                <div class="form-label-group">
                                {{ Form::select('address',$addresses, (session('deliverydetails.address_id')) ? session('deliverydetails.address_id') : 0, ['class'=>"ps-select input-field-mobile form-control","required"=>"required"]) }}
                                <label for="delivery Address">Delivery Address</label>
                                
                                </div>
                             

                                <div class="form-label-group">
                                  {{ Form::select('payment_method', [1=>'Cash on Delivery', 2=>'Online Payment'], (session('deliverydetails.payment_method')) ? session('deliverydetails.payment_method') : config::get('roms.dev.payment_method'), ['class'=>" input-field-mobile ps-select","required"=>"required","placeholder"=>trans('front.select_payment_method')]) }}
                                  <label for="paymentmethod">Payment Method</label>
                                </div>
                                <div class="form-label-group">
                                  {!! Form::textarea('note', (session('deliverydetails.note')) ? session('deliverydetails.note') : config::get('roms.dev.note'), ['class'=>' input-field-mobile form-control','placeholder'=> '','rows'=>'2']) !!}
                                  <label for="paymentmethod">Instructions (optional)</label>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="ps-btn ps-btn--fullwidth text-btn">Continue</button>
                                </div>
                              {!! Form::close() !!}
                            </figure>
                          </div>
                        </div>
    <!----right side------>             
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 checkout-right onlydesktop">
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

                    </div> <!-----end products------>
                    </div>

                    </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>


        
<!-- Modal -->
<div class="modal fade" id="addAddressModel" tabindex="-1" role="dialog" aria-labelledby="addAddressModelTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Add New Address</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="close-popup">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="model_body_ajax">
        Please wait....
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page-scripts')  

<script>
function makeDefaultAddress(id)
{
    $.post("{{route('user.addressBookupdateStatus')}}",{_token:'{{csrf_token()}}',id:id},function(data){

    })
}

function loadModel()
{
  $.get('{{route("addAddressApi")}}',{dup:true},function(data){
  $("#model_body_ajax").html(data);
});
}


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

.form-control:focus{
  background-color: #F6F6F6;
}
.add-new-address{
  cursor: pointer;
}
.address{
      display: flex;
    flex-flow: row nowrap;
    justify-content: space-between;
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
.cart-product:last-child {
    border-bottom: none;
}
/* TAB*/
@media (max-width: 768px) {
.ps-section--shopping{
  background-color: #fff;
  }
.checkout-left .inner{
    padding: 20px 50px;
}
.checkout-left{
  flex: 100%;
  max-width: 100%;
}

}

</style>

@endsection