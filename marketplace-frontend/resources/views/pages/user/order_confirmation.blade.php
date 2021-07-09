@extends('pages.user.userlayout')
@section('userpage')
@php
$banner = $order->company->getFirstMedia('merchant_image');
    $storeimage='';
 if($banner){
    $storeimage=$banner->getUrl();
 }
@endphp

<div class="main-order-details d-flex flex-row justify-content-between">
    
<div class="roms--order-detail">  
@include('panels.success')
    @include('panels.errors')

    <div class="order-detail-left text-center">

<div class="order-confirm-image">
<img src="{{asset('images/food-tray.png')}}">
</div>

<div class="confirm-order-content">

<div class="order-status-title">
<h5>Order Placed Successfully!</h5>
</div>
<div class="order-status-detail">
<p class="text-body1 color-medium">Your order been placed. We are looking fr drivers near you. </p>
</div>

<div class="order-confirm-btn">
<a href="{{route('user.orderDetails',['id'=>$order->id])}}" class="sign-mobile btn btn-danger" >ORDER DETAILS</a>
</div>

</div>



</div>
    </div>
<div class="order-detail-right onlydesktop">
<div class="main-right-order">
<div class="merchant-details d-flex flex-row">

<div class="merchant-image">
<img  src="{{$storeimage}}" onerror="this.src='{{ asset(config('roms.cart.defaultThumbImage'))}}';" / alt="">
</div>
<div class="merchant-content">
<h7 class="text-subtitle color-secondary">{{$order->company->name}}</h7>
<p class="text-caption color-medium">{{$order->company->address}}</p>
</div>
</div>


<div class="new-order-items-main"> 

<div class="order-items">
@php
    $itemtotal = 0;
  @endphp
@foreach ($order->orderitems as $item)
@php
      $itemtotal += $item['price'];
   @endphp
<div class="order-item1 d-flex flex-row justify-content-between">

<div class="item-name">
<h7 class="text-subtitle2 color-he ">{{$item->name}}</h7>
</div>
<div class="item-price">
    <div class="item-price-show">
<h7 class="text-body1 color-medium">{{ romsProPrice($item->price,false)}}</h7>
    </div>

<div class="form-group--number qty">
                                <button class="down minus">-</button>
                                <input class="form-control cartItemchange" type="text"
                                    value="{{ $item['quantity'] }}" readonly="readonly"
                                    data-cart-id="{{ $item['id']}}">
                                <button class="up plus">+</button>
                            </div>
</div>


</div>
<hr>
@endforeach

</div>
<h7 class="text-subtitle color-he">Order Details</h7>
<div class="order-item1 d-flex flex-row justify-content-between">

<div class="item-name">
<h7 class="text-body1 color-medium">Items total</h7>
</div>
<div class="item-price">
<h7 class="text-body1 color-medium">{{ romsProPrice($itemtotal,false) }}</h7>
</div>


</div>
<div class="order-item1 d-flex flex-row justify-content-between">

<div class="item-name">
<h7 class="text-body1 color-medium">Delivery fee</h7>
</div>
<div class="item-price">
<h7 class="text-body1 color-medium">{{romsProPrice($order->shipping_charges,false)}}</h7>
</div>


</div>
<div class="order-item1 d-flex flex-row justify-content-between">

<div class="item-name">
<h7 class="text-body1 color-medium">Service charges</h7>
</div>
<div class="item-price">
<h7 class="text-body1 color-medium">{{romsProPrice($order->service_fee,false)}}</h7>
</div>


</div>
<hr>
<div class="order-item1 d-flex flex-row justify-content-between">

<div class="item-name">
<h7 class="text-subtitle color-secondary">Total Ammount</h7>
</div>
<div class="item-price">
<h7 class="text-subtitle color-secondary">{{romsProPrice($order->total,false)}}</h7>
</div>


</div>
</div>
</div>
</div>
</div>




{{--<div class="roms--order-detail">  
    @include('panels.success')
    @include('panels.errors')
     <h4 class="mb-4">Order Details</h4>
@if (in_array($order->orderstatus->id,[7]))
    <div class="row">
    <div class="col-md-12" id="map-show" style="display: none;" >
    <div class="label" id="distanceandtime"></div>
    <div id="map"></div> 
    </div>   
    </div>
@endif


    @if (in_array($order->orderstatus->id,[1,7]))
      <div class="row">
        <div class="col-md-12">
          <div class="roms--cancel-order-block text-right">            
        @if ( in_array($order->orderstatus->id,[1]) && Front::datetimeDiffrance($order->created_at,'','Minutes') < 4)
            <span>
             <a href="{{ route('user.cancelorder',['id'=>$order->id]) }}" class="btn btn-sm btn-danger mb-4">Cancel Order</a>
             </span>
        @endif
        @if (in_array($order->orderstatus->id,[7]))
            <a href="javascript:void(0)" onclick="ToggleMap();" class="ps-btn ps-btn--sm bg-info mb-4"><i class="fa fa-eye"></i> Driver Location</a>
         @endif
          </div>
        </div>
      </div>
     @endif

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table ps-table--compare">
                    <tbody>
                        <tr>
                            <td class="heading"># Order ID</td>
                            <td>{{ $order->unique_order_id}}</td>
                            <td class="heading">Order Status</td>
                            <td id="order-status">{{ $order->orderstatus->name }} @if ($driver && in_array($order->orderstatus->id,[1,7])) ({{$driver['name']}}) @endif</td>
                        </tr>
                        <tr>
                            <td class="heading">Name</td>
                            <td>{{$order->user->name}}</td>
                            <td class="heading">Phone</td>
                            <td>{{ $order->user->phone }}</td>
                        </tr>
                        <tr>
                            <td class="heading">Email</td>
                            <td>{{ $order->user->email }}</td>
                            <td class="heading">Address</td>
                            <td>{{ $order->address }}</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <h4 class="mt-5 mb-5">Order Items</h4>
    <div class="row">
        <div class="col-md-12">
          
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Quanity</th>
                            <th>Available</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($order->orderitems as $item)
                        <tr>
                            <td>{{$item->name}}</td>
                            <td>{{$item->quantity}}</td>
                            <td>@if($item->isavailable === 1) <i class="btn btn-sm btn-success">Yes</i> @elseif($item->isavailable === 0) <i class="btn btn-sm btn-danger">No</i> @endif</td>
                            <td>{{ romsProPrice($item->price,false)}}</td>
                        </tr> 
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if ($driver)
    <h4 class="mt-5 mb-5">Driver Details</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table ps-table--compare">
                    <tbody>
                        <tr>
                            <td class="heading">Driver Name</td>
                            <td>{{$driver['name']}}</td>
                            <td class="heading">Driver Vehicle</td>
                            <td>{{$driver['vehicle']}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
    @endif
    <h4 class="mt-5 mb-5">Merchant Details</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table ps-table--compare">
                    <tbody>
                        <tr>
                            <td class="heading">Merchant Name</td>
                            <td>{{$order->company->name}}</td>
                            <td class="heading">Merchant Address</td>
                            <td>{{$order->company->address}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <h4 class="mt-5 mb-5">Payment Details</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table ps-table--compare">
                    <tbody>
                        <!-- <tr>
                            <td class="heading">Items Cost</td>
                            <td>$540</td>
                            <td class="heading">Delivery Cost</td>
                            <td>$60</td>
                        </tr>  -->
                        <tr>
                            <td class="heading">Payment Type</td>
                            @if ($order->payment_method == 1)
                              <td>Cash on Delivery</td>
                            @else
                              <td>Online Payment</td>
                            @endif                            
                            <td class="heading">Order Total</td>
                            <td>{{romsProPrice($order->total,false)}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>--}}

@endsection

@php
//orign
$latitude_origin =$order->ordergps->driver_lat;
$longitude_origin = $order->ordergps->driver_lon;

// dest
if($order->orderstatus->id==7){
 $latitude_dest = $order->ordergps->drop_lat;
 $longitude_dest = $order->ordergps->drop_lon;
}else{
 $latitude_dest = $order->company->latitude;
 $longitude_dest = $order->company->longitude;  
}
@endphp

@section('page-scripts')
<script>
    var openorder=0;
    @if(in_array($order->orderstatus->id,[6,7]))
    var myStartOrigin = 0.0;
    var myEndOrigin = 0.0;
    var directionsService = 0.0;
    var directionsRenderer = 0.0;
    var openorder={{Front::IsactiveOrder(Auth::user()->id,Auth::user()->user_type,$order->id)}};

    var latitude_origin={{$latitude_origin}};
    var longitude_origin={{$longitude_origin}};
    var latitude_dest={{$latitude_dest}};
    var longitude_dest={{$longitude_dest}};

    function getDestiantionLocation(){
        if(openorder > 0){
            $.ajax({
            url:'/user/get-destiantion-Location/{{$order->id}}',
            type:'get',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            beforeSend:function(){}}
            ).done(function(data){
                console.log(data.error);
                if(data.error == false){
                    latitude_dest=data.lat;
                    longitude_dest=data.lon;
                    $("#order-status").html(data.orderStatus);

                    initMapStore();
                }
            }).fail(function(jqXHR,ajaxOptions,thrownError){ });
        }//if close
    }

    initMapStore();
   

    function initMapStore() {
            
        directionsService = new google.maps.DirectionsService();
        directionsRenderer = new google.maps.DirectionsRenderer();

            myStartOrigin = new google.maps.LatLng(latitude_origin,longitude_origin);
            myEndOrigin = new google.maps.LatLng(latitude_dest,longitude_dest);

            const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 14,
            center: myStartOrigin,
            });
            directionsRenderer.setMap(map);

            /* new google.maps.Marker({
                position: myStartOrigin,
                map,
                title: "{{$order->company->name}}",
            });*/
            calcRoute();
            getDistance();
        }
@endif
</script>

<script src="{{asset('js/bh_custom.js')}}"></script>

<style>
/* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
#map {
  height: 300px;
}
.order-details {
    display: flex;
    
}
.roms--order-detail {
    background-color: white;

    padding: 27px;
}
.order-detail-right {
    background-color: white;
    width: 27vw;
    margin-right: 14px;
}
.merchant-content {
    padding-left: 17px;
}

.main-right-order {
    padding: 13px;
}
.ps-store-list .ps-section__right {
    background-color: #F6F6F6;
}

.main-order-status {
    background-color: antiquewhite;
    border-radius: 4px;
    margin-top: 20px;
}
.order-status-content{
    padding: 5px;
}
.order-items-detail {
    margin-top: 25px;
}
.order-detail-left {
    margin-top: 16px;
}

.new-order-items-main {
    padding-top: 9px;
}
.item-price {
    display: flex;
    flex-flow: column;
    text-align: end;
}
@media (max-width: 768px){
    .ps-store-list .ps-section__right {
     padding-bottom: 0px !important; 
}
}
</style>
@endsection
