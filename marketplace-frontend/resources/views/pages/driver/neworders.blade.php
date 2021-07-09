@extends('pages.driver.driverlayout')
@section('driverpage')
@include('pages.driver.navbar')
    <div class="roms--orders">
        @include('panels.success')
        @include('panels.errors')

@include('pages.driver.mylocation_html')

        <h4 class="mb-5">New Orders</h4>
        <div class="row">
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
                          <td>{{ $order->orderstatus->name }}</td>
                          <td>{{ str_limit($order->company->name, 20) }}</td>
                          <td>{{ romsProPrice($order->total,false) }}</td>
                          <td>{{ str_limit($order->address, 20) }}</td>
                          <td><a href="{{route('driver.orderDetails',['id'=>$order->id])}}" class="roms--orderdetails-link"><i class="fa fa-eye"></i> Details</a></td>
                      </tr>
                    @endforeach
                  @else
                      <tr class="no-row-exist"><td colspan="6" class="p-4 text-center">No new orders..!!!</td></tr>
                  @endif
                </tbody>
            </table>
        </div>
        </div>
        </div>

</div>
@endsection
@include('pages.driver.mylocation_js_css')
