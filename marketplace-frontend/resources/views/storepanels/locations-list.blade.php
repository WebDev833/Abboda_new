
<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
@php
      // need more accurate way
      // just a hotfix. 
      $background = asset(config('roms.store.defaultStoreBanner'));
          if($companies['image'])
          {
          //    $background = $companies['image'];
          }

          $company_m = \App\Models\Company::find($companies['id']);
          $url_img = $background;
          $media = $company_m->getFirstMedia('store_images');
          if($media != "")
          {
            //$url_img = asset('storage/store_images/'.$media['file_name']);
            $url_img = asset($media->getUrl());
           // echo $url_img;
          }     
      @endphp


<article class="ps-block--store roms--store-item">
     <a href="{{route('store',$companies['slug'])}}">
    <div class="ps-block__thumbnail bg--cover" data-background="{{$url_img}}"></div>
  </a>
 
    <div class="ps-block__content">
         
        <div class="ps-block__author"><a class="ps-block__user " href="{{route('store',$companies['slug'])}}">
                <img src="{{$url_img}}" alt="" class="d-none">
            </a><!-- <a class="ps-btn" href="{{route('store',$companies['slug'])}}">ORDER</a>--></div>
       
        <a href="{{route('store',$companies['slug'])}}"> <h4>{{$companies['name']}}</h4></a>
        <P class="color-medium text-body">{{$companies['address']}}</P>
    </div>
</article>

</div>


@if ($companies->locations->count())
            @foreach ($companies->locations as $location)
<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">

@php
      // need more accurate way
      // just a hotfix. 
      $background = asset(config('roms.store.defaultStoreBanner'));
          if($companies['image'])
          {
          //    $background = $companies['image'];
          }

          $company_m = \App\Models\Company::find($companies['id']);
          $url_img = $background;
          $media = $company_m->getFirstMedia('store_images');
          if($media != "")
          {
            //$url_img = asset('storage/store_images/'.$media['file_name']);
            $url_img = asset($media->getUrl());
           // echo $url_img;
          }     
      @endphp

<article class="ps-block--store roms--store-item">
     <a href="{{route('store',$location['slug'])}}">
    <div class="ps-block__thumbnail bg--cover" data-background="{{$url_img}}"></div>
  </a>
 
    <div class="ps-block__content">
         
        <div class="ps-block__author"><a class="ps-block__user " href="{{route('store',$location['slug'])}}">
                <img src="" alt="" class="d-none">
            </a><!-- <a class="ps-btn" href="{{route('store',$companies['slug'])}}">ORDER</a>--></div>
       
        <a href="{{route('store',$location['slug'])}}"> <h4>{{$companies['name']}}</h4></a>
       <P class="color-medium text-body">{{$location['address']}}</P>
    </div>
</article>

</div>
@endforeach

@endif