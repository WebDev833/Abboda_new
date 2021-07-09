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
{!! Form::model($driver, ['route'=>['admin.editdriversave',$driver->id],'data-parsley-validate'=>'']) !!}
@method('PATCH')
<div class="row">
  <div class="col-md-8 col-sm-12">
    <div class="card custom-card">
      <div class="card-body">
        <div>
          <h6 class="card-title mb-2">Driver Fields</h6>
          <p class="text-muted card-sub-title"><span class="tx-danger">Note: </span> Fields marked as (*) are required fields.</p>
        </div>
          @include('admin.components.errors')
          @include('admin.components.success')
          <div class="">
            <div class="row">
              <div class="col-lg-12 form-group">
                <label class="form-label">Name: <span class="tx-danger">*</span></label>
                {!! Form::text('name', null, ["class"=>"form-control","placeholder"=>"Enter Name","required"=>"required"]) !!}
              </div>
              <div class="col-lg-12 form-group">
                <label class="form-label">Phone: <span class="tx-danger">*</span></label>
                {!! Form::text('phone', null, ["class"=>"form-control","placeholder"=>"Enter Phone","required"=>"required"]) !!}
              </div>
              <div class="col-lg-12 form-group">
                <label class="form-label">Age: </label>
                {!! Form::text('age',$driver->driverprofile->age, ["class"=>"form-control","placeholder"=>"Enter age"]) !!}
              </div>
              <div class="col-lg-12 form-group">
                <label class="form-label">Area: </label>
                <div class="parsley-select" id="slWrapper3">
                  {!! Form::select('area_id', $areas, $driver->driverprofile->area_id,["class"=>"form-control select2-search","data-parsley-class-handler"=>"#slWrapper3","data-parsley-errors-container"=>"#slErrorContainer3","data-placeholder"=>"select Area"]) !!}
                    <div id="slErrorContainer3"></div>
                </div>
              </div>
              <div class="col-lg-12 form-group">
                <label class="form-label">Vehicle Type: </label>
                {!! Form::text('vehicle_no', $driver->driverprofile->vehicle_no, ["class"=>"form-control","placeholder"=>"Vehicle type"]) !!}
              </div>
              <div class="col-lg-12 form-group">
                <label class="form-label">ID Number: <span class="tx-danger">*</span></label>
                {!! Form::text('id_number', $driver->driverprofile->id_number, ["class"=>"form-control","placeholder"=>"ID number","required"=>"required"]) !!}
              </div>
              <div class="col-lg-12 form-group">
                <label class="form-label">Social Security Number: <span class="tx-danger">*</span></label>
                {!! Form::text('social_security_number', $driver->driverprofile->social_security_number, ["class"=>"form-control","placeholder"=>"Social Security Number","required"=>"required"]) !!}
              </div>
              <div class="col-lg-12 form-group">
                <label class="form-label">Gender: </label>
                <div class="parsley-select" id="slWrapper2">
                  {!! Form::select('gender',[''=>'','male'=>'Male','female'=>'Female','other'=>'Other'],$driver->driverprofile->gender, ["class"=>"form-control select2-no-search","data-parsley-class-handler"=>"#slWrapper2","data-parsley-errors-container"=>"#slErrorContainer2","data-placeholder"=>"select Gender"]) !!}
                  <div id="slErrorContainer2"></div>
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
          <h6 class="card-title mb-1">Driver Image</h6>
          
          <div style="width: 100%" class="dropzone mavatar" id="avatar" data-field="avatar">
                <input type="hidden" name="avatar">
          </div>
          <div class="w-100 text-right">
            <a class="btn ripple btn-success mt-1 pd-x-30" href="#loadMediaModal" data-dropzone="avatar" data-toggle="modal" data-target="#mediaModal">From Media</a>
          </div>
          <h6 class="card-title mb-1">Car Registration</h6>
          
          <div style="width: 100%" class="dropzone identity_image" id="identity_image" data-field="identity_image">
                <input type="hidden" name="identity_image">
          </div>
          <div class="w-100 text-right">
            <a class="btn ripple btn-success mt-1 pd-x-30" href="#loadMediaModal" data-dropzone="identity_image" data-toggle="modal" data-target="#mediaModal">From Media</a>
          </div>
          <h6 class="card-title mb-1">Car Insurance</h6>
          
          <div style="width: 100%" class="dropzone car_insurance" id="car_insurance" data-field="car_insurance">
                <input type="hidden" name="car_insurance">
          </div>
          <div class="w-100 text-right">
            <a class="btn ripple btn-success mt-1 pd-x-30" href="#loadMediaModal" data-dropzone="car_insurance" data-toggle="modal" data-target="#mediaModal">From Media</a>
          </div>
          <p class="mg-b-10">Driver Status</p>
          <div class="parsley-checkbox" id="cbWrapper">
              <label class="ckbox mg-b-5">
                {!! Form::checkbox('active', 1, $driver->driverprofile->active) !!}
                <span>Active</span>
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
var user_avatar = '';
@if(isset($driver) && $driver->hasMedia('avatar'))
    user_avatar = {
    name: "{!! $driver->getFirstMedia('avatar')->name !!}",
    size: "{!! $driver->getFirstMedia('avatar')->size !!}",
    type: "{!! $driver->getFirstMedia('avatar')->mime_type !!}",
    collection_name: "{!! $driver->getFirstMedia('avatar')->collection_name !!}"
    
};
console.log(user_avatar);

@endif
var dz_user_avatar = $(".dropzone.mavatar").dropzone({
        url: "{{route('admin.mediascreate')}}",
        addRemoveLinks: true,
        maxFiles: 1,
        init: function () {
            @if(isset($driver) && $driver->hasMedia('avatar'))
            dzInit(this, user_avatar, '{!! url($driver->getFirstMediaUrl('avatar','thumb')) !!}')
            @endif
        },
        accept: function (file, done) {
            dzAccept(file, done, this.element, "{!!config('medialibrary.icons_folder')!!}");
        },
        sending: function (file, xhr, formData) {
            dzSending(this, file, formData, '{!! csrf_token() !!}');
        },
        maxfilesexceeded: function (file) {
            dz_user_avatar[0].mockFile = '';
            dzMaxfile(this, file);
        },
        complete: function (file) {
            dzComplete(this, file, user_avatar, dz_user_avatar[0].mockFile);
            dz_user_avatar[0].mockFile = file;
        },
        removedfile: function (file) {
            dzRemoveFile(
                file, user_avatar, '{!! route("admin.deletedriveravatarmedia") !!}',
                'avatar', '{!! isset($driver) ? $driver->id : 0 !!}', '{{route("admin.mediadelete")}}', '{!! csrf_token() !!}'
            );
        }
    });
dz_user_avatar[0].mockFile = user_avatar;
dropzoneFields['avatar'] = dz_user_avatar;
</script>

<script>
var user_identity_image = '';
@if(isset($driver) && $driver->hasMedia('identity_image'))
    user_identity_image = {
    name: "{!! $driver->getFirstMedia('identity_image')->name !!}",
    size: "{!! $driver->getFirstMedia('identity_image')->size !!}",
    type: "{!! $driver->getFirstMedia('identity_image')->mime_type !!}",
    collection_name: "{!! $driver->getFirstMedia('identity_image')->collection_name !!}"
};
@endif
var dz_user_identity_image = $(".dropzone.identity_image").dropzone({
        url: "{{route('admin.mediascreate')}}",
        addRemoveLinks: true,
        maxFiles: 1,
        init: function () {
            @if(isset($driver) && $driver->hasMedia('identity_image'))
            dzInit(this, user_identity_image, '{!! url($driver->getFirstMediaUrl('identity_image','thumb')) !!}')
            @endif
        },
        accept: function (file, done) {
            dzAccept(file, done, this.element, "{!!config('medialibrary.icons_folder')!!}");
        },
        sending: function (file, xhr, formData) {
            dzSending(this, file, formData, '{!! csrf_token() !!}');
        },
        maxfilesexceeded: function (file) {
            dz_user_identity_image[0].mockFile = '';
            dzMaxfile(this, file);
        },
        complete: function (file) {
            dzComplete(this, file, user_identity_image, dz_user_identity_image[0].mockFile);
            dz_user_identity_image[0].mockFile = file;
        },
        removedfile: function (file) {
            dzRemoveFile(
                file, user_identity_image, '{!! route("admin.deletedriveridentitymedia") !!}',
                'identity_image', '{!! isset($driver) ? $driver->id : 0 !!}', '{{route("admin.mediadelete")}}', '{!! csrf_token() !!}'
            );
        }
    });
dz_user_identity_image[0].mockFile = user_identity_image;
dropzoneFields['identity_image'] = dz_user_identity_image;
</script>
<script>
var user_car_insurance = '';
@if(isset($driver) && $driver->hasMedia('car_insurance'))
user_car_insurance = {
    name: "{!! $driver->getFirstMedia('car_insurance')->name !!}",
    size: "{!! $driver->getFirstMedia('car_insurance')->size !!}",
    type: "{!! $driver->getFirstMedia('car_insurance')->mime_type !!}",
    collection_name: "{!! $driver->getFirstMedia('car_insurance')->collection_name !!}"
};
console.log(user_car_insurance);
@endif
var dz_user_car_insurance = $(".dropzone.car_insurance").dropzone({
        url: "{{route('admin.mediascreate')}}",
        addRemoveLinks: true,
        maxFiles: 1,
        init: function () {
            @if(isset($driver) && $driver->hasMedia('car_insurance'))
            dzInit(this, user_car_insurance, '{!! url($driver->getFirstMediaUrl('car_insurance','thumb')) !!}')
            @endif
        },
        accept: function (file, done) {
            dzAccept(file, done, this.element, "{!!config('medialibrary.icons_folder')!!}");
        },
        sending: function (file, xhr, formData) {
            dzSending(this, file, formData, '{!! csrf_token() !!}');
        },
        maxfilesexceeded: function (file) {
            dz_user_car_insurance[0].mockFile = '';
            dzMaxfile(this, file);
        },
        complete: function (file) {
            dzComplete(this, file, user_car_insurance, dz_user_car_insurance[0].mockFile);
            dz_user_car_insurance[0].mockFile = file;
        },
        removedfile: function (file) {
            dzRemoveFile(
                file, user_car_insurance, '{!! route("admin.deletedriveridentitymedia") !!}',
                'car_insurance', '{!! isset($driver) ? $driver->id : 0 !!}', '{{route("admin.mediadelete")}}', '{!! csrf_token() !!}'
            );
        }
    });
dz_user_car_insurance[0].mockFile = user_car_insurance;
dropzoneFields['car_insurance'] = dz_user_car_insurance;
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

