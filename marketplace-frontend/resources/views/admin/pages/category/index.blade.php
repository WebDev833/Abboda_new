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
   <a class="btn ripple btn-primary add-media" href="{{route('admin.addcategory')}}"><i class="fe fe-file-plus"></i> Add Category</a>
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
        <p class="text-muted card-sub-title">Below is the list of categories.</p>
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
              <th>Created at</th>
              <th>Updated at</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @if ($categories->count())
                @foreach ($categories as $category)
                   <tr>
                    <td>#{!! $category->id !!}</td>
                    <td>{!! Admin::stringColumn($category->company->name) !!}</td>
                    <td>{!! Admin::stringColumn($category->name) !!}</td>
                    <td>{!! Admin::dateColumn($category,'created_at') !!}</td>                 
                    <td>{!! Admin::dateColumn($category) !!}</td>                 
                    <td>{!! Admin::statusColumn($category,'active') !!}</td>
                     <td class="p-1">{!! Admin::tableActions([
                      'edit'=>[
                        'view'=>true,
                        'link'=> route('admin.editcategory',['category'=>$category->id]),
                      ],
                      'delete'=>[
                        'view'=>true,
                        'link'=> route('admin.deletecategory',['category'=>$category->id]),
                      ],
                    ]) !!}</td>
                  </tr>
                @endforeach
            @else
              <tr>
                <td colspan="7" class="bg-gray-200"><p class="mb-0 text-center p-3">No categories added yet.</p></td>
              </tr> 
            @endif        
          </tbody>
        </table>
      </div>

      <div class="mt-3 pagination-circled wsg-center-pagination">
        {{ $categories->links() }}
      </div>

    </div>
  </div>
</div>
</div>
<!-- End Row -->
@endsection


@section('page-scripts')

@endsection