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
    <div class="notfordesktop">
    <div class="merchant-details d-flex flex-row">

<div class="merchant-image">
<img  src="{{$storeimage}}" onerror="this.src='{{ asset(config('roms.cart.defaultThumbImage'))}}';" / alt="">
</div>
<div class="merchant-content">
<h7 class="text-subtitle color-secondary">{{$order->company->name}}</h7>
<p class="text-caption color-medium">{{$order->company->address}}</p>
</div>
</div>

@if (in_array($order->orderstatus->id,[8]) && !$order->tip_amount)

<div class="edit-btn order-tips">

<button type="button" class="btn-xm btn-success" style="float: right;"  data-toggle="modal" data-target="#exampleModal">Tip</button>
</div>
@endif
<div class="main-order-status">

<div class="order-status-content text-center">
<h7 class="color-medium text-caption">Order Status</h7>
<h6 class="color-secondary">{{ $order->orderstatus->name }} @if ($driver && in_array($order->orderstatus->id,[1,7])) ({{$driver['name']}}) @endif</h6>
</div>

</div>

    </div>



@if (in_array($order->orderstatus->id,[7]))
    <div class="row">
    <div class="col-md-12" id="map-show" style="display: block;" >
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
   
          </div>
        </div>
      </div>
     @endif
     <div class="new-order-items-main notfordesktop"> 
<div class="order-items-detail">
<h6 class="color-secondary">Items you ordered</h6>
</div>
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
<h7 class="text-body1 color-medium">{{$item->name}}</h7>
</div>
<div class="item-price">
<h7 class="text-body1 color-medium">{{ romsProPrice($item->price,false)}}</h7><br>

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
</div>
<hr>
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
<div class="order-item1 d-flex flex-row justify-content-between">
@if (in_array($order->orderstatus->id,[8]) && $order->tip_amount)
<div class="item-name">
<h7 class="text-body1 color-medium">Tip Amount</h7>
</div>
<div class="item-price">
<h7 class="text-body1 color-medium">{{romsProPrice($order->tip_amount,false)}}</h7>
</div>
@endif

</div>
<hr>
<div class="order-item1 d-flex flex-row justify-content-between">

<div class="item-name">
<h7 class="text-subtitle color-secondary">Total Amount</h7>
</div>
<div class="item-price">
<h7 class="text-subtitle color-secondary">{{romsProPrice($order->total+$order->tip_amount,false)}}</h7>
</div>


</div>
</div>
    <div class="order-detail-left">

<h6 class="mb-4 color-secondary">Order Details</h6>

<div class="main-content-detail">
<div class="order-details d-flex flex-row justify-content-between">

<div class="order-id"> 
<h7 class="text-body2 color-medium">Order ID</h7>
<p class="text-subtitle color-secondary">{{ $order->unique_order_id}}</p>
</div>

<div class="payment-type"> 
    <h7 class="text-body2 color-medium">payment type</h7>
    <p class="text-subtitle color-secondary"> @if ($order->payment_method == 1)
                              Cash on Delivery
                            @else
                              Online Payment
                            @endif  </p>
</div>

</div>
<div class="order-address">
<h7 class="text-body2 color-medium">Address</h7>
<p class="text-subtitle color-secondary">{{ $order->address }}</p>
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

   

@if (in_array($order->orderstatus->id,[8]) && !$order->tip_amount)

<div class="edit-btn order-tips">

<button type="button" class="btn btn-success" style="float: right;"  data-toggle="modal" data-target="#exampleModal">Tip</button>
</div>
@endif
<div class="main-order-status">

<div class="order-status-content text-center">
<h7 class="color-medium text-caption">Order Status</h7>
<h6 class="color-secondary " id="order-status">{{ $order->orderstatus->name }} @if ($driver && in_array($order->orderstatus->id,[1,7])) ({{$driver['name']}}) @endif</h6>
</div>

</div>
<div class="new-order-items-main"> 
<div class="order-items-detail">
<h6 class="color-secondary">Items you ordered</h6>
</div>
<div class="order-items">
@php
    $itemtotal = 0;
    $minusitemsprice = 0;
  @endphp
@foreach ($order->orderitems as $item)
@php

      $itemtotal += $item['price'];
      if ($item->isavailable===0) {
          $minusitemsprice +=$item['price'];
      }
     
   @endphp
<div class="order-item1 d-flex flex-row justify-content-between">

<div class="item-name">
<h7 class="text-body1 color-medium">{{$item->name}}@if($item->isavailable===0)(N/A)@elseif($item->isavailable===1)(Available)@endif</h7>
</div>
<div class="item-price">
<h7 class="text-body1 color-medium">{{ romsProPrice($item->price,false)}}</h7>

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

</div>
<hr>
<div class="order-item1 d-flex flex-row justify-content-between">

<div class="item-name">
<h7 class="text-body1 color-medium">Items total</h7>
</div>
<div class="item-price">
<h7 class="text-body1 color-medium">{{ romsProPrice($itemtotal,false) }}</h7>
</div>


</div>
@if($minusitemsprice > 0)
<div class="order-item1 d-flex flex-row justify-content-between">

<div class="item-name">
<h7 class="text-body1 color-medium">N/A Items</h7>
</div>
<div class="item-price">
<h7 class="text-body1 color-medium">{{ romsProPrice($minusitemsprice,false) }}</h7>
</div>


</div>
@endif
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
<div class="order-item1 d-flex flex-row justify-content-between">
@if (in_array($order->orderstatus->id,[8]) && $order->tip_amount)
<div class="item-name">
<h7 class="text-body1 color-medium">Tip Amount</h7>
</div>
<div class="item-price">
<h7 class="text-body1 color-medium">{{romsProPrice($order->tip_amount,false)}}</h7>
</div>
@endif

</div>
<hr>
<div class="order-item1 d-flex flex-row justify-content-between">

<div class="item-name">
<h7 class="text-subtitle color-secondary">Total Amount</h7>
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="close-popup">&times;</span>
        </button>
   
    <div class="main-content-mobile">
    
<div class="account">

<div class="container">
{!! Form::model($user, ['route'=>'user.tipssave','class'=>'ps-form--account ps-tab-root','method'=>'POST']) !!}


<input type="hidden" class="input-field-mobile form-control" name="order_id" value="{{ $order->id}}">
<div class="text-login-mobile mt-20 mb-20">

<h6 class="color-medium text-center">Tips</h6>
</div>

<div class="form-label-group">


                   

<input type="text" class="input-field-mobile form-control" placeholder="Enter Amount" name="tip_amount">
                        <label for="inputEmail">Amount</label>
                    </div>
                    <div class="form-label-group">
                                <select class="input-field-mobile form-control" id="paymentmethod" name="tip_payment_method">
                                <option selected>
                                ---select payment method---
                                </option>
                                <option value="1">
                                Cash on delivery
                                </option>
                                <option value="2">
                                Online payment
                                </option>
                                </select>
                                  <label for="paymentmethod">Payment Method</label>
                                </div>
                   
                    
                <div class="form-group sign-in-btn">
                        <button type="submit"
                            class="sign-mobile btn btn-danger" >SAVE CHANGES</button>
                      
                    </div>

{!! Form::close() !!}
</div>
</div>
    </div>
    </div>
  </div>
</div>
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
    margin-right: 18px;
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
.edit-btn.order-tips {
    margin-bottom: 45px;
}
@media (max-width: 768px){
    .ps-store-list .ps-section__right {
     padding-bottom: 0px !important; 
}
}

element.style {
}
.ps-store-list .ps-section__right {
    padding-bottom: 19px;
}
@media (min-width: 769px){
.ps-store-list .ps-section__right {
  
    background-color: #F6F6F6;
  
}
}
</style>
@endsection
