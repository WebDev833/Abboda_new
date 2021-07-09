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
   <a class="btn ripple btn-primary add-media" href="{{route('admin.addmanager')}}"><i class="fe fe-file-plus"></i> Add Manager</a>
 </div>
</div>
<!-- End Page Header -->
<!-- Row -->
<div class="row">
<div class="col-sm-12 col-xl-12 col-lg-12">
  <div class="card custom-card">
    <div class="card-body">
      <div>
        <h6 class="card-title mb-1">Managers List</h6>
        <p class="text-muted card-sub-title">Below is the list of managers.</p>
      </div>
      @include('admin.components.errors')
      @include('admin.components.success')
      <div class="table-responsive">
        <table class="table table-bordered text-nowrap mb-0">
          <thead>
            <tr>
              <th># ID</th>
              <th>Manager Name</th>
              <th>Phone</th>
              <th>Email</th>
              <th>Created at</th>
              <th>Updated at</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @if ($managers->count())
                @foreach ($managers as $manager)
                   <tr>
                    <td>#{!! $manager->id !!}</td>
                    <td>{!! Admin::stringColumn($manager->name) !!}</td>
                    <td>{!! Admin::stringColumn($manager->phone) !!}</td>
                    <td>{!! Admin::stringColumn($manager->email) !!}</td>
                    <td>{!! Admin::dateColumn($manager,'created_at') !!}</td>
                    <td>{!! Admin::dateColumn($manager) !!}</td>
                     <td class="p-1">{!! Admin::tableActions([
                      'edit'=>[
                        'view'=>true,
                        'link'=> route('admin.editmanager',['manager'=>$manager->id]),
                      ],
                      'delete'=>[
                        'view'=>true,
                        'link'=> route('admin.deletemanager',['manager'=>$manager->id]),
                      ],
                    ]) !!}</td>
                  </tr>
                @endforeach
            @else
              <tr>
                <td colspan="7" class="bg-gray-200"><p class="mb-0 text-center p-3">No managers added yet.</p></td>
              </tr> 
            @endif        
          </tbody>
        </table>
      </div>

      <div class="mt-3 pagination-circled wsg-center-pagination">
        {{ $managers->links() }}
      </div>

    </div>
  </div>
</div>
</div>
<!-- End Row -->
@endsection


@section('page-scripts')

@endsection