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
   <a class="btn ripple btn-primary add-media" href="{{route('admin.widgets.create')}}"><i class="fe fe-file-plus"></i> Create Widget</a>
 </div>
</div>
<!-- End Page Header -->
<!-- Row -->
<div class="row">
<div class="col-sm-12 col-xl-12 col-lg-12">
  <div class="card custom-card">
    <div class="card-body">
      <div>
        <h6 class="card-title mb-1">Widgets List</h6>
        <p class="text-muted card-sub-title">Below is the list of widgets.</p>
      </div>
      @include('admin.components.errors')
      @include('admin.components.success')
      <div class="table-responsive">
        <table class="table table-bordered text-nowrap mb-0">
          <thead>
            <tr>
              <th># ID</th>
              <th>Unique ID</th>
              <th>Status</th>
              <th>Created At</th>
              <th>Updated At</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @if ($widgets->count())
                @foreach ($widgets as $widget)
                   <tr>
                    <td>#{!! $widget->id !!}</td>
                    <td>{!! Admin::stringColumn($widget->unique_key) !!}</td>
                    <td>{!! Admin::statusColumn($widget,'status') !!}</td>
                     <td>{!! Admin::dateColumn($widget,'created_at') !!}</td>
                    <td>{!! Admin::dateColumn($widget) !!}</td>
                     <td class="p-1">{!! Admin::tableActions([
                      'edit'=>[
                        'view'=>true,
                        'link'=> route('admin.widgets.edit',['widget'=>$widget->id]),
                      ]
                    ]) !!}</td>
                  </tr>
                @endforeach
            @else
              <tr>
                <td colspan="8" class="bg-gray-200"><p class="mb-0 text-center p-3">No widgets added yet.</p></td>
              </tr> 
            @endif        
          </tbody>
        </table>
      </div>

      <div class="mt-3 pagination-circled wsg-center-pagination">
        {{ $widgets->onEachSide(3)->links() }}
      </div>

    </div>
  </div>
</div>
</div>
<!-- End Row -->
@endsection


@section('page-scripts')

@endsection