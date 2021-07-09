@isset($pageConfigs)
{!! Front::updatePageConfig($pageConfigs) !!}
@endisset
@php
$frontSettings = Front::frontSettings();
@endphp
@extends('layouts.static')
@section('content')

      <!---- Image banner--->
      <div class="section onlydesktop">
        @php
            $resturants_banner=Front::GetWidget('resturants_banner');
        @endphp
            @if(isset($resturants_banner))
            <img src="{{asset('images/restaurant-sample.png')}}">
                @else
                
                @endif
      </div>


<div class="ps-top-slider wsg-section-wrapper">
    <div class="container">
    <div class="row mt-40">
      <div class="col-md-8 col-sm-6 col-12">

      <h4>{{$companies['name']}} <span onclick="initMapStore();" class="restaurant-info" data-toggle="modal" data-target="#exampleModal"><img src="{{asset('images/info.png')}}" class="mb-10"></span>
      </div>
      <div class="pull-right col-md-4 col-sm-6 col-12">
        <div class="delivery-address">
      @include('panels.search')
        </div>
      </div>
  </div>


  <div class="locations-text">
  
<p class="color-medium">Restaurant available in {{$companies->locations->count() + 1}} locations</p>

  </div>
    </div>

  </div>
<div class="ps-top-slider wsg-section-wrapper">
  

<!-----slider 1----->
           <div class="ps-container">
              
            

<section class="ps-store-box mt-30">
   
    <div class="ps-section__content">
    <div class="infinite-scroll">
        <div class="row" id="contentSelector">
        @if ($companies)
        
            @include('storepanels.locations-list')

           

          
          @else
            <div class="col-md-12">
              <p>We don't find any result for your query..!!!</p>
            </div>
        @endif
        
        </div>
        <div class="ajax-load" id="pagination_loader"></div>
      </div> <!-- infinite scroll end--->
  </div>
</section>

        </div>
      
  <!-----slider 1 end----->

  <!-----slider 4----->
 
            <!-----slider 4 end----->      

</div> <!-------ps-top-slider------->          

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="close-popup">&times;</span>
        </button>
   
    <div class="">
    
<div class="account">

<div class="container">
<div class="text-login-mobile mt-20 mb-20">

<h6 class="color-medium text-center">Restaurant Details</h6>
</div>

<div id="map"></div>

<div class="res-information-main">

<div class="content-information">
<h6 class="text-body1 color-secondary">Address</h6>
<P class="text-subtitle color-medium">{{ $companies['address'] }}</P>
</div>
@if($companies['description'] != '')
<div class="content-information">
<h6 class="text-body1 color-secondary">Description</h6>
<P class="text-subtitle color-medium">{{ $companies['description'] }}</P>
</div>
@endif
<div class="workdays">
<h6 class="text-body1 color-secondary">Workdays</h6>
@foreach($workdays as $workday)
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
<style>
 .ps-form--photo-search .ps-form__content{
  padding-bottom: 0px;
 }
 .ps-form--photo-search button{
  right: 25px;
 }
 .ps-block--store .ps-block__content {
    padding: 0 0px 20px;
    /* border-top: 3px solid #17a2b8; */
}
.locations-text {
    margin-top: 15px;
}



.ps-form--photo-search .form-group--icon input {
    background-color: #F6F6F6;
    
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

</style>

<script>



@php 

    $address_book = null;
    if(Auth::user())
    {
        $address_book = \App\AddressBook::where(['user_id' =>Auth::user()->id,'active' => 1])->first();
    }
 
  $latitude_dest = $companies['latitude']+0.01;
  $longitude_dest = $companies['longitude']-0.01;
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
        myStartOrigin = new google.maps.LatLng({{$companies['latitude']}},{{$companies['longitude']}});
            myEndOrigin = new google.maps.LatLng({{$latitude_dest}}, {{$longitude_dest}});

            const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 30,
            center: myStartOrigin,
            });
            directionsRenderer.setMap(map);

            calcRoute();
            getDistance();
        }

</script>
<script src="{{asset('js/bh_custom.js')}}"></script>
@endsection