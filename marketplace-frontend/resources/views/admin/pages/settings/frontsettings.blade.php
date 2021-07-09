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
{!! Form::open(['route'=>'admin.frontsettingssave','data-parsley-validate'=>'']) !!}
@method('PATCH')
<div class="row">
    <div class="col-md-8 col-sm-12">
        <div class="card custom-card">
            <div class="card-body">
                <div>
                    <h6 class="card-title mb-2">Settings</h6>
                </div>
                @include('admin.components.errors')
                @include('admin.components.success')
                <div class="">
                
                    <div class="row">
                        {{-- Front App Name --}}
                        <div class="col-lg-12 form-group">
                            {!! Form::label('front_app_name', trans('admin.settings.front_app_name'),['class' =>
                            'form-label']) !!}
                            {!! Form::text('front_app_name', setting('front_app_name'), ['class' =>
                            'form-control','placeholder'=>
                            trans('admin.settings.front_app_name_placeholder'),'required'=>'required']) !!}


                        </div>

                        {{-- Front Email --}}
                        <div class="col-lg-12 form-group">
                            {!! Form::label('front_email', trans('admin.settings.front_email'),['class' =>
                            'form-label']) !!}
                            {!! Form::text('front_email', setting('front_email'), ['class' =>
                            'form-control','placeholder'=>
                            trans('admin.settings.front_email_placeholder'),'required'=>'required']) !!}


                        </div>

                        {{-- Front Phone --}}
                        <div class="col-lg-12 form-group">
                            {!! Form::label('front_phone', trans('admin.settings.front_phone'),['class' =>
                            'form-label']) !!}
                            {!! Form::text('front_phone', setting('front_phone'), ['class' =>
                            'form-control','placeholder'=>
                            trans('admin.settings.front_phone_placeholder'),'required'=>'required']) !!}


                        </div>

                        {{-- language setting - dropdown --}}
                        <div class="col-lg-12 form-group">
                            {!! Form::label('front_app_language', trans('admin.settings.front_app_language'),['class' =>
                            'form-label']) !!}
                            {!! Form::text('front_app_language', setting('front_app_language'), ['class' =>
                            'form-control','placeholder'=>
                            trans('admin.settings.front_app_language_placeholder'),'required'=>'required','readonly'=>'readonly'])
                            !!}


                        </div>

                        {{-- Timezone setting - dropdown --}}
                        <div class="col-lg-12 form-group">
                            {!! Form::label('front_timezone', trans('admin.settings.front_timezone'),['class' =>
                            'form-label']) !!}
                            {!! Form::text('front_timezone', setting('front_timezone'), ['class' =>
                            'form-control','placeholder'=>
                            trans('admin.settings.front_timezone_placeholder'),'required'=>'required','readonly'=>'readonly'])
                            !!}


                        </div>
                        {{-- country code setting text --}}
                        <div class="col-lg-12 form-group">
                            {!! Form::label('front_country_code', trans('admin.settings.front_country_code'),['class' =>
                            'form-label']) !!}
                            {!! Form::text('front_country_code', setting('front_country_code'), ['class' =>
                            'form-control','placeholder'=>
                            trans('admin.settings.front_country_code_placeholder'),'required'=>'required']) !!}


                        </div>

                        {{-- Google API key setting --}}
                        <div class="col-lg-12 form-group">
                            {!! Form::label('google_geocoding_api_key',
                            trans('admin.settings.google_geocoding_api_key'),['class' =>
                            'form-label']) !!}
                            {!! Form::text('google_geocoding_api_key', setting('google_geocoding_api_key'), ['class' =>
                            'form-control','placeholder'=>
                            trans('admin.settings.google_geocoding_api_key_placeholder'),'required'=>'required'])
                            !!}


                        </div>

                        {{-- Max Order KMS setting --}}
                        <div class="col-lg-12 form-group">
                            {!! Form::label('max_order_kms', trans('admin.settings.max_order_kms'),['class' =>
                            'form-label']) !!}
                            {!! Form::text('max_order_kms', setting('max_order_kms'), ['class' =>
                            'form-control','placeholder'=>
                            trans('admin.settings.max_order_kms_placeholder'),'required'=>'required']) !!}


                        </div>

                        {{-- front_stripe_key setting --}}
                        <div class="col-lg-12 form-group">
                            {!! Form::label('front_stripe_key', trans('admin.settings.front_stripe_key'),['class' =>
                            'form-label']) !!}
                            {!! Form::text('front_stripe_key', setting('front_stripe_key'), ['class' =>
                            'form-control','placeholder'=>
                            trans('admin.settings.front_stripe_key_placeholder'),'required'=>'required']) !!}


                        </div>

                        {{-- front_stripe_secret setting --}}
                        <div class="col-lg-12 form-group">
                            {!! Form::label('front_stripe_secret', trans('admin.settings.front_stripe_secret'),['class'
                            => 'form-label']) !!}
                            {!! Form::text('front_stripe_secret', setting('front_stripe_secret'), ['class' =>
                            'form-control','placeholder'=>
                            trans('admin.settings.front_stripe_secret_placeholder'),'required'=>'required']) !!}


                        </div>


                        {{-- front_fixed_shipping setting --}}
                        <div class="col-lg-12 form-group">
                            {!! Form::label('front_fixed_shipping',
                            trans('admin.settings.front_fixed_shipping'),['class' => 'form-label']) !!}
                            {!! Form::text('front_fixed_shipping', setting('front_fixed_shipping'), ['class' =>
                            'form-control','placeholder'=>
                            trans('admin.settings.front_fixed_shipping_placeholder'),'required'=>'required']) !!}


                        </div>

                        {{-- front_extra_km_charges setting --}}
                        <div class="col-lg-12 form-group">
                            {!! Form::label('front_extra_km_charges',
                            trans('admin.settings.front_extra_km_charges'),['class' => 'form-label'])
                            !!}
                            {!! Form::text('front_extra_km_charges', setting('front_extra_km_charges'), ['class' =>
                            'form-control','placeholder'=>
                            trans('admin.settings.front_extra_km_charges_placeholder'),'required'=>'required'])
                            !!}


                        </div>
                      
                        <div>
<h2> USA: </h2>
</div>
{{-- front_service_charges setting --}}
                        <div class="col-lg-12 form-group">
                            {!! Form::label('front_service_charges',
                            trans('admin.settings.front_service_charges'),['class' => 'form-label']) !!}
                            {!! Form::text('front_service_charges', setting('front_service_charges'), ['class' =>
                            'form-control','placeholder'=>
                            trans('admin.settings.front_service_charges_placeholder'),'required'=>'required']) !!}


                        </div>
                        {{-- base_shipping_charges setting --}}
                        <div class="col-lg-12 form-group">
                            {!! Form::label('base_shipping_charges',
                            trans('base shipping charges'),['class' => 'form-label']) !!}
                            {!! Form::text('base_shipping_charges', setting('base_shipping_charges'), ['class' =>
                            'form-control','placeholder'=>
                            trans('base shipping charges'),'required'=>'required']) !!}


                        </div>

{{-- distance_measure_type setting --}}
                        <div class="col-lg-12 form-group">
                            {!! Form::label('distance_measure_type',
                            trans('distance measure type'),['class' => 'form-label']) !!}
                            {!! Form::text('distance_measure_type_us', setting('distance_measure_type_us'), ['class' =>
                            'form-control','placeholder'=>
                            trans('distance measure type'),'required'=>'required']) !!}


                        </div>
                        {{-- limit_range_miles setting --}}
                        <div class="col-lg-12 form-group">
                            {!! Form::label('distance_measure_type',
                            trans('limit range miles'),['class' => 'form-label']) !!}
                            {!! Form::text('limit_range_miles', setting('limit_range_miles'), ['class' =>
                            'form-control','placeholder'=>
                            trans('limit range miles'),'required'=>'required']) !!}


                        </div>
                    
                        {{-- shipping_per_mile_charges setting --}}
                        <div class="col-lg-12 form-group">
                            {!! Form::label('shipping_per_mile_charges',
                            trans('shipping per mile charges'),['class' => 'form-label']) !!}
                            {!! Form::text('shipping_per_mile_charges', setting('shipping_per_mile_charges'), ['class' =>
                            'form-control','placeholder'=>
                            trans('shipping per mile charges'),'required'=>'required']) !!}


                        </div>
                     
                      

                        {{-- front_driver_share setting --}}
                        <div class="col-lg-12 form-group">
                            {!! Form::label('front_driver_share', trans('admin.settings.front_driver_share'),['class' =>
                            'form-label']) !!}
                            {!! Form::text('front_driver_share', setting('front_driver_share'), ['class' =>
                            'form-control','placeholder'=>
                            trans('admin.settings.front_driver_share_placeholder'),'required'=>'required']) !!}
                        </div>
                        
                        <div>
<h2> Egypt: </h2>
</div>
{{-- front_service_charges setting --}}
                        <div class="col-lg-12 form-group">
                            {!! Form::label('front_service_charges',
                            trans('admin.settings.front_service_charges'),['class' => 'form-label']) !!}
                            {!! Form::text('front_service_charges_eg', setting('front_service_charges_eg'), ['class' =>
                            'form-control','placeholder'=>
                            trans('admin.settings.front_service_charges_placeholder'),'required'=>'required']) !!}


                        </div>
                        {{-- base_shipping_charges setting --}}
                        <div class="col-lg-12 form-group">
                            {!! Form::label('base_shipping_charges',
                            trans('base shipping charges'),['class' => 'form-label']) !!}
                            {!! Form::text('base_shipping_charges_eg', setting('base_shipping_charges_eg'), ['class' =>
                            'form-control','placeholder'=>
                            trans('base shipping charges'),'required'=>'required']) !!}


                        </div>
                        
{{-- shipping_per_km_charges setting --}}
                        <div class="col-lg-12 form-group">
                            {!! Form::label('shipping_per_km_charges',
                            trans('shipping per km charges'),['class' => 'form-label']) !!}
                            {!! Form::text('shipping_per_km_charges', setting('shipping_per_km_charges'), ['class' =>
                            'form-control','placeholder'=>
                            trans('shipping per km charges'),'required'=>'required']) !!}


                        </div>
                        {{-- distance_measure_type setting --}}
                        <div class="col-lg-12 form-group">
                            {!! Form::label('distance_measure_type',
                            trans('distance measure type'),['class' => 'form-label']) !!}
                            {!! Form::text('distance_measure_type_eg', setting('distance_measure_type_eg'), ['class' =>
                            'form-control','placeholder'=>
                            trans('distance measure type'),'required'=>'required']) !!}


                        </div>
                        {{-- limit_range_km setting --}}
                        <div class="col-lg-12 form-group">
                            {!! Form::label('limit_range_km',
                            trans('limit range km'),['class' => 'form-label']) !!}
                            {!! Form::text('limit_range_km', setting('limit_range_km'), ['class' =>
                            'form-control','placeholder'=>
                            trans('limit range km'),'required'=>'required']) !!}


                        </div>
                        {{-- front_driver_share setting --}}
                        <div class="col-lg-12 form-group">
                            {!! Form::label('front_driver_share', trans('admin.settings.front_driver_share'),['class' =>
                            'form-label']) !!}
                            {!! Form::text('front_driver_share_eg', setting('front_driver_share_eg'), ['class' =>
                            'form-control','placeholder'=>
                            trans('admin.settings.front_driver_share_placeholder'),'required'=>'required']) !!}
                        </div>
<div class="col-lg-6 form-group">
<h6 class="card-title mb-1">Frontend Logo</h6>
<div style="width: 100%" class="dropzone front_logo" id="front_logo" data-field="front_logo">
    <input type="hidden" name="front_logo">
</div>
<div class="w-100 text-right">
    <a class="btn ripple btn-success mt-1 pd-x-30" href="#loadMediaModal" data-dropzone="front_logo"
        data-toggle="modal" data-target="#mediaModal">From Media</a>
</div>
</div>
<div class="col-lg-6 form-group">
<h6 class="card-title mb-1">Admin Logo</h6>
<div style="width: 100%" class="dropzone admin_logo" id="admin_logo"
    data-field="admin_logo">
    <input type="hidden" name="admin_logo">
</div>
<div class="w-100 text-right">
    <a class="btn ripple btn-success mt-1 pd-x-30" href="#loadMediaModal"
        data-dropzone="admin_logo" data-toggle="modal" data-target="#mediaModal">From Media</a>
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
                    <h6 class="card-title mb-1">Icon Logo</h6>
                    <div style="width: 100%" class="dropzone icon_logo" id="icon_logo"
                        data-field="icon_logo">
                        <input type="hidden" name="icon_logo">
                    </div>
                    <div class="w-100 text-right">
                        <a class="btn ripple btn-success mt-1 pd-x-30" href="#loadMediaModal"
                            data-dropzone="icon_logo" data-toggle="modal" data-target="#mediaModal">From Media</a>
                    </div>
                    <div class="mg-t-20">
                        <button class="btn ripple btn-primary pd-x-30" type="submit">Save</button>
                        <a class="btn ripple btn-danger pd-x-30 ml-3" href="{{route('admin.drivers')}}">Cancel</a>
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
    $(function () {
        'use strict'
        $(document).ready(function () {
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
    var frontLogo = '';
    @if(isset($front_logo) && $front_logo-> hasMedia('front_logo'))
    frontLogo = {
        name: "{!! $front_logo->getFirstMedia('front_logo')->name !!}",
        size: "{!! $front_logo->getFirstMedia('front_logo')->size !!}",
        type: "{!! $front_logo->getFirstMedia('front_logo')->mime_type !!}",
        collection_name: "{!! $front_logo->getFirstMedia('front_logo')->collection_name !!}"
    };
    @endif
    var dz_frontLogo = $(".dropzone.front_logo").dropzone({
        url: "{{route('admin.mediascreate')}}",
        addRemoveLinks: true,
        maxFiles: 1,
        init: function () {
            @if(isset($front_logo) && $front_logo-> hasMedia('front_logo'))
            dzInit(this, frontLogo, '{!! url($front_logo->getFirstMediaUrl('front_logo','thumb')) !!}')
            @endif
        },
        accept: function (file, done) {
            dzAccept(file, done, this.element, "{!!config('medialibrary.icons_folder')!!}");
        },
        sending: function (file, xhr, formData) {
            dzSending(this, file, formData, '{!! csrf_token() !!}');
        },
        maxfilesexceeded: function (file) {
            dz_frontLogo[0].mockFile = '';
            dzMaxfile(this, file);
        },
        complete: function (file) {
            dzComplete(this, file, frontLogo, dz_frontLogo[0].mockFile);
            dz_frontLogo[0].mockFile = file;
        },
        removedfile: function (file) {
            dzRemoveFile(
                file, frontLogo, '{!! route("admin.removemedia") !!}',
                'front_logo', '{!! isset($front_logo) ? $front_logo->id : 0 !!}', '{{route("admin.mediadelete")}}',
                '{!! csrf_token() !!}'
            );
        }
    });
    dz_frontLogo[0].mockFile = frontLogo;
    dropzoneFields['front_logo'] = dz_frontLogo;

</script>


<script>
    var adminLogo = '';
    @if(isset($admin_logo) && $admin_logo-> hasMedia('admin_logo'))
    adminLogo = {
        name: "{!! $admin_logo->getFirstMedia('admin_logo')->name !!}",
        size: "{!! $admin_logo->getFirstMedia('admin_logo')->size !!}",
        type: "{!! $admin_logo->getFirstMedia('admin_logo')->mime_type !!}",
        collection_name: "{!! $admin_logo->getFirstMedia('admin_logo')->collection_name !!}"
    };
    @endif
    var dz_adminLogo = $(".dropzone.admin_logo").dropzone({
        url: "{{route('admin.mediascreate')}}",
        addRemoveLinks: true,
        maxFiles: 1,
        init: function () {
            @if(isset($admin_logo) && $admin_logo-> hasMedia('admin_logo'))
            dzInit(this, adminLogo, '{!! url($admin_logo->getFirstMediaUrl('admin_logo','thumb')) !!}')
            @endif
        },
        accept: function (file, done) {
            dzAccept(file, done, this.element, "{!!config('medialibrary.icons_folder')!!}");
        },
        sending: function (file, xhr, formData) {
            dzSending(this, file, formData, '{!! csrf_token() !!}');
        },
        maxfilesexceeded: function (file) {
            dz_adminLogo[0].mockFile = '';
            dzMaxfile(this, file);
        },
        complete: function (file) {
            dzComplete(this, file, adminLogo, dz_adminLogo[0].mockFile);
            dz_adminLogo[0].mockFile = file;
        },
        removedfile: function (file) {
            dzRemoveFile(
                file, adminLogo, '{!! route("admin.removemedia") !!}',
                'admin_logo', '{!! isset($admin_logo) ? $admin_logo->id : 0 !!}', '{{route("admin.mediadelete")}}',
                '{!! csrf_token() !!}'
            );
        }
    });
    dz_adminLogo[0].mockFile = adminLogo;
    dropzoneFields['admin_logo'] = dz_adminLogo;

</script>


<script>
    var iconLogo = '';
    @if(isset($icon_logo) && $icon_logo-> hasMedia('icon_logo'))
    iconLogo = {
        name: "{!! $icon_logo->getFirstMedia('icon_logo')->name !!}",
        size: "{!! $icon_logo->getFirstMedia('icon_logo')->size !!}",
        type: "{!! $icon_logo->getFirstMedia('icon_logo')->mime_type !!}",
        collection_name: "{!! $icon_logo->getFirstMedia('icon_logo')->collection_name !!}"
    };
    @endif
    var dz_iconLogo = $(".dropzone.icon_logo").dropzone({
        url: "{{route('admin.mediascreate')}}",
        addRemoveLinks: true,
        maxFiles: 1,
        init: function () {
            @if(isset($icon_logo) && $icon_logo-> hasMedia('icon_logo'))
            dzInit(this, iconLogo, '{!! url($icon_logo->getFirstMediaUrl('icon_logo','thumb')) !!}')
            @endif
        },
        accept: function (file, done) {
            dzAccept(file, done, this.element, "{!!config('medialibrary.icons_folder')!!}");
        },
        sending: function (file, xhr, formData) {
            dzSending(this, file, formData, '{!! csrf_token() !!}');
        },
        maxfilesexceeded: function (file) {
            dz_iconLogo[0].mockFile = '';
            dzMaxfile(this, file);
        },
        complete: function (file) {
            dzComplete(this, file, iconLogo, dz_iconLogo[0].mockFile);
            dz_iconLogo[0].mockFile = file;
        },
        removedfile: function (file) {
            dzRemoveFile(
                file, iconLogo, '{!! route("admin.removemedia") !!}',
                'icon_logo', '{!! isset($icon_logo) ? $icon_logo->id : 0 !!}', '{{route("admin.mediadelete")}}',
                '{!! csrf_token() !!}'
            );
        }
    });
    dz_iconLogo[0].mockFile = iconLogo;
    dropzoneFields['icon_logo'] = dz_iconLogo;

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
            var mockFile = {
                name: img.data('name'),
                size: img.data('size'),
                type: img.data('type'),
                upload: {
                    uuid: img.data('uuid')
                }
            };
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
                if (status === 'success') {
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
                } else {
                    mediaItems.find('.card.loader').html('Error please refresh page or use (Ctrl+F5)');
                }
            },
            error: function (data, status, error) {
                mediaItems.find('.card.loader').html('Error please refresh page or use (Ctrl+F5)');
            },
            complete: function (data, status) {
                if (status === 'success') {
                    mediaItems.html(items.map(function (item) {
                        return itemTpl.map(render(item)).join('');
                    }));
                    mediaItems.find('.card.loader').remove();
                    initDropzone(dropzoneIndex);
                } else {
                    mediaItems.find('.card.loader').html('Error please refresh page or use (Ctrl+F5)');
                }
            }
        });
    }

    $('#mediaModal').on('show.bs.modal', function (event) {
        triggerButton = $(event.relatedTarget) // Button that triggered the modal
        dropzoneIndex = triggerButton.data('dropzone'); // Extract info from data-* attributes
        loadMedia('{{route("admin.allmedia")}}/' + dropzoneIndex);
        //initSelectCollection();
    });

</script>
@endsection
@section('extras')
<div id="mediaModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
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
