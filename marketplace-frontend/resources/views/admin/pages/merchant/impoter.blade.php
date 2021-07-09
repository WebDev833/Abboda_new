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
  {!! Form::open(['route'=>'admin.restaurantsImportSave','method'=>'POST','data-parsley-validate'=>'','enctype'=>'multipart/form-data'
]) !!}
<div class="row">

  <div class="col-md-8 col-sm-12">
    <div class="card custom-card">
      <div class="card-body">
        <div>
          <h6 class="card-title mb-2">Importer Fields</h6>
          <p class="text-muted card-sub-title"><span class="tx-danger">Note: </span> Fields marked as (*) are required fields. and Images for resutrant should put in the "\storage\imports\images"</p>
        </div>
          @include('admin.components.errors')
          @include('admin.components.success')
          <div class="">
          
            <div class="row">
              <div class="col-lg-6 form-group">
                <label class="form-label">Company Type: <span class="tx-danger">*</span></label>
                <div class="parsley-select" id="slWrapper4">
                  {!! Form::select('companytype_id', $companytypes, 1,["class"=>"form-control select2-no-search","data-parsley-class-handler"=>"#slWrapper4","data-parsley-errors-container"=>"#slErrorContainer4","data-placeholder"=>"select Merchant Type","required"=>"required"]) !!}
                    <div id="slErrorContainer4"></div>
                </div>
              </div>

              <div class="col-lg-6 form-group">
                <label class="form-label">file Type : <span class="tx-danger">*</span></label>
                <input type="radio" required="" name="filetype" value="1"> Resturants
                <input type="radio" required="" name="filetype" value="2"> Products
              </div>
            </div>
         
          </div>
      </div>
    </div>

  </div>
  
  <div class="col-md-4 col-sm-12 d-xl-block custom-leftnav">
    <div class="main-content-left-components">
      <div class="card custom-card">
        <div class="card-body">
          <h6 class="card-title mb-1">import File</h6>
          
          <input type="file" name="csvfile" required="">
          <div class="mg-t-20">
            <button class="btn ripple btn-primary pd-x-30" type="submit">Save</button>
            <a class="btn ripple btn-danger pd-x-30 ml-3" href="{{route('admin.dashboard')}}" >Cancel</a>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
</form>

<!-- End Row -->
@endsection


