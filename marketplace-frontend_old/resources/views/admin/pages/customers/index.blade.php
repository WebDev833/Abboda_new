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
        <h6 class="card-title mb-1">Customers List</h6>
        <p class="text-muted card-sub-title">Below is the list of customers.</p>
      </div>
      @include('admin.components.errors')
      @include('admin.components.success')
      <div class="table-responsive">
        <table class="table table-bordered text-nowrap mb-0">
          <thead>
            <tr>
              <th># Customer ID</th>
              <th>Customer Name</th>
              <th>Phone</th>
              <th>Email</th>
              <th>Created at</th>
              <th>Updated at</th>
            </tr>
          </thead>
          <tbody>
            @if ($customers->count())
                @foreach ($customers as $customer)
                   <tr>
                    <td>#{!! $customer->id !!}</td>
                    <td>{!! Admin::stringColumn($customer->name) !!}</td>
                    <td>{!! Admin::stringColumn($customer->phone) !!}</td>
                    <td>{!! Admin::stringColumn($customer->email) !!}</td>
                    <td>{!! Admin::dateColumn($customer,'created_at') !!}</td>
                    <td>{!! Admin::dateColumn($customer) !!}</td>
                    {{-- <td class="p-1">{!! Admin::tableActions([
                      'edit'=>[
                        'view'=>true,
                        'link'=> route('admin.editpage',['page'=>$page->id]),
                      ],
                      'delete'=>[
                        'view'=>true,
                        'link'=> route('admin.deletepage',['page'=>$page->id]),
                      ],
                    ]) !!}</td>--}}
                  </tr> 
                @endforeach
            @else
              <tr>
                <td colspan="6" class="bg-gray-200"><p class="mb-0 text-center p-3">No Customers added yet.</p></td>
              </tr> 
            @endif        
          </tbody>
        </table>
      </div>

      <div class="mt-3 pagination-circled wsg-center-pagination">
        {{ $customers->links() }}
      </div>

    </div>
  </div>
</div>
</div>
<!-- End Row -->
@endsection


@section('page-scripts')

@endsection