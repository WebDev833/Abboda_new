@isset($pageConfigs)
{!! Front::updatePageConfig($pageConfigs) !!}
@endisset
@php
$frontSettings = Front::frontSettings();
@endphp
@extends('layouts.static')
@section('content')
<?php
    $link = $_SERVER['PHP_SELF'];
    $link_array = explode('/',$link);
    $page = end($link_array);
?>
<div class="ps-page--single ps-page--vendor">
    <section class="ps-store-list pt-0 roms--dashboard">
        <div class="my-container ps-container">
            <div class="ps-section__wrapper">
              <div class="ps-section__left @if($frontSettings['showProfileSidebar'] == false) {{ 'd-none'}} @endif onlydesktop">
                    <div class="ps-block--vendor">
                        
                        <div class="ps-block__container">
    
                            
                            <div class="ps-block__footer">
                                <a class="btn btn-white ps-btn ps-btn--fullwidth text-subtitle <?php if($page=='edit-profile'){?> active <?php }else{ ?> nonactive <?php } ?>"    href="{{route('user.editProfilepage')}}"><i class="icon"><img src="{{asset('images/user.png')}}" class="nonactive-image" alt=""><img src="{{asset('images/profile-icon.png')}}" class="active-image" alt=""></i>Profile</a>
                            </div>
                            <div class="ps-block__footer">
                                <a class="btn btn-white ps-btn ps-btn--fullwidth text-subtitle <?php if($page=='my-orders'){?> active <?php }else{ ?> nonactive <?php } ?>"  href="{{route('user.myorders')}}"><i class="icon"><img src="{{asset('images/orders-icon.png')}}" class="nonactive-image" alt=""><img src="{{asset('images/order-icon-white.png')}}" class="active-image" alt=""></i> My Orders</a>
                            </div>
                            <div class="ps-block__footer">
                                <a class="btn btn-white ps-btn ps-btn--fullwidth text-subtitle <?php if($page=='my-addresses'){?> active <?php }else{ ?> nonactive <?php } ?>"  href="{{route('user.addressBook')}}"><i class="icon"><img src="{{asset('images/location-icon.png')}}" class="nonactive-image" alt=""><img src="{{asset('images/location-icon-white.png')}}" class="active-image" alt=""></i>Addresses</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ps-section__right">
                  @yield('userpage')
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('page-scripts')
<!-- <script>
$(document).on("click","#btn-active",function() {
    $("#btn-active").removeClass("btn btn-danger");
    $(this).addClass("btn btn-danger");
    
});
</script> -->

@endsection
