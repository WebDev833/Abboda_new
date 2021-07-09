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
{!! Form::model($widget, ['route'=>['admin.widgets.update',$widget->id],'method'=>'POST','data-parsley-validate'=>'']) !!}
@method('PATCH')
<div class="row">
  <div class="col-md-8 col-sm-12">
    <div class="card custom-card">
      <div class="card-body">
        <div>
          <h6 class="card-title mb-2">Widget Fields</h6>
          <p class="text-muted card-sub-title"><span class="tx-danger">Note: </span> Fields marked as (*) are required fields.</p>
        </div>
          @include('admin.components.errors')
          @include('admin.components.success')
          <div class="">
            <div class="row">
              <div class="col-lg-12 form-group">
                <label class="form-label">Widget unique Key: <span class="tx-danger">*</span></label>
                {!! Form::text('unique_key', null, ["class"=>"form-control","placeholder"=>"Enter Unique Key eg:footer-about-us,links-widget, etc.","required"=>"required","readonly"=>"readonly"]) !!}
              </div>
            </div>
            <div class="mg-t-20 d-none">
              <button class="btn ripple btn-main-primary pd-x-30" type="submit">Save</button>
            </div>
          </div>
      </div>
    </div>
    {{-- Translations --}}
    <div class="card custom-card main-content-body-profile">
      <nav class="nav main-nav-line">
        <a class="nav-link active" data-toggle="tab" href="#englishtab">English</a>
        <a class="nav-link" data-toggle="tab" href="#arabictab">Arabic</a>
      </nav>
      <div class="card-body tab-content h-100">
        <div class="tab-pane active" id="englishtab">
          	<div>
              <h6 class="card-title mb-1">English Translations</h6>
              <p class="text-muted card-sub-title">Widget content in english here.</p>
            </div>
						<textarea name="body:en" class="summernote">{{ (old('body:en') ? old('body:en') : $widget->getTranslation('body','en') ) }}</textarea>

        </div>
        <div class="tab-pane" id="arabictab">
            <div>
              <h6 class="card-title mb-1">Arabic Translations</h6>
              <p class="text-muted card-sub-title">Widget content in arabic here.</p>
            </div>
            <textarea name="body:ar" class="summernote">{{ (old('body:ar') ? old('body:ar') : $widget->getTranslation('body','ar') ) }}</textarea>

        </div>
      </div>
    </div>

  </div>
  {{-- <div class="col-xl-4 col-lg-12 d-none d-xl-block custom-leftnav"> --}}
  <div class="col-md-4 col-sm-12 d-none d-xl-block custom-leftnav">
    <div class="main-content-left-components">
      <div class="card custom-card">
        <div class="card-body">
          <h6 class="card-title mb-1">Widget Actions</h6>
          {{-- <div class="form-group">
            <p class="mt-3 mb-2 ">Page Status</p>
            <label class="custom-switch">
              <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
              <span class="custom-switch-indicator"></span>
              <span class="custom-switch-description">Active</span>
            </label>
          </div> --}}
          <p class="mt-3 mg-b-10">Status: <span class="tx-danger">*</span></p>
          <div class="parsley-select" id="slWrapper2">
            {!! Form::select('status', [
              1 => "Active",
              0 => "Inactive",
            ],1, ["class"=>"form-control select2-no-search","data-parsley-class-handler"=>"#slWrapper2","data-parsley-errors-container"=>"#slErrorContainer2","data-placeholder"=>"Choose Status","required"=>"required"]) !!}
            <div id="slErrorContainer2"></div>
          </div>
          <div class="mg-t-20">
            <button class="btn ripple btn-primary pd-x-30" type="submit">Save</button>
            <a class="btn ripple btn-danger pd-x-30 ml-3" href="{{route('admin.allsections')}}" >Cancel</a>
          </div>
        </div>
      </div>
      {{-- <div class="bg-white box-shadow">
        <div class="alert text-center fade show p-3">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <i class="fe fe-download-cloud fs-50 text-danger"></i>
          <h5 class="mt-2 mb-1">Oops!</h5>
          <p class="mb-3 mb-3 tx-inverse">Something went wrong</p>
          <a class="btn ripple btn-danger" href="#">Try again</a>
        </div>
      </div> --}}
    </div>
  </div>
</div>
</form>

<!-- End Row -->




@endsection

@section('vendor-styles')
  <link href="{{ asset('admin-assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
  <!--Summernote css-->
  <link href="{{ asset('admin-assets/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
@endsection

@section('vendor-scripts')
<!-- include codemirror (codemirror.css, codemirror.js, xml.js, formatting.js) -->
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.css">
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.css">
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/2.36.0/formatting.js"></script>
@endsection
@section('page-scripts')
<!-- Select2 js-->
<script src="{{ asset('admin-assets/plugins/select2/js/select2.min.js') }}"></script>
<!--Summernote js-->
<script src="{{ asset('admin-assets/plugins/summernote/summernote-bs4.js') }}"></script>

<!-- Parsley js-->
<script src="{{ asset('admin-assets/plugins/parsleyjs/parsley.min.js') }}"></script>
<script type="text/javascript">
  $(function() {
	'use strict'
	$(document).ready(function() {
		$('.select2-no-search').select2({
			minimumResultsForSearch: Infinity,
			width: '100%'
		});
    $('.summernote').summernote({
      placeholder: 'Enter Content here',
      tabsize: 3,
      height: 300,
      codemirror: {
        theme: 'monokai'
      }
	  });
	});
});
</script>
@endsection