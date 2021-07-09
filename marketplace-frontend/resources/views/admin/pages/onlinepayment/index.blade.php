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
        <h6 class="card-title mb-1">Online Payments</h6>
        <p class="text-muted card-sub-title">Below is the list of Online Payments.</p>
      </div>
      @include('admin.components.errors')
      @include('admin.components.success')
      <div class="table-responsive">
        <table class="table table-bordered text-nowrap mb-0">
          <thead>
            <tr>
              <th># ID</th>
              <th>Order ID</th>
              <th>Amount</th>
              <th>Status</th>
              <th>Payment Date</th>
            </tr>
          </thead>
          <tbody>
            @if ($onlinepayments->count())
                @foreach ($onlinepayments as $onlinepayment)
                   <tr>
                    <td>#{!! $onlinepayment->id !!}</td>
                    <td>{!! $onlinepayment->order_id !!}</td>
                    <td>{!! Admin::priceColumn($onlinepayment->amount,false) !!}</td>
                    <td>{!! Admin::badgeColumn($onlinepayment->status,'badge-success') !!}</td>
                    <td>{!! Admin::dateColumn($onlinepayment,'created_at') !!}</td>
                  </tr>
                @endforeach
            @else
              <tr>
                <td colspan="8" class="bg-gray-200"><p class="mb-0 text-center p-3">No onlinepayments added yet.</p></td>
              </tr> 
            @endif        
          </tbody>
        </table>
      </div>

      <div class="mt-3 pagination-circled wsg-center-pagination">
        {{ $onlinepayments->onEachSide(3)->links() }}
      </div>

    </div>
  </div>
</div>
</div>
<!-- End Row -->
@endsection


@section('page-scripts')

@endsection