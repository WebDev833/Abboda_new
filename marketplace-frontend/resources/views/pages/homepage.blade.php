@isset($pageConfigs)
    {!! Front::updatePageConfig($pageConfigs) !!}
@endisset
@php
$frontSettings = Front::frontSettings();
$topAreaList = Front::topAreaList()->pluck('name','id');
//$topCompanyTypeList = Front::topCompanyTypeList()->pluck('name','id');
@endphp
@extends('layouts.home')
@section('content')

{{-- Swip slider
<!-- Swiper START -->
<div class="ps-top-slider wsg-section-wrapper">
<div class="pt-60 onlydesktop"></div>
<div class="ps-container">
<div class="ps-vendor-best-sellor">
<div class="ps-section__content">
<div class="ps-slider__title-nav">

  <div class="ps-slider__title">
    <h6 class="notfordesktop">Trending Places Near You</h6>
    <h4 class="onlydesktop">Trending Places Near You</h4>
 
  </div>
  <div class="ps-section__nav onlydesktop">
        <a class="ps-carousel__prev swipprev1" href="#home-ctype-slider-prev">
                  <span class="custom-icon"><img src="/images/icon/arrow-left.png" alt="icon-left"></span>
              </a>
              <a class="ps-carousel__next swipnext1" href="#home-ctype-slider-next">
                <span class="custom-icon"><img src="/images/icon/arrow-right.png" alt="icon-right"></span>
              </a>
</div>
</div>
  
    <!--slide items -->              
    <div class="swiper-container" data-swiper-auto="false" data-swiper-loop="true" data-swiper-speed="5000" data-swiper-gap="15" data-swiper-nav="false"  data-swiper-item="4" data-swiper-item-xs="1.5" data-swiper-item-sm="1.5" data-swiper-item-md="2.5" data-swiper-item-lg="4" data-swiper-duration="1000" data-swiper-mousedrag="on"  data-swiper-offset="0"  data-swiper-freeMode="false" data-swiper-centeredSlides="false" data-swiper-nav-prev=".swipprev1" data-swiper-nav-next=".swipnext1">
  <div class="swiper-wrapper">
    <div class="swiper-slide">
    <div class="wsg-slide-item">
                    <div class="wsg-slide-item__thumbnail">
                      <a href="/medical-stores"><img src="/defaults/store/vendor.jpg" alt=""></a></div>
                      <div class="wsg-slide-item__container">
                          <div class="wsg-slide-item__content">
                            <a class="wsg-slide-item__title" href="/medical-stores"><h6>Abrar’s bake shop</h6></a>
<p class="resturant-desc color-medium">Two lined short start description of the restaurant. </p>
        </div>
                </div>
               </div>
     </div>
    <div class="swiper-slide">
    <div class="wsg-slide-item">
                    <div class="wsg-slide-item__thumbnail">
                      <a href="/medical-stores"><img src="/defaults/store/vendor.jpg" alt=""></a></div>
                      <div class="wsg-slide-item__container">
                          <div class="wsg-slide-item__content">
                            <a class="wsg-slide-item__title" href="/medical-stores"><h6>Abrar’s bake shop</h6></a>
<p class="resturant-desc color-medium">Two lined short description of the restaurant. </p>
        </div>
                </div>
               </div>
    
    
    </div>
    <div class="swiper-slide">
    <div class="wsg-slide-item">
                    <div class="wsg-slide-item__thumbnail">
                      <a href="/medical-stores"><img src="/defaults/store/vendor.jpg" alt=""></a></div>
                      <div class="wsg-slide-item__container">
                          <div class="wsg-slide-item__content">
                            <a class="wsg-slide-item__title" href="/medical-stores"><h6>Abrar’s bake shop</h6></a>
<p class="resturant-desc color-medium">Two lined short description of the restaurant. </p>
        </div>
                </div>
               </div>
    </div>
    <div class="swiper-slide">
    <div class="wsg-slide-item">
                    <div class="wsg-slide-item__thumbnail">
                      <a href="/medical-stores"><img src="/defaults/store/vendor.jpg" alt=""></a></div>
                      <div class="wsg-slide-item__container">
                          <div class="wsg-slide-item__content">
                            <a class="wsg-slide-item__title" href="/medical-stores"><h6>Abrar’s bake shop</h6></a>
<p class="resturant-desc color-medium">Two lined short description of the restaurant. </p>
        </div>
                </div>
               </div>
    </div>
    <div class="swiper-slide">
    <div class="wsg-slide-item">
                    <div class="wsg-slide-item__thumbnail">
                      <a href="/medical-stores"><img src="/defaults/store/vendor.jpg" alt=""></a></div>
                      <div class="wsg-slide-item__container">
                          <div class="wsg-slide-item__content">
                            <a class="wsg-slide-item__title" href="/medical-stores"><h6>Abrar’s bake shop</h6></a>
<p class="resturant-desc color-medium">Two lined short description of the restaurant. </p>
        </div>
                </div>
               </div>
    </div>
    <div class="swiper-slide">
    <div class="wsg-slide-item">
                    <div class="wsg-slide-item__thumbnail">
                      <a href="/medical-stores"><img src="/defaults/store/vendor.jpg" alt=""></a></div>
                      <div class="wsg-slide-item__container">
                          <div class="wsg-slide-item__content">
                            <a class="wsg-slide-item__title" href="/medical-stores"><h6>Abrar’s bake shop</h6></a>
<p class="resturant-desc color-medium">Two lined short end description of the restaurant. </p>
        </div>
                </div>
               </div>
    </div>

  </div>
  
  <div class="swiper-pagination12"></div>
</div>
<!-- Swiper END -->

</div>  
</div>
</div>
</div> --}}
{{-- slick slider
<div class="ps-top-slider wsg-section-wrapper">
<div class="pt-60 onlydesktop"></div>
<div class="ps-container">
<div class="ps-vendor-best-sellor">
<div class="ps-section__content">
 <div class="ps-slider__title-nav">

	<div class="ps-slider__title">
		<h6 class="notfordesktop">Trending Places Near You</h6>
		<h4 class="onlydesktop">Trending Places Near You</h4>
	</div>

<div class="ps-section__nav onlydesktop">
				<a class="ps-carousel__prev" href="javascript:void(0)" id="slick-prev">
                  <span class="custom-icon"><img src="/images/icon/arrow-left.png" alt="icon-left"></span>
              </a>
              <a class="ps-carousel__next" href="javascript:void(0)" id="slick-next">
                <span class="custom-icon"><img src="/images/icon/arrow-right.png" alt="icon-right"></span>
              </a>
</div>
</div>
<div class="slick-slider" data-prev="#slick-prev" data-next="#slick-next" data-slick='{
   "draggable":true,
   "accessibility":false,
   "variableWidth":false,
   "slidesToShow":4,
   "slidesToScroll":1,
   "arrows":true,
   "dots":false,
   "swipeToSlide":true,
   "speed":300,
   "infinite":true,
   "responsive":[
      {
         "breakpoint":2000,
         "settings":{
            "slidesToShow":4,
            "slidesToScroll":1
         }
      },
      {
         "breakpoint":768,
         "settings":{
            "slidesToShow":2,
            "slidesToScroll":1
         }
      },
      {
         "breakpoint":480,
         "settings":{
            "slidesToShow":1,
            "slidesToScroll":1
         }
      },
      {
         "breakpoint":0,
         "settings":{
            "slidesToShow":1,
            "slidesToScroll":1
         }
      }
   ]
}'>
  

<div class="wsg-slide-item">
                    <div class="wsg-slide-item__thumbnail">
                      <a href="/medical-stores"><img src="/storage/18977/image-%2814%29.png" alt=""></a></div>
                      <div class="wsg-slide-item__container">
                          <div class="wsg-slide-item__content">
                            <a class="wsg-slide-item__title" href="/medical-stores"><h6>Start Abrar’s bake shop</h6></a>
<p class="resturant-desc color-medium">Two lined short description of the restaurant. </p>
				</div>
                </div>
               </div>
<div class="wsg-slide-item">
                    <div class="wsg-slide-item__thumbnail">
                      <a href="/medical-stores"><img src="/storage/18977/image-%2814%29.png" alt=""></a></div>
                      <div class="wsg-slide-item__container">
                          <div class="wsg-slide-item__content">
                            <a class="wsg-slide-item__title" href="/medical-stores"><h6>Abrar’s bake shop</h6></a>
<p class="resturant-desc color-medium">Two lined short description of the restaurant. </p>
				</div>
                </div>
               </div>
<div class="wsg-slide-item">
                    <div class="wsg-slide-item__thumbnail">
                      <a href="/medical-stores"><img src="/storage/18977/image-%2814%29.png" alt=""></a></div>
                      <div class="wsg-slide-item__container">
                          <div class="wsg-slide-item__content">
                            <a class="wsg-slide-item__title" href="/medical-stores"><h6>Abrar’s bake shop</h6></a>
<p class="resturant-desc color-medium">Two lined short description of the restaurant. </p>
				</div>
                </div>
               </div>
<div class="wsg-slide-item">
                    <div class="wsg-slide-item__thumbnail">
                      <a href="/medical-stores"><img src="/storage/18977/image-%2814%29.png" alt=""></a></div>
                      <div class="wsg-slide-item__container">
                          <div class="wsg-slide-item__content">
                            <a class="wsg-slide-item__title" href="/medical-stores"><h6>Abrar’s bake shop</h6></a>
<p class="resturant-desc color-medium">Two lined short description of the restaurant. </p>
				</div>
                </div>
               </div>
<div class="wsg-slide-item">
                    <div class="wsg-slide-item__thumbnail">
                      <a href="/medical-stores"><img src="/storage/18977/image-%2814%29.png" alt=""></a></div>
                      <div class="wsg-slide-item__container">
                          <div class="wsg-slide-item__content">
                            <a class="wsg-slide-item__title" href="/medical-stores"><h6>Abrar’s bake shop</h6></a>
<p class="resturant-desc color-medium">Two lined short description of the restaurant. </p>
				</div>
                </div>
               </div>
<div class="wsg-slide-item">
                    <div class="wsg-slide-item__thumbnail">
                      <a href="/medical-stores"><img src="/storage/18977/image-%2814%29.png" alt=""></a></div>
                      <div class="wsg-slide-item__container">
                          <div class="wsg-slide-item__content">
                            <a class="wsg-slide-item__title" href="/medical-stores"><h6>Abrar’s bake shop</h6></a>
<p class="resturant-desc color-medium">Two lined short description of the restaurant. </p>
				</div>
                </div>
               </div>
<div class="wsg-slide-item">
                    <div class="wsg-slide-item__thumbnail">
                      <a href="/medical-stores"><img src="/storage/18977/image-%2814%29.png" alt=""></a></div>
                      <div class="wsg-slide-item__container">
                          <div class="wsg-slide-item__content">
                            <a class="wsg-slide-item__title" href="/medical-stores"><h6> END Abrar’s bake shop</h6></a>
<p class="resturant-desc color-medium">Two lined short description of the restaurant. </p>
				</div>
                </div>
               </div>
</div>
 </div>
 </div>
 </div>
 --}}


 @if ($pageConfigs['sections'])
                    @foreach ($pageConfigs['sections'] as $section)
                        {!!$section->content!!}
                    @endforeach
                @endif


                <div class="ps-top-slider wsg-section-wrapper wsg-sec-py onlydesktop  bg-search" style="background-image:url({{asset('images/footerimage.jpg')}})" >
  
    <div class="row">
     
      <div class="col-md-6 m-auto text-white">
        <div class="wsg-block-text">
          <h2 class="ready text-white">Ready to order?</h2>
          <div class="w-content">
            <p>Browse local restaurants and businesses for delivery 
            by entering your address below
            </p>     
          </div>
          <div class="ps-section__header order">
              
              
<div class="ps-form__content">
    
    
    <div class="form-group form-group--icon">
    <div class="ps-section__header">
              @if ($errors->any())
              <div class="alert alert-danger mb-4">
              <button type="button" class="close" data-dismiss="alert">×</button>
              @foreach ($errors->all() as $error)
              {{ $error }}
              @endforeach
              </div>
              @endif

              @include('panels.search')

          </div>
    </div>
  
   
</div>




          </div>
        </div>
      </div>


    </div>
 
</div>



@endsection
