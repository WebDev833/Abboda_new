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
        <h6 class="card-title mb-1">Pages List</h6>
        <p class="text-muted card-sub-title">Below is the list of pages available for frontend.</p>
      </div>
      @include('admin.components.errors')
      @include('admin.components.success')
      <div class="table-responsive">
        <table class="table table-bordered text-nowrap mb-0">
          <thead>
            <tr>
              <th># Page No</th>
              <th>Page Title (en)</th>
              <th>Page URL (en)</th>
              <th>Page Title (ar)</th>
              <th>Page URL (ar)</th>
              <th>Status</th>
              <th>Last Updated</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @if ($pages->count())
                @foreach ($pages as $page)

                  {{-- {!! dd($page->getTranslationsArray()) !!} --}}
                  <tr>
                    <td>#{!! $page->id !!}</td>
                    <td>{!! Admin::stringColumn($page['title:en']) !!}</td>
                    <td>{!! Admin::slugColumn(url($page['slug:en']),'<i class="fe fe-eye"></i> View Page') !!}</td>
                    <td>{!! Admin::stringColumn($page['title:ar']) !!}</td>
                    <td>{!! Admin::slugColumn(url($page['slug:ar']),'<i class="fe fe-eye"></i> View Page') !!}</td>
                    <td>{!! Admin::statusColumn($page) !!}</td>
                    <td>{!! Admin::dateColumn($page) !!}</td>
                    <td class="p-1">{!! Admin::tableActions([
                      'edit'=>[
                        'view'=>true,
                        'link'=> route('admin.editpage',['page'=>$page->id]),
                      ],
                      'delete'=>[
                        'view'=>true,
                        'link'=> route('admin.deletepage',['page'=>$page->id]),
                      ],
                    ]) !!}</td>
                  </tr>
                @endforeach
            @else
              <tr>
                <td colspan="8" class="bg-gray-200"><p class="mb-0 text-center p-3">No Pages created yet.</p></td>
              </tr> 
            @endif        
          </tbody>
        </table>
      </div>

      <div class="mt-3 pagination-circled wsg-center-pagination">
        {{ $pages->links() }}
      </div>

    </div>
  </div>
</div>
</div>
<!-- End Row -->
@endsection


@section('page-scripts')

@endsection