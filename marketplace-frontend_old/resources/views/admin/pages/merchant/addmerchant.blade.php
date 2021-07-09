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
{!! Form::open(['route'=>'admin.addmerchantsave','method'=>'POST','data-parsley-validate'=>'']) !!}
<div class="row">
  <div class="col-md-8 col-sm-12">
    <div class="card custom-card">
      <div class="card-body">
        <div>
          <h6 class="card-title mb-2">Merchant Fields</h6>
          <p class="text-muted card-sub-title"><span class="tx-danger">Note: </span> Fields marked as (*) are required fields.</p>
        </div>
          @include('admin.components.errors')
          @include('admin.components.success')
          <div class="">
            <div class="row">
              <div class="col-lg-6 form-group">
                <label class="form-label">Company Type: <span class="tx-danger">*</span></label>
                <div class="parsley-select" id="slWrapper4">
                  {!! Form::select('companytype_id', $companytypes, null,["class"=>"form-control select2-no-search","data-parsley-class-handler"=>"#slWrapper4","data-parsley-errors-container"=>"#slErrorContainer4","data-placeholder"=>"select Merchant Type","required"=>"required"]) !!}
                    <div id="slErrorContainer4"></div>
                </div>
              </div>
              <div class="col-lg-6 form-group">
                <label class="form-label">Area: <span class="tx-danger">*</span></label>
                <div class="parsley-select" id="slWrapper3">
                  {!! Form::select('area_id', $areas, null,["class"=>"form-control select2-search","data-parsley-class-handler"=>"#slWrapper3","data-parsley-errors-container"=>"#slErrorContainer3","data-placeholder"=>"select Area","required"=>"required"]) !!}
                    <div id="slErrorContainer3"></div>
                </div>
              </div>
              <div class="col-lg-6 form-group">
                <label class="form-label">Name: <span class="tx-danger">*</span></label>
                {!! Form::text('name', null, ["class"=>"form-control","placeholder"=>"Enter Name","required"=>"required"]) !!}
              </div>
              <div class="col-lg-6 form-group">
                <label class="form-label">Description: <span class="tx-danger">*</span></label>
                {!! Form::text('description', null, ["class"=>"form-control","placeholder"=>"Enter Description","required"=>"required"]) !!}
              </div>
              <div class="col-lg-6 form-group">
                <label class="form-label">Email: <span class="tx-danger">*</span></label>
                {!! Form::email('email', null, ["class"=>"form-control","placeholder"=>"Enter Email","required"=>"required"]) !!}
              </div>
              <div class="col-lg-6 form-group">
                <label class="form-label">Phone: <span class="tx-danger">*</span></label>
                {!! Form::text('phone', null, ["class"=>"form-control","placeholder"=>"Enter Phone","required"=>"required",	"data-parsley-type"=>"alphanum"]) !!}
              </div>
              <div class="col-lg-6 form-group">
                <label class="form-label">Rating: <span class="tx-danger">*</span></label>
                {!! Form::text('rating', null, ["class"=>"form-control","placeholder"=>"Enter rating eg:1,2,5,etc","required"=>"required",'max'=>5,'min'=>0]) !!}
              </div>

              <div class="col-lg-6 form-group">
                <label class="form-label">Slug: <span class="tx-danger">*</span></label>
                {!! Form::text('slug', null, ["class"=>"form-control","placeholder"=>"Enter Slug","required"=>"required"]) !!}
              </div>
              <div class="col-lg-6 form-group">
                <label class="form-label">Latitude: <span class="tx-danger">*</span></label>
                {!! Form::text('latitude', null, ["class"=>"form-control","placeholder"=>"Enter Latitude","required"=>"required"]) !!}
              </div>
              <div class="col-lg-6 form-group">
                <label class="form-label">Longitude: <span class="tx-danger">*</span></label>
                {!! Form::text('longitude', null, ["class"=>"form-control","placeholder"=>"Enter Longitude","required"=>"required"]) !!}
              </div>
              <div class="col-lg-12 form-group">
                <label class="form-label">Address: <span class="tx-danger">*</span></label>
                {!! Form::text('address', null, ["class"=>"form-control","placeholder"=>"Enter Address","required"=>"required"]) !!}
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
          <h6 class="card-title mb-1">Merchant Image</h6>
          
          <div style="width: 100%" class="dropzone merchant_image" id="merchant_image" data-field="merchant_image">
                <input type="hidden" name="merchant_image">
          </div>
          <div class="w-100 text-right">
            <a class="btn ripple btn-success mt-1 pd-x-30" href="#loadMediaModal" data-dropzone="merchant_image" data-toggle="modal" data-target="#mediaModal">From Media</a>
          </div>
          <p class="mg-b-10 mt-2">Merchant Status</p>
          <div class="parsley-checkbox" id="cbWrapper">
              <label class="ckbox mg-b-5">
                {!! Form::checkbox('active', 1, true) !!}
                <span>Active</span>
              </label>
          </div>
          <p class="mg-b-10 mt-3">Catalog Status</p>
          <div class="parsley-checkbox" id="cbWrapper">
              <label class="ckbox mg-b-5">
                {!! Form::checkbox('catalog_enabled', 1) !!}
                <span>Enable</span>
              </label>
          </div>
          <div id="cbErrorContainer"></div>
          <div class="mg-t-20">
            <button class="btn ripple btn-primary pd-x-30" type="submit">Save</button>
            <a class="btn ripple btn-danger pd-x-30 ml-3" href="{{route('admin.drivers')}}" >Cancel</a>
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
  <link href="{{ asset('admin-assets/plugins/dropzone/bootstrap.min.css') }}" rel="stylesheet">
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



<script src="{{ asset('admin-assets/plugins/dropzone/dropzone.min.js') }}"></script>
<script type="text/javascript">
    Dropzone.autoDiscover = false;
    var dropzoneFields = [];
</script>

<script>
var merchant_image = '';
@if(isset($merchant) && $merchant->hasMedia('merchant_image'))
    merchant_image = {
    name: "{!! $merchant->getFirstMedia('merchant_image')->name !!}",
    size: "{!! $merchant->getFirstMedia('merchant_image')->size !!}",
    type: "{!! $merchant->getFirstMedia('merchant_image')->mime_type !!}",
    collection_name: "{!! $merchant->getFirstMedia('merchant_image')->collection_name !!}"
};
@endif
var dz_merchant_image = $(".dropzone.merchant_image").dropzone({
        url: "{{route('admin.mediascreate')}}",
        addRemoveLinks: true,
        maxFiles: 1,
        init: function () {
            @if(isset($merchant) && $merchant->hasMedia('merchant_image'))
            dzInit(this, merchant_image, '{!! url($merchant->getFirstMediaUrl('merchant_image','thumb')) !!}')
            @endif
        },
        accept: function (file, done) {
            dzAccept(file, done, this.element, "{!!config('medialibrary.icons_folder')!!}");
        },
        sending: function (file, xhr, formData) {
            dzSending(this, file, formData, '{!! csrf_token() !!}');
        },
        maxfilesexceeded: function (file) {
            dz_merchant_image[0].mockFile = '';
            dzMaxfile(this, file);
        },
        complete: function (file) {
            dzComplete(this, file, merchant_image, dz_merchant_image[0].mockFile);
            dz_merchant_image[0].mockFile = file;
        },
        removedfile: function (file) {
            dzRemoveFile(
                file, merchant_image, '{!! route("admin.deletemerchantimagemedia") !!}',
                'merchant_image', '{!! isset($merchant) ? $merchant->id : 0 !!}', '{{route("admin.mediadelete")}}', '{!! csrf_token() !!}'
            );
        }
    });
dz_merchant_image[0].mockFile = merchant_image;
dropzoneFields['merchant_image'] = dz_merchant_image;
</script>


<script type="text/template" data-template="mediaitem">
    <div class="col-sm-3">
        <div class="card clickble">
            <img class="card-img"
                  src="${src}"
                  data-name="${file_name}"
                  data-type="${mime_type}"
                  data-size="${size}"
                  data-uuid="${uuid}"
                  alt="Card image">
            <div class="card-footer">
                <small class="media-item-text-fix">${name} (${formated_size})</small><br> <small class="text-muted media-item-text-fix">${updated_at}</small>
            </div>
        </div>
    </div>
</script>

<script>
var triggerButton;
var dropzoneIndex = '';

/**
* add selected media to dropzone
*/
function initDropzone(index = '') {
    var dz = dropzoneFields[index][0];
    $('#mediaModal .card.clickble').on('click', function () {
        var img = $(this).find('.card-img');
        console.log(dz.mockFile);
        if (dz.mockFile !== '') {
            dz.dropzone.removeFile(dz.mockFile);
        }
        var mockFile = {name: img.data('name'), size: img.data('size'), type: img.data('type'), upload: {uuid: img.data('uuid')}};
        dz.mockFile = mockFile;
        dz.dropzone.element.children[0].value = img.data('uuid');
        dz.dropzone.options.addedfile.call(dz.dropzone, mockFile);
        dz.dropzone.options.thumbnail.call(dz.dropzone, mockFile, img.attr('src'));
        dz.dropzone.previewsContainer.lastChild.classList.add('dz-success');
        dz.dropzone.previewsContainer.lastChild.classList.add('dz-complete');
        $('#mediaModal').modal('hide');
    });
}


/**
 * load media with ajax
 */
function loadMedia(url) {

  var itemTpl = $('script[data-template="mediaitem"]').text().split(/\$\{(.+?)\}/g);
  var items = [];
  var mediaItems = $('#mediaModal .medias-items');
  $.ajax({
      url: url,
      type: 'GET',
      success: function (data, status) {
          if(status === 'success'){
              data = JSON.parse(data);
              data.forEach(function (item) {
                  items.push({
                      src: item.thumb,
                      file_name: item.file_name,
                      mime_type: item.mime_type,
                      size: item.size,
                      formated_size: item.formated_size,
                      uuid: item.custom_properties.uuid,
                      name: item.name,
                      updated_at: item.updated_at,
                  });
              });
          }else{
              mediaItems.find('.card.loader').html('Error please refresh page or use (Ctrl+F5)');
          }
      },
      error : function(data, status, error){
          mediaItems.find('.card.loader').html('Error please refresh page or use (Ctrl+F5)');
      },
      complete: function (data, status) {
          if (status === 'success') {
              mediaItems.html(items.map(function (item) {
                  return itemTpl.map(render(item)).join('');
              }));
              mediaItems.find('.card.loader').remove();
              initDropzone(dropzoneIndex);
          }else{
              mediaItems.find('.card.loader').html('Error please refresh page or use (Ctrl+F5)');
          }
      }
  });
}

  $('#mediaModal').on('show.bs.modal',function (event) {
    triggerButton = $(event.relatedTarget) // Button that triggered the modal
    dropzoneIndex = triggerButton.data('dropzone'); // Extract info from data-* attributes
    loadMedia('{{route("admin.allmedia")}}/'+dropzoneIndex);
    //initSelectCollection();
});

</script>
@endsection
@section('extras')
<div id="mediaModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header align-items-stretch">
                <h5 class="modal-title flex-grow-1">Media Library</h5>                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row medias-items">
                    <div class="card loader">
                        <div class="overlay">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <span>Select file to upload it</span>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

