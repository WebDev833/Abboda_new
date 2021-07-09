@foreach($companies as $company)

<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">

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


    <article class="ps-block--store roms--store-item">
         <a href="{{route('store',$company['slug'])}}">
        <div class="ps-block__thumbnail bg--cover" data-background="{{$url_img}}"></div>
      </a>
     

        <div class="ps-block__content">
             
            <div class="ps-block__author"><a class="ps-block__user " href="{{route('store',$company['slug'])}}">
                    <img src="{{$url_img}}" alt="" class="d-none">
                </a></div>
           
            <a href="{{route('store',$company['slug'])}}"> <h4>{{$company['name']}}</h4></a>

        </div>
    </article>

</div>

@endforeach