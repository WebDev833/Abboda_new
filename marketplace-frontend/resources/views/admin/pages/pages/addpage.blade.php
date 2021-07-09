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
{!! Form::open(['route'=>'admin.addpageSave','method'=>'POST','data-parsley-validate'=>'']) !!}
<div class="row">
  <div class="col-md-8 col-sm-12">
    <div class="card custom-card main-content-body-profile">
      <div class="">
        <div class="card-body pb-0">
          <h6 class="card-title mb-2">Page Fields</h6>
          <p class="text-muted card-sub-title"><span class="tx-danger">Note: </span> Fields marked as (*) are required fields.</p>
        </div>
        <div class="px-4">
           @include('admin.components.errors')
          @include('admin.components.success')
        </div>
          <div class="">
            <nav class="nav main-nav-line">
              <a class="nav-link active" data-toggle="tab" href="#englishtab">English</a>

              <a class="nav-link" data-toggle="tab" href="#arabictab">Arabic</a>
            
            </nav>
            <div class="card-body tab-content h-100">
              <div class="tab-pane active" id="englishtab">
                <div class="">
                  <div class="row">
                    <div class="col-lg-12 form-group">
                      <label class="form-label">Page Title <small>(en)</small>: <span class="tx-danger">*</span></label>
                      {!! Form::text('title:en', null, ["class"=>"form-control","placeholder"=>"Enter Title","required"=>"required"]) !!}
                    </div>
                    <div class="col-lg-12 form-group">
                      <label class="form-label">Page Slug <small>(en)</small>: <span class="tx-danger">*</span></label>
                      {!! Form::text('slug:en', null, ["class"=>"form-control","placeholder"=>"Enter Slug","required"=>"required"]) !!}
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="arabictab">
                <div class="row">
                  <div class="col-lg-12 form-group">
                    <label class="form-label">Page Title <small>(ar)</small>: <span class="tx-danger">*</span></label>
                    {!! Form::text('title:ar', null, ["class"=>"form-control","placeholder"=>"Enter Title","required"=>"required"]) !!}
                  </div>
                  <div class="col-lg-12 form-group">
                    <label class="form-label">Page Slug <small>(ar)</small>: <span class="tx-danger">*</span></label>
                    {!! Form::text('slug:ar', null, ["class"=>"form-control","placeholder"=>"Enter Slug","required"=>"required"]) !!}
                  </div>
                </div>

              </div>


              <div class="form-group">
                <label class="form-label">Country (for legel pages): </label>
                <div class="parsley-select" id="slWrapper4">
                  {!! Form::select('country_id', $countries,2 ,["class"=>"form-control select2-search","data-parsley-class-handler"=>"#slWrapper4","data-parsley-errors-container"=>"#slErrorContainer4","placeholder" => ""]) !!}
                    <div id="slErrorContainer4"></div>
                </div>
              </div>
            </div>

            <div class="mg-t-20 d-none">
              <button class="btn ripple btn-main-primary pd-x-30" type="submit">Save</button>
            </div>
          </div>
      </div>
    </div>

    <div class="card custom-card">
      <div class="card-body">
        <div>
          <h6 class="card-title mb-2">Page Sections</h6>
          <p class="text-muted card-sub-title"><span class="tx-danger">Note: </span> Fields marked as (*) are required fields.</p>
        </div>
        <div class="">
          <div class="row">
            <div class="col-lg-12">
              
              <div class="">
                <div class="added-sections" id="currentsections">
                    {{-- <div id="section-sort">
                      <div class="card custom-card card-body">
                        <p class="card-text">Section 1</p>
                      </div>
                    </div> --}}
                    @php
                     $rsc = request()->old('sections');
                    @endphp
                    @if (is_countable($rsc) && $sections->count())
                      <div id="section-sort">
                        @foreach ($rsc as $em)
                         @php
                            $section =  $sections->where('id',$em)->first();
                         @endphp
                          @if ($section->id == $em)
                              <div class="card custom-card card-body sec-item-parent" data-id="{{$section->id}}">
                                <input type="hidden" name="sections[]" value="{{$section->id}}">
                                <p class="card-text mb-0">{{$section->unique_name}}</p>
                                <div class="text-right">
                                  <a href="javascript:void(0);" class="card-link section-delete" data-did="{{$section->id}}">Remove</a>
                                </div>
                              </div>
                          @endif
                        @endforeach
                      </div>
                    @endif

                </div>
              </div>

              <div class="mt-3">
                <button type="button" class="btn ripple btn-secondary btn-block btn-outline-light" id="page-section-add"><i class="fa fa-plus"></i> Add Section</button>
              </div>
            </div>
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
          <h6 class="card-title mb-1">Page Actions</h6>
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
            ],1, ["class"=>"form-control select2-no-search","data-parsley-class-handler"=>"#slWrapper2","data-parsley-errors-container"=>"#slErrorContainer2","data-placeholder"=>"Choose Page Status","required"=>"required"]) !!}
            <div id="slErrorContainer2"></div>
          </div>

          <p class="mg-b-10 mt-2">Is legel Page?</p>
          <div class="parsley-checkbox" id="cbWrapper">
              <label class="ckbox mg-b-5">
                {!! Form::checkbox('static', 2, false) !!}
                <span>Yes</span>
              </label>
          </div>

          <div class="mg-t-20">
            <button class="btn ripple btn-primary pd-x-30" type="submit">Save</button>
            <a class="btn ripple btn-danger pd-x-30 ml-3" href="{{route('admin.allpages')}}" >Cancel</a>
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
  <!---Jquery.mCustomScrollbar css-->
<link href="{{ asset('admin-assets/plugins/jquery.mCustomScrollbar/jquery.mCustomScrollbar.css') }}" rel="stylesheet">

<!---Darggable css-->
<link href="{{ asset('admin-assets/plugins/darggable/jquery-ui-darggable.css') }}" rel="stylesheet">
@endsection
@section('page-scripts')
<!-- Select2 js-->
<script src="{{ asset('admin-assets/plugins/select2/js/select2.min.js') }}"></script>
{{-- <!--MutipleSelect js-->
<script src="{{ asset('admin-assets/plugins/multipleselect/multiple-select.js') }}"></script>
<script src="{{ asset('admin-assets/plugins/multipleselect/multi-select.js') }}"></script> --}}
<!-- Jquery.mCustomScrollbar js-->
<script src="{{ asset('admin-assets/plugins/jquery.mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<!-- Parsley js-->
<script src="{{ asset('admin-assets/plugins/parsleyjs/parsley.min.js') }}"></script>
<!---Darggable js-->
<script src="{{ asset('admin-assets/plugins/darggable/jquery-ui-darggable.min.js') }}"></script>

<script type="text/javascript">
  $(function() {
	'use strict'
	$(document).ready(function() {
		$('.select2-no-search').select2({
			minimumResultsForSearch: Infinity,
			width: '100%'
		});
	});

  $(".scroll-widget").mCustomScrollbar({
    theme: "minimal",
    autoHideScrollbar: false,
    scrollbarPosition: "outside"
  }); 
});

</script>


<script type="text/javascript">

  $(document).ready(function() {
    $('.select2-search').select2({
      placeholder : 'Select',
      width: '100%'
      });
   }); 

  $(document).on('click','#page-section-add',function(e){
    e.preventDefault();
 		$('.page-section-model').show();
  });

  $(document).on('click','.page-section-model-close', function(e) {
 		e.preventDefault();
 	  $('.page-section-model').hide();
 	});

  $(document).on('click','.section-delete',function(e){
 		e.preventDefault();
    $(this).parents('.sec-item-parent').remove();
  });

  $(document).on('click','#add-sections', function(e) {
 		e.preventDefault();
    $.when(currentSectionsModule().current())
    .then(function(r){
      console.log(r);     
      return checkItemModule().unique(r);
    })
    .then(function(r){
      console.log(r);    
      return checkItemModule().sections(r); 
    })
    .then(function(r){
      console.log(r);
      return addSectionModule().sections(r);
    })
    .then(function(r){
      console.log(r);
      $('#currentsections').html(r);      
      $("#section-sort").sortable({
        //revert: true,
        placeholder: 'card-draggable-placeholder',
        //forcePlaceholderSize: true,
        cursor: 'move'
      });
      $('.page-section-model-close').trigger('click');
      $('.psmc-input').prop('checked',false);
    });
 	});

   var currentSectionsModule = function(){
     var i = $('#section-sort .card-body'),
     c = function()
     {
       var l = []; 
       i.each(function(){
         l.push($(this).attr('data-id'));
       });
       return l;
     };
     return {
       current : c,
     };
   },
   checkItemModule = function(){
     var i = $('.psm-section-listitem .psmc-input:checkbox:checked'),
     c = function()
     {
       var l = []; 
       i.each(function(){
         l.push($(this).attr('data-id'));
       });
       return l;
     },
     d = function(a)
     {
       var l = [],o={}; 
       $.each(a,function(i,v){
         o={};
         o.name = $('.psmc-name[data-id='+v+']').text();
         o.value = v;
         l.push(o);
       });
       return l;
     },
      j = function(a)
      {
        return a.concat(c());
      },
     u = function(a)
     {
       return [...new Set(j(a))];
     };
     return {
       unique : u,
       sections : d
     }
   },
   prepareSArrayModule = function() {

   },
   addSectionModule = function(){
      var z ='',
      i = function(v){
        if(v === undefined) return '';
        var input = '<input type="hidden" name="sections[]" value="<<sectionValue>>">';
        return input.replace('<<sectionValue>>',v);
      },
      n = function(v){
        if(v === undefined) return '';
        var name = '<p class="card-text mb-0"><<sectionName>></p>';
        return name.replace('<<sectionName>>',v);
      },
      a = function(v){
        if(v === undefined) return '';
        return '<div class="text-right"><a href="javascript:void(0);" class="card-link section-delete" data-did="'+v+'">Remove</a></div>';
      },
      s = function(t,v){
        return '<div class="card custom-card card-body sec-item-parent" data-id="'+v+'">'+
        i(v) +
        n(t) +
        a(v) +
        '</div>';
      },
      l = function(a)
      {
        z += '<div id="section-sort">';
        for(var i=0,e;e=a[i];i++)
              z+= s(e.name,e.value);
        z += '</div>';
          return z;
      };
      return {
        sections : l
      }
   }

if($('#section-sort').length > 0)
{
  $("#section-sort").sortable({
		//revert: true,
		placeholder: 'card-draggable-placeholder',
		//forcePlaceholderSize: true,
		cursor: 'move'
	});
}


</script>


@endsection
@section('extras')
<!-- page-section model  -->
<div class="page-section-model">
  <div>
    <div class="container">
      <div class="page-section-model-box">
        <div class="page-section-model-header">
          <span>Section List</span>
          <nav class="nav">
            <a class="nav-link page-section-model-close" href="javascript:void(0);"><i class="fas fa-times"></i></a>
          </nav>
        </div>
        <div class="page-section-model-body">
          {{-- <div class="country-sales scroll-widget bd-t"> --}}
          <div class="scroll-widget bd-t">
            <div class="list-group psm-section-list">
              @if ($sections->count())
              @foreach ($sections as $section)
                <div class="list-group-item  d-flex border-right-0 border-left-0 border-top-0 psm-section-listitem" data-id="{{$section->id}}">
                  <div class="page-section-model-checkbox">
                    <label class="ckbox"><input type="checkbox" class="psmc-input" data-id="{{$section->id}}"> <span></span></label>
                  </div>
                  <p class="ml-3 mb-0 psmc-name" data-id="{{$section->id}}">{{$section->unique_name}}</p>
                  <span class="ml-auto font-weight-bold">{{$section->updated_at}}</span>
                </div>
              @endforeach
              @else
                  <div class="list-group-item  d-flex border-right-0 border-left-0 border-top-0">
                <p class="ml-3 mb-0">No sections to add yet.</p>
              </div> 
              @endif
            </div>
          </div>
          <div class="mt-3 mg-b-0">
            @if ($sections->count())
              <button class="btn ripple btn-primary btn-block" id="add-sections"><i class="fa fa-plus"></i> Add</button> 
            @endif
          </div>
        </div> {{-- body end --}}        
      </div>
    </div>
  </div>
</div>
<!-- End page-section-modal-->
@endsection