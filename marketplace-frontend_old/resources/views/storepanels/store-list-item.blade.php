<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
    <article class="ps-block--store roms--store-item">
      @php
      // need more accurate way
      // just a hotfix. 
      $background = asset(config('roms.store.defaultStoreBanner'));
          if($company['image'])
          {
              $background = $company['image'];
          }
      @endphp
        <div class="ps-block__thumbnail bg--cover" data-background="{{$background}}"></div>
        <div class="ps-block__content">
            <div class="ps-block__author"><a class="ps-block__user " href="javascript:void(0);">
                    <img src="{{ asset('img/vendor/store/user/3.jpg') }}" alt="" class="d-none">
                </a><a class="ps-btn" href="{{route('store',$company['slug'])}}">Visit Store</a></div>
            <h4>{{$company['name']}}</h4>
            <select class="ps-rating" data-read-only="true">
                @for ($rate = 0; $rate < 5; $rate++)
                  @if($rate < $company['rating']) 
                    <option value="1">1</option>
                  @else
                    <option value="2">2</option>
                  @endif
                @endfor
            </select>
            <p>{{ $company['address'] }}</p>
        </div>
    </article>
</div>
