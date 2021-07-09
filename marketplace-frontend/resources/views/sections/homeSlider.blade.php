<div id="homepage-photo">
     
    <div class="ps-home-search bg--cover" >
        <div class="ps-section__wrapper">
            <h3 class="onlydesktop">We Deliver Anything, Anywhere! </h3>
            
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
<hr class="notfordesktop">
{{-- Slider Bottom Note Bar 
<div class="roms--home-call mb-5">
    <div class="ps-container">
      <div class="roms--home-call">
        <div class="roms--home-call-left">
          <h4>
            <span>Lorem Ipsum is simply dummy text of the printing and typesetting industry!</span>
          </h4>
        </div>
        <div class="roms--home-call-right">
          <a href="javascript:void(0);">Contact Us</a>
        </div>
      </div>
    </div>
</div>--}}