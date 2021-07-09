@isset($pageConfigs)
{!! Front::updatePageConfig($pageConfigs) !!}
@endisset
@php
$frontSettings = Front::frontSettings();
@endphp
@extends('layouts.static')
@section('content')

      <!---- Image banner--->
      <div class="section onlydesktop">
        @php
            $resturants_banner=Front::GetWidget('resturants_banner');
        @endphp
            @if(isset($resturants_banner))
            {!! $resturants_banner->getTranslation('body',App::getLocale()) !!}
          
                @else
                <img src="{{asset('images/restaurant-sample.png')}}">
                @endif
      </div>


<div class="ps-top-slider wsg-section-wrapper">
    <div class="container">
    <div class="row">
      <div class="col-md-8 col-sm-6 col-12">
      </div>
      <div class="pull-right col-md-4 col-sm-6 col-12">
        <div class="delivery-address">
      @include('panels.search')
        </div>
      </div>
  </div>
    </div>

  </div>
<div class="ps-top-slider wsg-section-wrapper">
  

<!-----slider 1----->
           <div class="ps-container">
              
              <div class="foodtype">
              <ul>
              <li @if($foodtype =='American-Food')class="active"@endif><a href="{{route('restaurants','American-Food')}}">American</a></li>
              <li @if($foodtype =='Mexican-Food')class="active"@endif><a href="{{route('restaurants','Mexican-Food')}}">Mexican</a></li>
              <li @if($foodtype =='Indian-Food')class="active"@endif><a href="{{route('restaurants','Indian-Food')}}">Indian</a></li>
              </ul>
              </div>

<section class="ps-store-box mt-30">
   
    <div class="ps-section__content">
    <div class="infinite-scroll">
        <div class="row" id="contentSelector">
        @if ($companies)
        
            @include('storepanels.store-list-item')

            {{-- @each('storepanels.store-list-item', $companies, 'company') --}}

          
          @else
            <div class="col-md-12">
              <p>We don't find any result for your query..!!!</p>
            </div>
        @endif
        
        </div>
        <div class="ajax-load" id="pagination_loader"></div>
      </div> <!-- infinite scroll end--->
  </div>
</section>

        </div>
      
  <!-----slider 1 end----->

  <!-----slider 4----->
      @if($you_maylike_food->total())
            <div class="ps-container">
              <div class="ps-vendor-best-seller">
              <div class="ps-section__content">
            <div class="ps-slider__title-nav">
              <div class="ps-slider__title">
                <h6 class="notfordesktop">You may like</h6>
                <h4 class="onlydesktop">You may like</h4>
              </div>
                  
                  <div class="ps-section__nav onlydesktop">
                  <a class="ps-carousel__prev" href="#you_maylike_food">
                  <span class="custom-icon"><img src="/images/icon/arrow-left.png" alt="icon-left"></span>
                  </a>
                  <a class="ps-carousel__next" href="#you_maylike_food">
                  <span class="custom-icon"><img src="/images/icon/arrow-right.png" alt="icon-right"></span>
                  </a>
                  </div>
            </div>
                  <div class="owl-slider wsg-slider" id="you_maylike_food" data-owl-auto="false" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="15" data-owl-nav="false" data-owl-dots="false" data-owl-item="4" data-owl-item-xs="1.5" data-owl-item-sm="1.5" data-owl-item-md="4" data-owl-item-lg="4" data-owl-duration="1000" data-owl-mousedrag="on">
       @foreach($you_maylike_food as $company)
            @php
              // need more accurate way
              // just a hotfix. 
              $background = asset(config('roms.store.defaultStoreBanner'));
                  if($company['image'])
                  {
                  //    $background = $company['image'];
                  }

                  $company_m = \App\Models\Company::find($company['id']);
                  $url_img = $background;
                  $media = $company_m->getFirstMedia('store_images');
                  if($media != "")
                  {
                    //$url_img = asset('storage/store_images/'.$media['file_name']);
                    $url_img = asset($media->getUrl());
                   // echo $url_img;
                  }     
             @endphp

      <div class="wsg-slide-item">
        <div class="ps-block--store roms--store-item">
        
        <a href="{{route('store',$company['slug'])}}">
      <div class="ps-block__thumbnail bg--cover" data-background="{{$url_img}}"></div></a>
              <div class="ps-block__content">
                  <div class="ps-block__author"><a class="ps-block__user " href="{{route('store',$company->slug)}}">
                          <img src="{{$url_img}}" alt="" class="d-none">
                      </a><a class="ps-btn" href="{{route('store',$company->slug)}}">ORDER</a>
                    </div>
              <a href="{{route('store',$company['slug'])}}"><h4>{{$company->name}}</h4></a>
              <a href="{{route('store',$company['slug'])}}">
                  <select class="ps-rating" data-read-only="true">
                      @for ($rate = 0; $rate < 5; $rate++)
                        @if($rate < $company->rating) 
                          <option value="1">1</option>
                        @else
                          <option value="2">2</option>
                        @endif
                      @endfor
                  </select>
                </a>
                <a href="{{route('store',$company['slug'])}}">  <span>30-45 Mins Del</span></a>
              </div>
            </div> 
                </div>
              @endforeach
                     
                  </div>
              </div>
          </div>
        </div>
      @endif
            <!-----slider 4 end----->      

</div> <!-------ps-top-slider------->          
@endsection

@section('page-styles')
<style>
 .ps-form--photo-search .ps-form__content{
  padding-bottom: 0px;
 }
 .ps-form--photo-search button{
  right: 25px;
 }
</style>
@endsection