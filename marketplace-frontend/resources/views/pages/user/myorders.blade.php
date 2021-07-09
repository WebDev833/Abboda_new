@extends('pages.user.userlayout')
@section('userpage')

    <div class="roms--orders">
        <h5 class="mt-5 color-secondary ml-3">My Orders</h5>
        @if ($orders->count())
                    @foreach ($orders as $order)
                    @php
$banner = $order->company->getFirstMedia('merchant_image');
    $storeimage='';
 if($banner){
    $storeimage=$banner->getUrl();
 }
@endphp
       <a href="{{route('user.orderDetails',['id'=>$order->id])}}"> 
         <div class="main-content-profile addresses orders-flex">
<div class="orders-flex-left">
    <div class="order-image">
    <img  src="{{$storeimage}}" onerror="this.src='{{ asset(config('roms.cart.defaultThumbImage'))}}';" / alt="">
     </div>
     <div class="order-content">
    <h7 class="text-body2 color-medium">{{ $order->unique_order_id }}</h7>
<h6 class="text-subtitle color-secondary">{{$order->company->name}}</h6>
<h7 class="text-body2 color-medium">{{ $order->orderstatus->name }}</h7>
     </div>

</div>
  <div class="order-price">
<p class="text-subtitle color-secondary">{{romsProPrice($order->total,false)}}</p>

  </div>
</div>
<hr class="notfordesktop">
       </a>
@endforeach
                  @else
                  <div class="main-content-profile addresses orders-flex">
                      <h5>No Orders Yet!!!</h5>

</div>
                  @endif
      {{--  <div class="row">
        <div class="col-md-12">
        <div class="table-responsive roms--myorders">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Order Status</th>
                        <th>Merchant Name</th>
                        <th>Order Total</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  @if ($orders->count())
                    @foreach ($orders as $order)
                      <tr>
                          <td>{{ $order->unique_order_id }}</td>
                          <td>{{ $order->orderstatus->name }} </td>
                          <td>{{ str_limit($order->company->name, 20) }}</td>
                          <td>{{ romsProPrice($order->total,false) }}</td>
                          <td>{{ str_limit($order->address, 20) }}</td>
                          <td><a href="{{route('user.orderDetails',['id'=>$order->id])}}" class="roms--orderdetails-link"><i class="fa fa-eye"></i> Details</a></td>
                      </tr>
                    @endforeach
                  @else
                      <tr class="no-row-exist"><td colspan="6" class="p-4 text-center">No orders Yet..!!!</td></tr>
                  @endif
                </tbody>
            </table>
        </div>
        </div>
        </div>--}} 

</div>
@endsection
