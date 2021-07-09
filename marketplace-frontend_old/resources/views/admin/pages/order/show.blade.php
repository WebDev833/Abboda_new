@extends('admin.layouts.page')
@section('page')
<!-- Page Header -->
<div class="page-header">
  <div>
    <h2 class="main-content-title tx-24 mg-b-5">{{$pageConfigs['title']}}</h2>
    @if ($pageConfigs['breadcrumb'])
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{$pageConfigs['title']}}</li>
    </ol>
    @endif
  </div>
</div>
<!-- End Page Header -->
<!-- Row -->
<div class="row">
<div class="col-sm-12 col-xl-12 col-lg-12">
  <div class="card custom-card">
    <div class="card-body">
      <div>
        <h6 class="card-title mb-1">Orders Details</h6>
        <p class="text-muted card-sub-title">Below is the list of Orders.</p>
      </div>
      @include('admin.components.errors')
      @include('admin.components.success')
      <div class="table-responsive">
        <table class="table table-bordered text-nowrap mb-0">
          <tbody>
            <tr>
              <th># ID</th>
              <td>{{$order->id}}</td>
              <th>Unique Order ID</th>
              <td>{{$order->unique_order_id}}</td>
            </tr>
            <tr>
              <th>Area Name:</th>
              <td>{{$order->area->name}}</td>
              <th>Order Status:</th>
              <td>{{$order->orderstatus->name}}</td>
            </tr>
            <tr>
              <th>Merchant Name:</th>
              <td>{{$order->company->name}}</td>
              <th>Customer Name:</th>
              <td>{{$order->user->name}}</td>
            </tr>
                    <tr>
          <th>Total:</th>
          <td>{!! Admin::priceColumn($order->total,true) !!}</td>
          <th>Payment Method:</th>
          <td>
            @if ($order->payment_method == 2)
            {!! 'Online Payment' !!}
            @else
            {!! 'Cash on Delivery' !!}
            @endif
          </td>
        </tr>
                <tr>
          <th>Address:</th>
          <td>{!! $order->address !!}</td>
          <th></th>
          <td></td>
        </tr>
                @php
        $driver = [];
        if(in_array($order->orderstatus->id,[6,7,8])){
        $cOrder = \App\AcceptOrder::where([
        'order_id'=>$order->id,
        'active'=>1,
        ])
        ->with('driver:user_id,vehicle_no','driver.user:id,name')
        ->first();

        if(!is_null($cOrder))
        {
        $driver['name'] = $cOrder->driver->user->name;
        $driver['vehicle'] = $cOrder->driver->vehicle_no;
        }
        }
        @endphp
        @if ($driver)
        <tr>
          <th>Driver Name:</th>
          <td>{!! $driver['name'] !!}</td>
          <th>Driver Vehicle:</th>
          <td>{!! $driver['vehicle'] !!}</td>
        </tr>
        @endif

          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="card custom-card">
    <div class="card-body">
      <div>
        <h6 class="card-title mb-1">Orders Items</h6>
        <p class="text-muted card-sub-title">Below is the list of Order Items.</p>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered text-nowrap mb-0">
      <thead>
       <tr>
          <th>Item Name</th>
          <th>Quantity</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
       @foreach ($order->orderitems as $item)
        <tr>
          <td>{{ $item->name }}</td>
          <td>{{ $item->quantity }}</td>
          <td>{!! Admin::priceColumn($item->price,true) !!}</td>
        </tr>
        @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>
<!-- End Row -->
@endsection


@section('page-scripts')

@endsection