@isset($pageConfigs)
{!! Front::updatePageConfig($pageConfigs) !!}
@endisset
@php
$frontSettings = Front::frontSettings();
@endphp
@extends('layouts.static')
@section('content')
<div class="ps-page--single ps-page--vendor mt-5">
    <section class="ps-store-list pt-0 roms--dashboard">
        <div class="container">
            <div class="ps-section__wrapper">
                <div class="ps-section__left @if($frontSettings['showProfileSidebar'] == false) {{ 'd-none'}} @endif ">
                    <div class="ps-block--vendor">
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
                                <p><strong>Phone</strong> {{$user->phone}}</p>
                                <p><strong>Email</strong> {{$user->email}}</p>
                            </div>
                            <div class="ps-block__footer">
                                <a class="ps-btn ps-btn--fullwidth" href="{{route('user.editProfilepage')}}"><i class="fa fa-pencil"></i> Edit Profile</a>
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
