@extends('admin.layouts.page')
@section('page')
<!-- Page Header -->
<div class="page-header">
  <div>
    <h2 class="main-content-title tx-24 mg-b-5">{{$pageConfigs['title']}}</h2>
    @if ($pageConfigs['breadcrumb'])
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Abboda</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{$pageConfigs['title']}}</li>
    </ol>
    @endif
  </div>
</div>
<!-- End Page Header -->

<!-- Row -->
<div class="row">
  @foreach ($items as $item)
  <div class="col-sm-6 col-md-6 col-xl-3">
    <div class="card custom-card">
      <div class="card-body text-center">
        <div class="icon-service bg-success-transparent rounded-circle text-success">
          <i class="{{$item['icon']}}"></i>
        </div>
        <p class="mb-1 text-muted">{{$item['title']}}</p>
        <h3 class="mb-0">{{$item['count']}}</h3>
      </div>
    </div>
  </div>
  @endforeach

</div>
<!-- End Row -->
<!-- Row -->
<div class="row">
  <div class="col-sm-12 col-xl-12 col-lg-12">
    <div class="card custom-card">
      <div class="card-body">
        <div>
          <h6 class="card-title mb-1">Recent 5 Orders</h6>
          <p class="text-muted card-sub-title">Below is the list of recent 5 Orders.</p>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered text-nowrap mb-0">
            <thead>
              <tr>
                <th>Unique Order ID</th>
                <th>Merchant</th>
                <th>Area</th>
                <th>Status</th>
                <th>User Name</th>
                <th>Total</th>
                <th>Payment Method</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @if ($orders->count())
                  @foreach ($orders as $order)
                    <tr>
                      <td>#{!! $order->id !!}</td>
                      <td>{!! Admin::stringColumn($order->company->name,10) !!}</td>
                      <td> @if(isset($order->area->name)) {!! Admin::stringColumn($order->area->name) !!} @endif</td>
                      <td>{!! Admin::stringColumn($order->orderstatus->name) !!}</td>
                      <td>{!! Admin::stringColumn($order->user->name) !!}</td>
                      <td>{!! Admin::priceColumn($order->total) !!}</td>
                      @if ($order->payment_method == 1)
                      <td>{!! Admin::badgeColumn('Cash On Delivery') !!}</td>
                      @else
                      <td>{!! Admin::badgeColumn('Online Payment','badge-success') !!}</td>
                      @endif
                      <td class="p-1">{!! Admin::tableActions([
                        'view'=>[
                          'view'=>true,
                          'link'=> route('admin.vieworder',['order'=>$order->id]),
                        ],
                      ]) !!}</td>
                    </tr>
                  @endforeach
              @else
                <tr>
                  <td colspan="8" class="bg-gray-200"><p class="mb-0 text-center p-3">No orders added yet.</p></td>
                </tr> 
              @endif        
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
<!-- index -->
<script src="{{ asset('admin-assets/js/index.js') }}"></script>

@endsection