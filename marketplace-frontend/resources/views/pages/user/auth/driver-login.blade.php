@isset($pageConfigs)
{!! Front::updatePageConfig($pageConfigs) !!}
@endisset
@php
$frontSettings = Front::frontSettings();
@endphp
@extends('layouts.static')
@section('content')
<div class="ps-my-account">
    <div class="container">
        {!! Form::open(['route'=>'login', 'method'=>'POST','class'=>'ps-form--account ps-tab-root']) !!}
        <ul class="ps-tab-list d-none">
            <li class="active"><a href="#sign-in">Login</a></li>
            <li><a href="#register">Register</a></li>
        </ul>
        <div class="ps-tabs" id="roms--login">
            <div class="ps-tab active" id="sign-in">
                <div class="ps-form__content">
                    <h5>{{ trans('front.log_in_to_your_account') }}</h5>
                    @include('panels.errors')
                    <div class="form-group">
                        {!! Form::email('email', old('email'),
                        ["class"=>"form-control","placeholder"=>trans('front.enter_your_email')]) !!}
                    </div>
                    <div class="form-group form-forgot">
                        {!! Form::password('password', ['class'=>'form-control','placeholder'=>
                        trans('front.enter_your_password')]) !!}
                        <a href="{{ route('forgotpasswordpage')}}">{{ trans('front.login_forgot_text') }}</a>
                    </div>
                    <div class="form-group">
                        <div class="ps-checkbox">
                            {!! Form::checkbox('remember',old('remember') ? 'checked' : '',old('remember') ? 'checked' :
                            '', ["id"=>"remember-me","class"=>"form-control"]) !!}
                            <label for="remember-me">{{ trans('front.login_remember_me_text') }}</label>
                        </div>
                    </div>
                    <div class="form-group submtit">
                        <button type="submit"
                            class="ps-btn ps-btn--fullwidth">{{ trans('front.login_button_text') }}</button>
                      
                    </div>
                    <a href="{{route('register')}}" >{{ trans('front.donot_have_an_account_text') }}</a>
                </div>
                <div class="ps-form__footer">
                    <p>{{ trans('front.connect_with_text') }} :</p>
                    <ul class="ps-list--social">
                        <li><a class="facebook" href="{{route('socialLogin',['provider'=>'facebook'])}}"><i class="fa fa-facebook"></i> {{ trans('front.facebook_text') }}</a></li>
                        <li><a class="google" href="{{route('socialLogin',['provider'=>'google'])}}"><i class="fa fa-google-plus"></i> {{ trans('front.google_text') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
