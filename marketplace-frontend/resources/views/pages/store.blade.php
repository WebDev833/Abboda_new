@isset($pageConfigs)
{!! Front::updatePageConfig($pageConfigs) !!}
@endisset
@php
$frontSettings = Front::frontSettings();
@endphp

@extends('layouts.static')
@section('content')

@php
        $company_m = \App\Models\Company::find($store['company']['id']);
        $url_img = $store['company']['image'];
        $media = $company_m->getFirstMedia('store_images');
        
        if($media)
        {
        //  $url_img = asset('storage/store_images/'.$media['file_name']);
        $url_img = asset($media->getUrl());
        // echo $url_img;
        }
         $banner = $company_m->getFirstMedia('merchant_image');
         if($banner){
            $banner->getUrl();
         }
    @endphp
<div class="section text-center onlydesktop">

        <!--input placeholder="Enter Dest Address tests" class="label" id="test_address"/><div class="btn btn-info" onClick="measureParms()">Calculate</div-->
    @if($banner)
    <img src="{{asset($banner->getUrl())}}">
    @else
        <!-- <div class="label" id="distanceandtime"></div>
         -->
         <img src="{{asset('images/restaurant-sample.png')}}">
    @endif
</div>

<div class="ps-vendor-store">
    <div class="container">
	 
     @include('panels.success')
     @include('panels.errors')

<div class="store-title">
<h4>{{ $store['company']['name'] }} <span onclick="initMapStore();" class="restaurant-info" data-toggle="modal" data-target="#exampleModal"><img src="{{asset('images/info.png')}}" class="mb-10"></span>

@if(!$store['is_open'])
  <div class="btn btn-warning  pull-right"><i class="fa fa-info-circle"></i> Opening later</div>
  @endif
</h4>

<hr>
</div>
	
 @if($store['categories'])
<div id="foodmenu" class="mb-20">

<!--   <button class="btn btn-primary" id="slick-prev">prev</button>
<button class="btn btn-primary" id="slick-next">Next</button>
 -->
<div class="slick-slider" data-prev="#slick-prev" data-next="#slick-next" data-slick='{
   "draggable":true,
   "accessibility":false,
   "centerMode":false,
   "variableWidth":true,
   "slidesToShow":2,
   "slidesToScroll":1,
   "arrows":true,
   "dots":false,
   "swipeToSlide":true,
   "speed":300,
   "infinite":false,
   "responsive":[
      {
         "breakpoint":992,
         "settings":{
            "slidesToShow":4,
            "slidesToScroll":2
         }
      },
      {
         "breakpoint":768,
         "settings":{
            "slidesToShow":3,
            "slidesToScroll":1
         }
      },
      {
         "breakpoint":480,
         "settings":{
            "slidesToShow":2,
            "slidesToScroll":1
         }
      },
      {
         "breakpoint":0,
         "settings":{
            "slidesToShow":1.5,
            "slidesToScroll":1
         }
      }
   ]
}'>
     @php $i=1; @endphp
     @foreach ($store['categories'] as $category)
     @if ($category['name'] !='Popular Items')
    <div class="wsg-slide-foodmenu">
        <a @if($i ==1) class="active" @endif href="javascript:scrollToArea('tab-{{$category['id']}}');">{{$category['name']}}</a>
    </div>
     @php $i++; @endphp
    @endif
   
    @endforeach

 </div>

</div>
@endif
        <div class="ps-section__container roms--sidebar-container">
            {{-- 
            <div class="ps-section__left roms--sidebar">
                <div class="ps-block--vendor">
                    <div class="ps-block__thumbnail"><img src="{{ $url_img }}"
                            alt="{{ $store['company']['name']}}" title="{{ $store['company']['name']}}"
                            onerror="this.src='{{ asset(config('roms.store.defaultLogoImage'))}}';"></div>
													
                    <div class="ps-block__container">
                        <div class="ps-block__header">
                            <h4>{{ $store['company']['name'] }}</h4>
                            <select class="ps-rating" data-read-only="true">
                                @for ($rate = 0; $rate < 5; $rate++) @if($rate < $store['company']['rating']) <option
                                    value="1">1</option>
                                    @else
                                    <option value="2">2</option>
                                    @endif
                                    @endfor
                            </select>
                        </div>
                        <span class="ps-block__divider"></span>
                        <div class="ps-block__content">
                            <p>{{ $store['company']['description'] }}</p>
                            <span class="ps-block__divider"></span>
                            <p><strong>Address</strong> {{ $store['company']['address'] }}</p>
                        </div>
                        <div class="ps-block__footer d-none">
                            <p>Call us directly<strong>(+053) 77-637-3300</strong></p>
                            <p>or Or if you have any question</p><a class="ps-btn ps-btn--fullwidth" href="#">Contact
                                Seller</a>
                        </div>
                    </div>
                </div>
                <div class="ps-block--vendor">
                    <div class="ps-block__container">

                        <aside class="widget widget--vendor widget--open-time">
                            <h3 class="widget-title"><i class="icon-clock3"></i> Store Hours</h3>
                            <ul>
                                @foreach ($store['workdays'] as $workday)
                                <li><strong>{{ucfirst($workday['day'])}}
                                        :</strong><span>{{ romsStoreTime($workday['open_time'])}} -
                                        {{romsStoreTime($workday['close_time'])}}</span></li>
                                @endforeach
                            </ul>
                        </aside>
                        @if($store['categories'])
                        <aside class="widget widget--vendor">
                            <h3 class="widget-title">Store Categories</h3>
                            <ul class="ps-list--arrow">
                                @foreach ($store['categories'] as $category)
                                <li><a href="javascript:scrollToArea('tab-{{$category['id']}}');"
                                        data-cat-id="{{$category['id']}}">{{$category['name']}}</a></li>
                                @endforeach
                            </ul>
                        </aside>
                        @endif
                    </div>
                </div>
            </div>
            --}}

            <div class="ps-section-products">
                  @if (!$store['company']['acceptingOrders'])
                  {{--
                    <div class="roms--not-accepting-orders">
                      <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <h4 class="alert-heading">Attention!</h4>
                        <p class="mb-1">This store is not accepting currently, please checkout other stores in the system. This store is not accepting currently, please checkout other stores in the system. This store is not accepting currently, please checkout other stores in the system.</p>
                        <hr/>
                        <p class="mb-3">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    </div>
                    --}}
                  @endif
                <div class="ps-shopping ps-tab-root">
                    <div class="ps-tabs">
                        
                            @if($store['categories'])
                            @foreach ($store['categories'] as $category)
                            @if ($category['products'])
                            <div class="ps-tab active" id="tab-{{$category['id']}}">
                            <div class="ps-tab-content">
                            <h6 class="category-menu">{{$category['name']}}</h6>
                            @foreach ($category['products'] as $product)
                            {{-- {{romsShowProduct($product)}} --}}
                            <div class="ps-product ps-product--wide" data-cat-id="{{$category['id']}}">
                                <div class="ps-product__thumbnail"><a href="javascript:void(0);">
                                  <img src="{{ $product['image'] }}"
                            alt="{{ $product['name']}}" title="{{ $product['name']}}" onerror="this.src='{{ asset(config('roms.store.defaultProductImage'))}}';">
                            </a>
                                </div>
                                <div class="ps-product__container">
                                    <div class="ps-product__content"><a class="ps-product__title"
                                            href="javascript:void(0);">
                                        <h6>
                                        {{ $product['name']}}</h6></a>
                                        <div  class="ps-product__desc text-subtitle color-medium  mb-10">
                                        {{ $product['description']}}
                                        </div>

                                        <h6>{{ romsProPrice(round($product['price'],2)) }}</h6>

                                    </div>
                                    <div class="ps-product__shopping">
                                    <!-- @if(!$store['is_open'])
<div class="store-close">
<p class="text-subtitle1 color-medium">Store is closed!</p>
</div>

                                    @endif -->
                                        <a class="btn btn-primary text-btn add-item @if(!$store['is_open']) ps-disable "@else" href="{{ route('addtocartpage',[$product['id'],$childorParent['id']])}}" @endif>Add</a>

                                    </div>
                                </div>
                            </div>
                            @endforeach
                           </div>
                       </div>
                            @endif
                            @endforeach
                            @endif
                        
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
          <span aria-hidden="true">&times;</span>
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="close-popup">&times;</span>
        </button>
   
    <div class="main-content-mobile">
    
<div class="account">

<div class="container">
<div class="text-login-mobile mt-20 mb-20">

<h6 class="color-medium text-center">Restaurant Details</h6>
</div>

<div id="map"></div>

<div class="res-information-main">
<select class="ps-rating" data-read-only="true">
                                @for ($rate = 0; $rate < 5; $rate++) @if($rate < $store['company']['rating']) <option
                                    value="1">1</option>
                                    @else
                                    <option value="2">2</option>
                                    @endif
                                    @endfor
                            </select>
<div class="content-information">
<h6 class="text-body1 color-secondary">Address</h6>
<P class="text-subtitle color-medium">{{ $childorParent['address'] }}</P>
</div>
@if($childorParent['description'] != '')
<div class="content-information">
<h6 class="text-body1 color-secondary">Description</h6>
<P class="text-subtitle color-medium">{{ $childorParent['description'] }}</P>
</div>
@endif
<div class="workdays">
<h6 class="text-body1 color-secondary">Workdays</h6>
@foreach($store['workdays'] as $workday)
<div class="workdays-content-main">
    <div class="days-content">
    <p class="text-subtitle color-medium">{{ucfirst($workday['day'])}}</p>

    </div>
<div class="timing-content">
<p class="text-subtitle color-medium">{{ romsStoreTime($workday['open_time'])}} - {{romsStoreTime($workday['close_time'])}} </p>
</div>
</div>
@endforeach
</div>
</div>


</div>
</div>
    </div>
    </div>
  </div>
</div>
@endsection




@section('page-styles')
<script>


function measureParms()
{
	myEndOrigin = $("#test_address").val();
	calcRoute();
}

@php 

    $address_book = null;
    if(Auth::user())
    {
        $address_book = \App\AddressBook::where(['user_id' =>Auth::user()->id,'active' => 1])->first();
    }
 
  $latitude_dest = $childorParent['latitude'];
  $longitude_dest = $childorParent['longitude'];
/*
  if(count((array) $address_book) > 0)
  {
    $latitude_dest = $address_book->latitude;
    $longitude_dest = $address_book->longitude;
  }*/
if(Session::has('deliverydetails')){
  $latitude_dest = Session::get('deliverydetails.lat');
  $longitude_dest = Session::get('deliverydetails.lon');
}
@endphp
	var myStartOrigin = 0.0;
	var myEndOrigin = 0.0;
	var directionsService = 0.0;
	var directionsRenderer = 0.0;
    function initMapStore() {        
        directionsService = new google.maps.DirectionsService();
        directionsRenderer = new google.maps.DirectionsRenderer();
        myStartOrigin = new google.maps.LatLng({{$childorParent['latitude'] }},{{$childorParent['longitude'] }});
            myEndOrigin = new google.maps.LatLng({{$latitude_dest}}, {{$longitude_dest}});

            const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 30,
            center: myStartOrigin,
            });
            directionsRenderer.setMap(map);

            /* new google.maps.Marker({
                position: myStartOrigin,
                map,
                title: "{{$store['company']['name']}}",
            });*/
            calcRoute();
            getDistance();
        }


</script>

<script src="{{asset('js/bh_custom.js')}}"></script>

<style>
/* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
#map {
  height: 300px;
}
.owl-carousel.owl-loaded{
    max-height:50px;
}
div#foodmenu.sticky {
    border-bottom: solid 1px #eeee;
    padding: 10px;
    box-shadow: 5px 10px 18px #888888;
    background-color: #ffffff;
}


#foodmenu .wsg-slide-foodmenu a {
  display: inline-block;
  color: #212121;
  padding: 6px 20px;
  text-decoration: none;
  font-size: 14px;
  background: #F6F6F6;
  border: 1px solid #E0E0E0;
  box-sizing: border-box;
  border-radius: 32px;
  margin-top:10px;
  line-height: 20px;
  letter-spacing: 0.25px;
  overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    max-width: 150px;
}
#foodmenu a:hover ,#foodmenu a:active,#foodmenu a.active {
  background-color: #FF5A5F;
  color: #ffffff;
}
.sticky {
  position: fixed;
  top: 0px;
  width: 100%;
  z-index: 9;
  max-width: 1016px;
}
div#foodmenu .wsg-slide-foodmenu{
    display: inline-block;
}
.ps-tab-content{
    background-color: #ffffff;
}
.ps-tab{
    padding-top: 12px;
}
.add-item {
    margin: 0;
    position: absolute;
    top: 50%;
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
    right: 15px;
}
@media (min-width: 769px) {
.ps-product__content{
    padding-right: 50px;
}
}
div#foodmenu .wsg-slide-foodmenu:last-child {
    margin-right: 0px;
}
div#foodmenu .wsg-slide-foodmenu {
    margin-right: 15px;
}
.res-information-main {
    padding-top: 21px;
}
.workdays-content-main {
  display: flex;
    flex-flow: row; 
 }
 .days-content {
    max-width: 46px;
}
.timing-content {
    padding-left: 82px;
}
.main-content-mobile {
    background-color: white;
}
.ps-shopping {
    margin-top: 10px;
}

@media (max-width: 1199px) {

    .sticky{
        top: 0px;
        max-width: 930px;
          
    }
}
@media (max-width: 992px){
   .sticky{
  max-width: 690px;
}
}

@media (max-width: 768px){
  .sticky {
    top: 0px;
    left: 0;
    right: 0;
    max-width: 100%;
  }
  .add-item {
  
    right: 0px;
    padding: 7px 14px;
    font-size: 12px;
}
}
</style>

@endsection

@section('page-scripts')

<script type="text/javascript">
    $(function() {
        $("#foodmenu a").on(
            "click",
            function (e) {
                     $("#foodmenu a").removeClass("active");
                        $(this).addClass('active');
                    }
                );

    }); 
function loadModel()
{
  $.get('{{route("addAddressApi")}}',{},function(data){
  $("#model_body_ajax").html(data);
});
}
</script>


@endsection