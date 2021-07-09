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
{!! Form::model($settlement, ['route'=>['admin.settlements.update',$settlement->id],'data-parsley-validate'=>'']) !!}
@method('PATCH')
<div class="row">
  <div class="col-md-8 col-sm-12">
    <div class="card custom-card">
      <div class="card-body">
        <div>
          <h6 class="card-title mb-2">Tranasction Fields</h6>
          <p class="text-muted card-sub-title"><span class="tx-danger">Note: </span> Fields marked as (*) are required fields.</p>
        </div>
          @include('admin.components.errors')
          @include('admin.components.success')
          <div class="">
            <div class="row">
              <div class="col-lg-12 form-group">
                <label class="form-label">Order Number: <span class="tx-danger">*</span></label>
                <div class="parsley-select" id="slWrapper3">
                  {!! Form::select('order_id', $orders, null,["class"=>"form-control select2-search","placeholder"=>"","data-parsley-class-handler"=>"#slWrapper3","data-parsley-errors-container"=>"#slErrorContainer3","required"=>"required"]) !!}
                    <div id="slErrorContainer3"></div>
                </div>
              </div>

            </div>
            <div class="mg-t-20 d-none">
              <button class="btn ripple btn-main-primary pd-x-30" type="submit">Save</button>
            </div>
          </div>
      </div>
    </div>

  </div>
  {{-- <div class="col-xl-4 col-lg-12 d-none d-xl-block custom-leftnav"> --}}
  <div class="col-md-4 col-sm-12 d-xl-block custom-leftnav">
    <div class="main-content-left-components">
      <div class="card custom-card">
        <div class="card-body">
          <h6 class="card-title mb-1">Actions</h6>
          <p class="mg-b-10 mt-3">Received</p>
          <div class="parsley-checkbox" id="cbWrapper">
              <label class="ckbox mg-b-5">
                {!! Form::checkbox('received', 1) !!}
                <span>Yes</span>
              </label>
          </div>

          <div class="mg-t-20">
            <button class="btn ripple btn-primary pd-x-30" type="submit">Save</button>
            <a class="btn ripple btn-danger pd-x-30 ml-3" href="{{route('admin.settlements.index')}}" >Cancel</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</form>

<!-- End Row -->
@endsection

@section('vendor-styles')
  <link href="{{ asset('admin-assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-scripts')
<!-- Select2 js-->
<script src="{{ asset('admin-assets/plugins/select2/js/select2.min.js') }}"></script>
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
		$('.select2-search').select2({
			width: '100%'
		});
	});
});
</script>

@endsection


