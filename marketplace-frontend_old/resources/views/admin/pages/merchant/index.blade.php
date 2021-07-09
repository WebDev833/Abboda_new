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
  <div class="btn btn-list">
   <a class="btn ripple btn-primary add-media" href="{{route('admin.addmerchant')}}"><i class="fe fe-file-plus"></i> Add Merchant</a>
 </div>
</div>
<!-- End Page Header -->
<!-- Row -->
<div class="row">
<div class="col-sm-12 col-xl-12 col-lg-12">
  <div class="card custom-card">
    <div class="card-body">
      <div>
        <h6 class="card-title mb-1">Merchant List</h6>
        <p class="text-muted card-sub-title">Below is the list of Merchants.</p>
      </div>
      @include('admin.components.errors')
      @include('admin.components.success')
      <div class="table-responsive">
        <table class="table table-bordered text-nowrap mb-0">
          <thead>
            <tr>
              <th># ID</th>
              <th>Area Name</th>
              <th>merchant Name</th>
              <th>Updated at</th>
              <th>URL</th>
              <th>Status</th>
              <th>Store</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @if ($merchants->count())
                @foreach ($merchants as $merchant)
                   <tr>
                    <td>#{!! $merchant->id !!}</td>
                    <td>{!! Admin::stringColumn($merchant->area->name) !!}</td>
                    <td>{!! Admin::stringColumn($merchant->name) !!}</td>
                    <td>{!! Admin::dateColumn($merchant) !!}</td>
                    <td>{!! Admin::slugColumn(url('store/'.$merchant->slug),'<i class="fe fe-eye"></i> View') !!}</td>                    
                    <td>{!! Admin::statusColumn($merchant,'active') !!}</td>
                    <td>{!! Admin::statusColumn($merchant,'catalog_enabled') !!}</td>
                     <td class="p-1">{!! Admin::tableActions([
                      'edit'=>[
                        'view'=>true,
                        'link'=> route('admin.editmerchant',['merchant'=>$merchant->id]),
                      ],
                      'delete'=>[
                        'view'=>true,
                        'link'=> route('admin.deletemerchant',['merchant'=>$merchant->id]),
                      ],
                    ]) !!}</td>
                  </tr>
                @endforeach
            @else
              <tr>
                <td colspan="8" class="bg-gray-200"><p class="mb-0 text-center p-3">No merchants added yet.</p></td>
              </tr> 
            @endif        
          </tbody>
        </table>
      </div>

      <div class="mt-3 pagination-circled wsg-center-pagination">
        {{ $merchants->links() }}
      </div>

    </div>
  </div>
</div>
</div>
<!-- End Row -->
@endsection


@section('page-scripts')

@endsection