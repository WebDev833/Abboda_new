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
   <a class="btn ripple btn-primary add-media" href="javascript:void(0);"><i class="fe fe-file-plus"></i> Add Media</a>
    <a class="btn ripple btn-secondary refresh-media" href="javascript:void(0);"><i class="fe fe-refresh-ccw"></i> Refresh</a>
  {{-- <select id="initSelectCollections" class="form-control select2 mr-3">
     
	</select> --}}
 </div>
</div>
<!-- End Page Header -->
<!-- Row -->
<div class="row" id="media-library">
</div>
<!-- End Row -->
@endsection

@section('vendor-styles')
  {{-- <link href="{{ asset('admin-assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet"> --}}
  <link href="{{ asset('admin-assets/plugins/dropzone/bootstrap.min.css') }}" rel="stylesheet">

@endsection

@section('page-scripts')
<!-- Select2 js-->
{{-- <script src="{{ asset('admin-assets/plugins/select2/js/select2.min.js') }}"></script> --}}

<script type="text/template" data-template="mediaitem">
  <div class="col-xs-12 col-sm-6 col-md-3 media-item">
    <div class="card custom-card">
      <div class="card-body text-center">
        <div class="text-center">
          <img class="img-fluid" 
              src="${src}"
              data-name="${file_name}"
              data-type="${mime_type}"
              data-size="${size}"
              data-uuid="${uuid}"
              alt="Card image">
        </div>
        <h5 class="mb-1 mt-3 ">${file_name}</h5>
        <p class="mb-2 mt-1 tx-inverse">Size : ${formated_size}</p>
        <p class="mb-1"><small>Collection : ${collection_name}</small></p>
        <p class="text-muted text-center mt-1">${updated_at}</p>
        <div class="justify-content-center text-center mt-3 d-flex">
          <a href="${url}" target="_blank" class="btn ripple btn-info btn-icon mr-3">
            <i class="fe fe-eye"></i>
          </a>
          <a href="javascript:void(0);" class="btn ripple btn-danger btn-icon delete-media" data-uuid="${uuid}" >
            <i class="fe fe-trash-2"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</script>
<script>
  function render(props) {
    return function (tok, i) {
        return (i % 2) ? props[tok] : tok;
    };
  }
  /**
    * load media with ajax
    * and reset the thumbnails
    */
  function loadMedia(url) {
    var itemTpl = $('script[data-template="mediaitem"]').text().split(/\$\{(.+?)\}/g);
    var items = [];
    var mediaItems = $('#media-library');
    $.ajax({
        url: url,
        type: 'GET',
        success: function (data, status) {
            if (status === 'success') {
                data = JSON.parse(data);
                data.forEach(function (item) {
                    items.push({
                        src: item.thumb,
                        url: item.url,
                        file_name: item.file_name,
                        mime_type: item.mime_type,
                        size: item.size,
                        collection_name : item.collection_name,
                        formated_size: item.formated_size,
                        uuid: item.custom_properties.uuid,
                        name: item.name,
                        updated_at: item.updated_at,
                    });
                });
            } else {
              //  mediaItems.find('.card.loader').html('Error please refresh page or use (Ctrl+F5)');
            }
        },
        error: function (data, status, error) {
          //  mediaItems.find('.card.loader').html('Error please refresh page or use (Ctrl+F5)');
        },
        complete: function (data, status) {
            if (status === 'success') {
                mediaItems.html(items.map(function (item) {
                    return itemTpl.map(render(item)).join('');
                }));
                //mediaItems.find('.card.loader').remove();
                // initMediaItemsSize();
                // initDeleteButtons();
            } else {
              // mediaItems.find('.card.loader').html('Error please refresh page or use (Ctrl+F5)');
            }
        }
    });
  }

  $(document).on('click','.delete-media',function(){
    var _this = $(this);
    $.post("{{route('admin.mediadelete')}}",
      { _token: '{{csrf_token()}}',
        uuid: $(this).data('uuid'),
      }, function (data) {
        _this.parents('.media-item').remove();
      });
  });
  loadMedia("{{ route('admin.allmedia')}}");
  $(document).on('click','.refresh-media',function(){
    $('#media-library').html('');
    loadMedia("{{ route('admin.allmedia')}}");
  });
</script>

<script src="{{ asset('admin-assets/plugins/dropzone/dropzone.min.js') }}"></script>

<script>
  Dropzone.autoDiscover = false;
</script>
<script>
function initMediaLibrary(elem)
{
  var obj = elem.dropzone({
        url: "{{route('admin.mediascreate')}}",
        addRemoveLinks: true,
        accept: function (file, done) {
            dzAccept(file, done, this.element, "{!!config('medialibrary.icons_folder')!!}");
        },
        sending: function (file, xhr, formData) {
            dzSending(this, file, formData, '{!! csrf_token() !!}');
        },
        complete: function (file) {
            // $('#mediaModal #refreshMedia').trigger('click');
            if (file._removeLink) {
                file._removeLink.textContent = this.options.dictRemoveFile;
            }
            if (file.previewElement) {
                return file.previewElement.classList.add("dz-complete");
            }
        },
        removedfile: function (file) {
            //var _this = $('.card.clickble').find('button[data-uuid="' + file.upload.uuid + '"]');
            $.post("{{route('admin.mediadelete')}}",
                {
                    _token: '{!! csrf_token() !!}',
                    uuid: file.upload.uuid,
                }, function (data) {
                    // if (data && data.data === true) {
                    //     _this.parent('.card.clickble').parent('div.media-item').slideUp();
                         if (file.previewElement != null && file.previewElement.parentNode != null) {
                             file.previewElement.parentNode.removeChild(file.previewElement);
                         }
                    // } else {
                        
                    // }
                }).fail(function () {
               
            });
        }
    });
  return obj;
}

  $(document).on('click','.add-media',function(){
    $('.addmediamodelbody').html('');
    $('.addmediamodelbody').html('<div style="width: 100%" class="dropzone default" id="default" data-field="default">\
      <input type="hidden" name="default">\
    </div>');
    var objs = initMediaLibrary($('.dropzone.default'));
    objs[0].dropzone.options.init();
    $('#addmediamodel').modal({
      backdrop : 'static'
    });
    
  });
</script>
@endsection

@section('extras')
    	<div class="modal" id="addmediamodel">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content modal-content-demo">
						<div class="modal-header">
							<h6 class="modal-title">Add Media</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
						</div>
						<div class="modal-body addmediamodelbody">
              
						</div>
						<div class="modal-footer">
							{{-- <button class="btn ripple btn-primary" type="button">Save changes</button> --}}
							<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
						</div>
					</div>
				</div>
			</div>
@endsection