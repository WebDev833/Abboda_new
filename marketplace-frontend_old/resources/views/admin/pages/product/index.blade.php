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
   <a class="btn ripple btn-primary add-media" href="{{route('admin.addproduct')}}"><i class="fe fe-file-plus"></i> Add Product</a>
 </div>
</div>
<!-- End Page Header -->
<!-- Row -->
<div class="row">
<div class="col-sm-12 col-xl-12 col-lg-12">
  <div class="card custom-card">
    <div class="card-body">
      <div>
        <h6 class="card-title mb-1">Product List</h6>
        <p class="text-muted card-sub-title">Below is the list of Products.</p>
      </div>
      @include('admin.components.errors')
      @include('admin.components.success')
      <div class="table-responsive">
        <table class="table table-bordered text-nowrap mb-0">
          <thead>
            <tr>
              <th># ID</th>
              <th>Merchant Name</th>
              <th>Category Name</th>
              <th>Product Name</th>
              <th>Updated at</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @if ($products->count())
                @foreach ($products as $product)
                   <tr>
                    <td>#{!! $product->id !!}</td>
                    <td>{!! Admin::stringColumn($product->company->name) !!}</td>
                    <td>{!! Admin::stringColumn($product->category->name) !!}</td>
                    <td>{!! Admin::stringColumn($product->name) !!}</td>
                    <td>{!! Admin::dateColumn($product) !!}</td>
                    <td>{!! Admin::statusColumn($product,'active') !!}</td>
                    {{-- <td>{!! Admin::slugColumn(url('store/'.$product->slug),'<i class="fe fe-eye"></i> View') !!}</td>                                        
                    <td>{!! Admin::statusColumn($product,'catalog_enabled') !!}</td> --}}
                     <td class="p-1">{!! Admin::tableActions([
                      'edit'=>[
                        'view'=>true,
                        'link'=> route('admin.editproduct',['product'=>$product->id]),
                      ],
                      'delete'=>[
                        'view'=>true,
                        'link'=> route('admin.deleteproduct',['product'=>$product->id]),
                      ],
                    ]) !!}</td>
                  </tr>
                @endforeach
            @else
              <tr>
                <td colspan="7" class="bg-gray-200"><p class="mb-0 text-center p-3">No products added yet.</p></td>
              </tr> 
            @endif        
          </tbody>
        </table>
      </div>

      <div class="mt-3 pagination-circled wsg-center-pagination">
        {{ $products->links() }}
      </div>

    </div>
  </div>
</div>
</div>
<!-- End Row -->
@endsection


@section('page-scripts')

@endsection