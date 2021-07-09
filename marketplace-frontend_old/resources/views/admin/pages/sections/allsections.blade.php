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
        <h6 class="card-title mb-1">Sections List</h6>
        <p class="text-muted card-sub-title">Below is the list of section available for frontend.</p>
      </div>
      @include('admin.components.errors')
      @include('admin.components.success')
      <div class="table-responsive">
        <table class="table table-bordered text-nowrap mb-0">
          <thead>
            <tr>
              <th># Section No</th>
              <th>Section Name</th>
              <th>Status</th>
              <th>Created</th>
              <th>Last Updated</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @if ($sections->count())
                @foreach ($sections as $section)
                  <tr>
                    <td>#{!! $section->id !!}</td>
                    <td>{!! Admin::stringColumn($section->name) !!}</td>
                    <td>{!! Admin::statusColumn($section) !!}</td>
                    <td>{!! Admin::dateColumn($section,'created_at') !!}</td>
                    <td>{!! Admin::dateColumn($section) !!}</td>
                    <td class="p-1">{!! Admin::tableActions([
                      'edit'=>[
                        'view'=>true,
                        'link'=> route('admin.editsection',['section'=>$section->id]),
                      ],
                      'delete'=>[
                        'view'=>true,
                        'link'=> route('admin.deletesection',['section'=>$section->id]),
                      ],
                    ]) !!}</td>
                  </tr>
                @endforeach
            @else
              <tr>
                <td colspan="6" class="bg-gray-200"><p class="mb-0 text-center p-3">No Sections created yet.</p></td>
              </tr> 
            @endif        
          </tbody>
        </table>
      </div>

      <div class="mt-3 pagination-circled wsg-center-pagination">
        {{ $sections->links() }}
      </div>

    </div>
  </div>
</div>
</div>
<!-- End Row -->
@endsection


@section('page-scripts')

@endsection