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
   <a class="btn ripple btn-primary add-media" href="{{route('admin.adddriver')}}"><i class="fe fe-file-plus"></i> Add Driver</a>
 </div>
</div>
<!-- End Page Header -->
<!-- Row -->
<div class="row">
<div class="col-sm-12 col-xl-12 col-lg-12">
  <div class="card custom-card">
    <div class="card-body">
      <div>
        <h6 class="card-title mb-1">Drivers List</h6>
        <p class="text-muted card-sub-title">Below is the list of drivers.</p>
      </div>
      @include('admin.components.errors')
      @include('admin.components.success')
      <div class="table-responsive">
        <table class="table table-bordered text-nowrap mb-0">
          <thead>
            <tr>
              <th># ID</th>
              <th>Driver Area</th>
              <th>Driver Name</th>
              <th>Phone</th>
              <th>Email</th>
              <th>Vehicle</th>
              <th>Status</th>
              <th>Created at</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @if ($drivers->count())
                @foreach ($drivers as $driver)
                   <tr>
                    <td>#{!! $driver->id !!}</td>
                    <td>{!! Admin::stringColumn($driver->driverprofile->area->name) !!}</td>
                    <td>{!! Admin::stringColumn($driver->name) !!}</td>
                    <td>{!! Admin::stringColumn($driver->phone) !!}</td>
                    <td>{!! Admin::stringColumn($driver->email) !!}</td>
                    <td>{!! Admin::stringColumn($driver->driverprofile->vehicle_no) !!}</td>
                    <td>{!! Admin::statusColumn($driver->driverprofile,'active') !!}</td>
                    <td>{!! Admin::dateColumn($driver,'created_at') !!}</td>
                     <td class="p-1">{!! Admin::tableActions([
                      'edit'=>[
                        'view'=>true,
                        'link'=> route('admin.editdriver',['driver'=>$driver->id]),
                      ],
                      'delete'=>[
                        'view'=>true,
                        'link'=> route('admin.deletedriver',['driver'=>$driver->id]),
                      ],
                    ]) !!}</td>
                  </tr>
                @endforeach
            @else
              <tr>
                <td colspan="9" class="bg-gray-200"><p class="mb-0 text-center p-3">No drivers added yet.</p></td>
              </tr> 
            @endif        
          </tbody>
        </table>
      </div>

      <div class="mt-3 pagination-circled wsg-center-pagination">
        {{ $drivers->links() }}
      </div>

    </div>
  </div>
</div>
</div>
<!-- End Row -->
@endsection


@section('page-scripts')

@endsection