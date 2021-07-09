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
          <h6 class="card-title mb-1">Orders List</h6>
          <p class="text-muted card-sub-title">Below is the list of Orders.</p>
        </div>
        @include('admin.components.errors')
        @include('admin.components.success')
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
                      <td>@if(isset($order->area->name)) {!! Admin::stringColumn($order->area->name) !!} @endif</td>
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

        <div class="mt-3 pagination-circled wsg-center-pagination">
          {{ $orders->links() }}
        </div>

      </div>
    </div>
  </div>
</div>
<!-- End Row -->
@endsection


@section('page-scripts')

@endsection