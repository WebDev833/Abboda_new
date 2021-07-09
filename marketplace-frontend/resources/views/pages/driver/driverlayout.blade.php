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
<div class="ps-page--single ps-page--vendor mt-5">
    <section class="ps-store-list pt-0 roms--dashboard">
        <div class="my-container ps-container">

            @yield('drivermapsection')

            <div class="ps-section__wrapper">

                <div class="ps-section__left @if($frontSettings['showProfileSidebar'] == false) {{ 'd-none'}} @endif onlydesktop">
                <div class="ps-block--vendor">
                        
                        <div class="ps-block__container">
    
                            
                            <div class="ps-block__footer">
                                <a class="btn btn-white ps-btn ps-btn--fullwidth text-subtitle <?php if($page=='driver'){?> active <?php }else{ ?> nonactive <?php } ?>"    href="{{route('driver.dashboard')}}"><i class="icon"><img src="{{asset('images/user.png')}}" class="nonactive-image" alt=""><img src="{{asset('images/profile-icon.png')}}" class="active-image" alt=""></i>Profile</a>
                            </div>
                            <div class="ps-block__footer">
                                <a class="btn btn-white ps-btn ps-btn--fullwidth text-subtitle <?php if($page=='new-orders'){?> active <?php }else{ ?> nonactive <?php } ?>"  href="{{route('driver.neworders')}}"><i class="icon"><img src="{{asset('images/orders-icon.png')}}" class="nonactive-image" alt=""><img src="{{asset('images/order-icon-white.png')}}" class="active-image" alt=""></i> New Orders</a>
                            </div>
                            <div class="ps-block__footer">
                                <a class="btn btn-white ps-btn ps-btn--fullwidth text-subtitle <?php if($page=='my-orders'){?> active <?php }else{ ?> nonactive <?php } ?>"  href="{{route('driver.myorders')}}"><i class="icon"><img src="{{asset('images/orders-icon.png')}}" class="nonactive-image" alt=""><img src="{{asset('images/order-icon-white.png')}}" class="active-image" alt=""></i> My Orders</a>
                            </div>
                            <div class="ps-block__footer">
                                <a class="btn btn-white ps-btn ps-btn--fullwidth text-subtitle <?php if($page=='my-earnings'){?> active <?php }else{ ?> nonactive <?php } ?>"  href="{{route('driver.myearnings')}}"><i class="icon"><img src="{{asset('images/location-icon.png')}}" class="nonactive-image" alt=""><img src="{{asset('images/location-icon-white.png')}}" class="active-image" alt=""></i>My Earnings</a>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="ps-block--vendor">
                        <div class="ps-block__thumbnail"><img src="{{  asset('img/users/our-team/4.jpg')}}" alt="">
                        </div>
                        <div class="ps-block__container">
                            <div class="ps-block__header">
                              @php
                                  $user = json_decode($user->toJson());
                              @endphp
                                <h4>{{$user->name}}</h4>
                            </div>
                            <span class="ps-block__divider"></span>
                            <div class="ps-block__content">
                                <p><strong>Phone : </strong> {{$user->phone}}</p>
                                <p><strong>Email : </strong> {{$user->email}}</p>
                                <p><strong>Vehicle : </strong> {{$user->vehicle}}</p>
                                <p><strong>Gender : </strong> {{ucfirst($user->gender)}}</p>
                                <p><strong>Age : </strong> {{$user->age}}</p>
                            </div>
                            <div class="ps-block__footer">
                                <a class="ps-btn ps-btn--fullwidth" href="{{route('driver.editProfilepage')}}"><i class="fa fa-pencil"></i> Edit Profile</a>
                            </div>
                        </div>
                    </div> -->
                </div>

                <div class="ps-section__right">
                  @yield('driverpage')
                </div>

            </div>
        </div>
    </section>
</div>
@endsection
