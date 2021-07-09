@extends('pages.user.userlayout')
@section('userpage')
@include('pages.user.navbar')
<div class="roms--order-detail">  
    @include('panels.success')
     <h4 class="mb-4">Order Details</h4>
     @if ($order->orderstatus->id == 1)
      <div class="row">
        <div class="col-md-12">
          <div class="roms--cancel-order-block text-right">
            <span>
              <a href="{{ route('user.cancelorder',['id'=>$order->id]) }}" class="ps-btn ps-btn--sm bg-danger mb-4">Cancel Order</a>
            </span>
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
                            <td>{{ $order->orderstatus->name }}</td>
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
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($order->orderitems as $item)
                        <tr>
                            <td>{{$item->name}}</td>
                            <td>{{$item->quantity}}</td>
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
                        {{-- <tr>
                            <td class="heading">Items Cost</td>
                            <td>$540</td>
                            <td class="heading">Delivery Cost</td>
                            <td>$60</td>
                        </tr> --}}
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
</div>

@endsection
