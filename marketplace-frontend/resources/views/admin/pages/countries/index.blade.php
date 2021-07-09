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
   <a class="btn ripple btn-primary add-media" href="{{route('admin.addcountry')}}"><i class="fe fe-file-plus"></i> Add Country</a>
 </div>
</div>
<!-- End Page Header -->
<!-- Row -->
<div class="row">
<div class="col-sm-12 col-xl-12 col-lg-12">
  <div class="card custom-card">
    <div class="card-body">
      <div>
        <h6 class="card-title mb-1">Countries  List</h6>
        <p class="text-muted card-sub-title">Below is the list of Countries.</p>
      </div>
      @include('admin.components.errors')
      @include('admin.components.success')
      <div class="table-responsive">
        <table class="table table-bordered text-nowrap mb-0">
          <thead>
            <tr>
              <th># ID</th>
              <th>Country Name</th>
              <th>Currency</th>
              <th>Phonecode</th>
              <th>Language</th>
              <th>Status</th>
              <th>Created at</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @if ($countries->count())
                @foreach ($countries as $country)
                   <tr>
                    <td>#{!! $country->id !!}</td>
                    <td>{!! Admin::stringColumn($country->name) !!}</td>
                    <td>{!! Admin::stringColumn($country->currency) !!}</td>
                    <td>{!! Admin::stringColumn($country->phonecode) !!}</td>
                    <td>{!! Admin::stringColumn($country->language) !!}</td>
                    <td>{!! Admin::statusColumn($country,'active') !!}</td>
                    <td>{!! Admin::dateColumn($country,'created_at') !!}</td>
                    <td class="p-1">{!! Admin::tableActions([
                      'edit'=>[
                        'view'=>true,
                        'link'=> route('admin.editcountry',['country'=>$country->id]),
                      ],
                      'delete'=>[
                        'view'=>true,
                        'link'=> route('admin.deletecountry',['country'=>$country->id]),
                      ],
                    ]) !!}</td>
                  </tr>
                @endforeach
            @else
              <tr>
                <td colspan="8" class="bg-gray-200"><p class="mb-0 text-center p-3">No Countries added yet.</p></td>
              </tr> 
            @endif        
          </tbody>
        </table>
      </div>

      <div class="mt-3 pagination-circled wsg-center-pagination">
        {{ $countries->links() }}
      </div>

    </div>
  </div>
</div>
</div>
<!-- End Row -->
@endsection


@section('page-scripts')

@endsection